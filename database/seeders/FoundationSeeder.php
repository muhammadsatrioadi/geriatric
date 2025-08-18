<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Foundation;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FoundationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create foundations
        $foundations = [
            [
                'name' => 'Yayasan Peduli Lansia Indonesia',
                'slug' => 'yayasan-peduli-lansia-indonesia',
                'is_active' => true,
                'created_by' => 1, // Assuming super admin ID is 1
            ],
            [
                'name' => 'Yayasan Kesehatan Geriatri',
                'slug' => 'yayasan-kesehatan-geriatri',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'name' => 'Yayasan Care for Elderly',
                'slug' => 'yayasan-care-for-elderly',
                'is_active' => true,
                'created_by' => 1,
            ],
        ];

        foreach ($foundations as $foundationData) {
            $foundation = Foundation::create($foundationData);
            
            // Create foundation users for each foundation
            $users = [
                [
                    'name' => 'dr. Sarah',
                    'full_name' => 'dr. Sarah Wijaya',
                    'email' => 'sarah@' . $foundation->slug . '.com',
                    'password' => Hash::make('password123'),
                    'role' => 2, // foundation role
                    'foundation_id' => $foundation->id,
                ],
                [
                    'name' => 'dr. Ahmad',
                    'full_name' => 'dr. Ahmad Rahman',
                    'email' => 'ahmad@' . $foundation->slug . '.com',
                    'password' => Hash::make('password123'),
                    'role' => 2, // foundation role
                    'foundation_id' => $foundation->id,
                ],
            ];

            foreach ($users as $userData) {
                User::create($userData);
            }
        }

        $this->command->info('Foundations and foundation users seeded successfully!');
    }
}
