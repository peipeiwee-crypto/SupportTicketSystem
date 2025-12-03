<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Pei Pei Wee',
                'email' => 'peipei.wee@bitzaro.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike.johnson@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Sarah Williams',
                'email' => 'sarah.williams@example.com',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']], // Check by email
                $userData // Create with this data if not exists
            );
        }

        $this->command->info('Users seeded successfully! (existing users were skipped)');
    }
}