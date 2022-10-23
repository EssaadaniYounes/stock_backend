<?php

namespace Database\Seeders;

use App\Models\ReportTypes;
use Illuminate\Database\Seeder;

class ReportTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reportsTypes=[
            ['name'=>"A4",'company_id'=>1,'is_default'=>1],
            ['name'=>"Preview Thermal",'company_id'=>1]
        ];
        foreach ($reportsTypes as $reportsType){
            ReportTypes::create($reportsType);
        }
    }
}
