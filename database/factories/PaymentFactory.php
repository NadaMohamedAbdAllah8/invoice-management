<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'amount' => $this->faker->randomFloat(2, 50, 5000),
            'payment_method' => $this->faker->randomElement(PaymentMethod::cases()),
            'reference_number' => $this->faker->word(),
            'paid_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
