<?php

namespace Database\Factories;

use App\Enums\ContractStatus;
use App\Models\Contract;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contract>
 */
class ContractFactory extends Factory
{
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-6 months', 'now');
        $endDate = (clone $startDate)->modify('+1 year');

        return [
            'tenant_id' => Tenant::factory(),
            'unit_name' => $this->faker->word(),
            'customer_name' => $this->faker->name(),
            'rent_amount' => $this->faker->randomFloat(2, 500, 5000),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $this->faker->randomElement(ContractStatus::cases()),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
