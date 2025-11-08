<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $defaultUsers = [
            [
                'user_name' => 'Admin Account',
                'user_email' => 'admin@gmail.com',
                'role_id' => 1,
            ],
            [
                'user_name' => 'Shipper Account',
                'user_email' => 'shipper@gmail.com',
                'role_id' => 2,
            ],
            [
                'user_name' => 'User Account',
                'user_email' => 'user@gmail.com',
                'role_id' => 3,
            ],
        ];

        foreach ($defaultUsers as $userData) {
            User::updateOrCreate(
                ['user_email' => $userData['user_email']],
                $userData + [
                    'user_password' => Hash::make('12345678'),
                    'user_phone' => '0123456789',
                    'user_address' => 'TP HCM',
                    'user_avatar' => 'default-avatar.jpg',
                ]
            );
        }
    }
}


