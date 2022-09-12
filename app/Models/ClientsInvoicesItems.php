<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsInvoicesItems extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'product_id',
        'invoice_id',
        'price',
        'quantity',
        'amount',
        'company_id'
    ];
}
