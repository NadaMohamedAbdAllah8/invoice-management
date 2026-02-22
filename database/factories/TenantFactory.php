<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tenant>
 */
class TenantFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'domain' => $this->faker->unique()->domainName(),
        ];
    }
}
