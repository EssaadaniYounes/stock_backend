<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'barcode',
        'vendor_id',
        'category_id',
        'name',
        'quantity_initial',
        'unit_id',
        'company_id'
    ];
}
