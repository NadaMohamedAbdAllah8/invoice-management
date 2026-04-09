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
            ['email' => 'admin@invoice.test'],
            ['name' => 'System Admin', 'password' => 'Admin123']
        );
    }
}
