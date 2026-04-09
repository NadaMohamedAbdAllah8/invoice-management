<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::query()->updateOrCreate(
            ['name' => 'System Admin'],
            ['name' => 'System Admin']
        );
    }
}
