<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable=[
        'company_name',
        'tel',
        'mobile',
        'tax_number',
        'manager',
        'fax',
        'email',
        'website',
        'zip_code',
        'city',
        'address',
        'bank_name',
        'bank_account',
        'bank_swift_code',
        'bank_iban',
        'logo',
        'init_user_id',
        'ice',
        'cr'
    ];
}
