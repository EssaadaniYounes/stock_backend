<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'role_name' => 'Admin',
            'permissions' => '{"roles": ["read", "update", "delete", "create"], "units": ["read", "update", "create", "delete"], "users": ["update", "delete", "create", "read"], "clients": ["create", "update", "read", "delete"], "vendors": ["create", "read", "update", "delete"], "products": ["create", "read", "update", "delete"], "dashboard": ["read", "update", "create", "delete"], "categories": ["read", "update", "create", "delete"]}'

        ]);
    }
}
