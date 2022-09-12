<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin',
            'role_id' => 1,
            'company_id'=>1,
            'password' => bcrypt('1234')
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

    }
}
