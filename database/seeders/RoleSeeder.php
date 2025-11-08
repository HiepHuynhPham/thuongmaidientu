<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'role_name' => 'Admin', 'role_description' => 'Administrator'],
            ['id' => 2, 'role_name' => 'Shipper', 'role_description' => 'Shipper'],
            ['id' => 3, 'role_name' => 'Customer', 'role_description' => 'Customer'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['id' => $role['id']],
                $role
            );
        }
    }
}


