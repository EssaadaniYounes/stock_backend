<?php

namespace Database\Seeders;

use App\Models\PayMethod;
use Illuminate\Database\Seeder;

class PayMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payMethods=[
            ['name'=>"Credit",'company_id'=>1],
            ['name'=>"Cash",'company_id'=>1],
            ['name'=>"Card",'company_id'=>1]
        ];
        foreach ($payMethods as $payMethod){
            PayMethod::create($payMethod);
        }
    }
}
