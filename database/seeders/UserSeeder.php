<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'user@invoicemanagement.test'],
            [
                'name' => 'System User',
                'password' => Hash::make('User123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
