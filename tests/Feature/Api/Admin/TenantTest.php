<?php

namespace Tests\Feature\Api\Admin;

use App\Models\Tenant;
use App\Models\User;
use App\Tenancy\TenantContext;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TenantTest extends TestCase
{
    private string $tenantsRoute;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tenantsRoute = '/api/admin/tenants';
    }

    public function test_admin_can_list_tenants(): void
    {
        // Arrange
        $this->authenticateAdmin();
        $firstTenant = Tenant::factory()->create();
        $secondTenant = Tenant::factory()->create();

        // Act
        $response = $this->getJson($this->tenantsRoute);

        // Assert
        $response->assertSuccessful()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Tenants fetched successfully')
            ->assertJsonCount(2, 'items');

        $itemIds = collect($response->json('items'))->pluck('id');
        $this->assertTrue($itemIds->contains($firstTenant->id));
        $this->assertTrue($itemIds->contains($secondTenant->id));
    }

    public function test_admin_can_show_tenant(): void
    {
        // Arrange
        $this->authenticateAdmin();
        $tenant = Tenant::factory()->create();

        // Act
        $response = $this->getJson($this->tenantShowRoute($tenant->id));

        // Assert
        $response->assertSuccessful()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Tenant fetched successfully')
            ->assertJsonPath('item.id', $tenant->id)
            ->assertJsonPath('item.name', $tenant->name)
            ->assertJsonPath('item.domain', $tenant->domain);
    }

    public function test_admin_can_create_tenant(): void
    {
        // Arrange
        $this->authenticateAdmin();
        $payload = [
            'name' => $this->faker->company(),
            'domain' => $this->faker->unique()->domainName(),
        ];

        // Act
        $response = $this->postJson($this->tenantsRoute, $payload);

        // Assert
        $response->assertSuccessful()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Tenant created successfully')
            ->assertJsonPath('item.name', $payload['name'])
            ->assertJsonPath('item.domain', $payload['domain']);

        $this->assertDatabaseHas('tenants', [
            'name' => $payload['name'],
            'domain' => $payload['domain'],
        ]);
    }

    public function test_admin_can_update_tenant(): void
    {
        // Arrange
        $this->authenticateAdmin();
        $tenant = Tenant::factory()->create();
        $payload = [
            'name' => $this->faker->company(),
            'domain' => $this->faker->unique()->domainName(),
        ];

        // Act
        $response = $this->putJson($this->tenantShowRoute($tenant->id), $payload);

        // Assert
        $response->assertSuccessful()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Tenant updated successfully')
            ->assertJsonPath('item.id', $tenant->id)
            ->assertJsonPath('item.name', $payload['name'])
            ->assertJsonPath('item.domain', $payload['domain']);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'name' => $payload['name'],
            'domain' => $payload['domain'],
        ]);
    }

    public function test_tenant_store_validates_required_fields(): void
    {
        // Arrange
        $this->authenticateAdmin();

        // Act
        $response = $this->postJson($this->tenantsRoute, []);

        // Assert
        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'domain']);
    }

    public function test_tenant_update_validates_unique_domain(): void
    {
        // Arrange
        $this->authenticateAdmin();
        $tenantToUpdate = Tenant::factory()->create();
        $existingTenant = Tenant::factory()->create();

        // Act
        $response = $this->putJson($this->tenantShowRoute($tenantToUpdate->id), [
            'domain' => $existingTenant->domain,
        ]);

        // Assert
        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['domain']);
    }

    public function test_non_admin_cannot_access_tenant_endpoints(): void
    {
        // Arrange
        Sanctum::actingAs($this->createTenantUser());
        $tenant = Tenant::factory()->create();

        // Act
        $indexResponse = $this->getJson($this->tenantsRoute);
        $showResponse = $this->getJson($this->tenantShowRoute($tenant->id));
        $storeResponse = $this->postJson($this->tenantsRoute, [
            'name' => $this->faker->company(),
            'domain' => $this->faker->unique()->domainName(),
        ]);
        $updateResponse = $this->putJson($this->tenantShowRoute($tenant->id), [
            'name' => $this->faker->company(),
        ]);

        // Assert
        $indexResponse->assertForbidden()->assertJsonPath('success', false);
        $showResponse->assertForbidden()->assertJsonPath('success', false);
        $storeResponse->assertForbidden()->assertJsonPath('success', false);
        $updateResponse->assertForbidden()->assertJsonPath('success', false);
    }

    public function test_tenant_endpoints_require_authentication(): void
    {
        // Arrange
        $tenant = Tenant::factory()->create();

        // Act
        $indexResponse = $this->getJson($this->tenantsRoute);
        $showResponse = $this->getJson($this->tenantShowRoute($tenant->id));
        $storeResponse = $this->postJson($this->tenantsRoute, [
            'name' => $this->faker->company(),
            'domain' => $this->faker->unique()->domainName(),
        ]);
        $updateResponse = $this->putJson($this->tenantShowRoute($tenant->id), [
            'name' => $this->faker->company(),
        ]);

        // Assert
        $indexResponse->assertUnauthorized();
        $showResponse->assertUnauthorized();
        $storeResponse->assertUnauthorized();
        $updateResponse->assertUnauthorized();
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

    private function tenantShowRoute(int $tenantId): string
    {
        return "{$this->tenantsRoute}/{$tenantId}";
    }
}
