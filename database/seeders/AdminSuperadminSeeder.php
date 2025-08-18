<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSuperadminSeeder extends Seeder
{
    /**
     * Seed the admin and superadmin users.
     */
    public function run(): void
    {
        // Create Superadmin
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super@gmail.com',
            'role' => 0,
            'password' => bcrypt('admin123'),
        ]);

        // Create Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 1,
            'password' => bcrypt('admin123'),
        ]);
    }
}
