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
<<<<<<< HEAD
            'permissions'=>'{"roles": ["create", "read", "update", "delete"], "units": ["create", "read", "update", "delete"], "users": ["create", "read", "update", "delete"], "cities": ["create", "read", "update", "delete"], "clients": ["create", "read", "update", "delete"], "vendors": ["create", "read", "update", "delete"], "invoices": ["create", "read", "update", "delete", "print"], "products": ["create", "read", "update", "delete"], "companies": ["create", "read", "update", "delete"], "dashboard": ["create", "read", "update", "delete"], "categories": ["create", "read", "update", "delete"], "pay_methods": ["create", "read", "update", "delete"]}',
=======
            'permissions' => '{"roles": ["create", "read", "update", "delete"], "units": ["create", "read", "update", "delete"], "users": ["create", "read", "update", "delete"], "clients": ["create", "read", "update", "delete"], "vendors": ["create", "read", "update", "delete"], "products": ["create", "read", "update", "delete"], "companies": ["create", "read", "update", "delete"], "dashboard": ["create", "read", "update", "delete"], "categories": ["create", "read", "update", "delete"], "pay_methods": ["create", "read", "update", "delete"], "clients_invoices": ["create", "read", "update", "delete", "print"]}',
>>>>>>> 3774afa27291ed14fab05517132ee6cc9a8f230f
            'company_id'=>1
        ]);
    }
}
