<?php


namespace App\Helpers;


use Illuminate\Support\Facades\DB;

class RelatedItems
{
    private $company_id;
    public function __construct(){
        $this->company_id= auth()->user()->company_id;
    }
    public function invoiceRelatedItems( ){

        $vendors= DB::table('vendors')
            ->selectRaw('vendors.id as value,vendors.full_name as label')
            ->where('vendors.company_id','=',$this->company_id)
            ->get();
        $clients= DB::table('clients')
            ->selectRaw('clients.id as value,clients.full_name as label, init')
            ->where('clients.company_id','=',$this->company_id)
            ->get();
        $products=DB::table('products')
            ->join('categories','categories.id','products.category_id')
            ->join('units','units.id','products.unit_id')
            ->selectRaw(' products.*, products.id as value,products.name as label, categories.name as category_name, units.name as unit_name')
            ->where('products.company_id','=',$this->company_id)
            ->get();
        $config = DB::table('configs')
            ->selectRaw('configs.*')
            ->where('configs.company_id','=',$this->company_id)
            ->first();
        $payMethods=DB::table('pay_methods')
            ->selectRaw('pay_methods.id as value,pay_methods.name as label, pay_methods.is_default')
            ->where('pay_methods.company_id','=',$this->company_id)
            ->get();
        $units = DB::table('units')
            ->selectRaw('units.id as value,units.name as label')
            ->where('units.company_id','=',$this->company_id)
            ->get();
        $categories = DB::table('categories')
            ->selectRaw('categories.id as value,categories.name as label')
            ->where('categories.company_id','=',$this->company_id)
            ->get();
        $reportTypes= DB::table('report_types')
            ->selectRaw('report_types.*')
            ->where('report_types.company_id','=',$this->company_id)
            ->get();
        return [
            'vendors'=>$vendors,
            'clients'=>$clients,
            'products'=>$products,
            'config'=>$config,
            'payMethods'=>$payMethods,
            'units'=>$units,
            'categories'=>$categories,
            'report_types'=>$reportTypes
        ];
    }

    public function clientsVendorsRelatedItems(){
        $cities = DB::table('cities')
            ->selectRaw('cities.id as value,cities.name as label, cities.init')
            ->where('cities.company_id','=',$this->company_id)
            ->get();
        return $cities;
    }
}
