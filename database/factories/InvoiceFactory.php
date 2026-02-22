<?php

namespace Database\Factories;

use App\Enums\InvoiceStatus;
use App\Models\Contract;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 500, 5000);
        $taxAmount = round($subtotal * 0.15, 2);
        $total = round($subtotal + $taxAmount, 2);

        return [
            'contract_id' => Contract::factory(),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $total,
            'status' => $this->faker->randomElement(InvoiceStatus::cases()),
            'due_date' => $this->faker->dateTimeBetween('now', '+30 days'),
            'paid_at' => null,
        ];
    }
}
