<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable=[
        'init',
        'full_name',
        'street',
        'zip_code',
        'city_id',
        'address',
        'tel',
        'email',
        'company_id'
    ];
}
