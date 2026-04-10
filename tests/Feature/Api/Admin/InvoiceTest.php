<?php

namespace Tests\Feature\Api\Admin;

use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\User;
use App\Tenancy\TenantContext;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    private string $adminInvoicesRoute;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminInvoicesRoute = '/api/admin/invoices';
    }

    public function test_admin_can_list_invoices_for_requested_contract_id(): void
    {
        // Arrange
        $this->authenticateAdmin();

        $firstTenant = Tenant::factory()->create();
        $secondTenant = Tenant::factory()->create();

        $firstInvoice = $this->createInvoiceForTenant($firstTenant);
        $secondInvoice = $this->createInvoiceForTenant($secondTenant);

        // Act
        $response = $this->getJson("{$this->adminInvoicesRoute}?contract_id={$firstInvoice->contract_id}");

        // Assert
        $response->assertSuccessful()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Invoices fetched successfully')
            ->assertJsonPath('size', 1);
        $response->assertJsonCount(1, 'items');

        $itemIds = collect($response->json('items'))->pluck('id');
        $this->assertTrue($itemIds->contains($firstInvoice->id));
        $this->assertFalse($itemIds->contains($secondInvoice->id));
    }

    public function test_admin_can_show_invoice_across_tenants(): void
    {
        // Arrange
        $this->authenticateAdmin();
        $tenant = Tenant::factory()->create();
        $invoice = $this->createInvoiceForTenant($tenant);

        // Act
        $response = $this->getJson($this->invoiceShowRoute($invoice->id));

        // Assert
        $response->assertSuccessful()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Invoice fetched successfully')
            ->assertJsonPath('item.id', $invoice->id)
            ->assertJsonPath('item.invoice_number', $invoice->invoice_number);
    }

    public function test_admin_invoice_index_requires_authentication(): void
    {
        // Act
        $response = $this->getJson($this->adminInvoicesRoute);

        // Assert
        $response->assertUnauthorized();
    }

    public function test_non_admin_cannot_access_admin_invoice_index(): void
    {
        // Arrange
        Sanctum::actingAs($this->createTenantUser());

        // Act
        $response = $this->getJson($this->adminInvoicesRoute);

        // Assert
        $response->assertForbidden()
            ->assertJsonPath('success', false);
    }

    public function test_admin_invoice_show_requires_authentication(): void
    {
        // Arrange
        $tenant = Tenant::factory()->create();
        $invoice = $this->createInvoiceForTenant($tenant);

        // Act
        $response = $this->getJson($this->invoiceShowRoute($invoice->id));

        // Assert
        $response->assertUnauthorized();
    }

    public function test_non_admin_cannot_access_admin_invoice_show(): void
    {
        // Arrange
        Sanctum::actingAs($this->createTenantUser());
        $tenant = Tenant::factory()->create();
        $invoice = $this->createInvoiceForTenant($tenant);

        // Act
        $response = $this->getJson($this->invoiceShowRoute($invoice->id));

        // Assert
        $response->assertForbidden()
            ->assertJsonPath('success', false);
    }

    public function test_admin_invoice_show_returns_not_found_for_missing_invoice(): void
    {
        // Arrange
        $this->authenticateAdmin();

        // Act
        $response = $this->getJson($this->invoiceShowRoute(999999));

        // Assert
        $response->assertNotFound();
    }

    private function createInvoiceForTenant(Tenant $tenant): Invoice
    {
        app(TenantContext::class)->setTenantId($tenant->id);

        $contract = Contract::query()->create([
            'tenant_id' => $tenant->id,
            'unit_name' => 'A-101',
            'customer_name' => $this->faker->name(),
            'rent_amount' => 1000.00,
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'status' => ContractStatus::ACTIVE->value,
        ]);

        return Invoice::query()->create([
            'tenant_id' => $tenant->id,
            'contract_id' => $contract->id,
            'invoice_number' => 'INV-TEST-'.$this->faker->unique()->bothify('??##??##'),
            'subtotal' => 1000.00,
            'tax_amount' => 150.00,
            'total' => 1150.00,
            'status' => InvoiceStatus::PENDING->value,
            'due_date' => '2026-12-01',
        ]);
    }

    private function createTenantUser(): User
    {
        $tenant = Tenant::factory()->create();
        app(TenantContext::class)->setTenantId($tenant->id);

        return User::query()->create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password123'),
            'tenant_id' => $tenant->id,
        ]);
    }

    private function invoiceShowRoute(int $invoiceId): string
    {
        return "{$this->adminInvoicesRoute}/{$invoiceId}";
    }
}
