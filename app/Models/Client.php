<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable=[
        'full_name',
        'street',
        'zip_code',
        'city_id',
        'address',
        'tel',
        'email',
        'ice',
        'company_id'
    ];
}
