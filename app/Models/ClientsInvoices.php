<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsInvoices extends Model
{
    use HasFactory;
    protected $fillable=[
        'client_id',
        'invoice_num',
        'notes',
        'invoice_date',
        'total',
        'products',

    ];
}

