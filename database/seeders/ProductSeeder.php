<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'init'=>1,
            'barcode'=>'___',
            'name'=>'Unknown Product',
            'category_id'=>1,
            'unit_id'=>1,
            'vendor_id'=>1,
            'company_id'=>1
        ]);
    }
}
