<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'barcode',
        'designation',
        'vendor_id',
        'category_id',
        'name',
        'quantity',
        'unit',
        'nbr_products'
    ];
}
