<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorsInvoice extends Model
{
    use HasFactory;
    protected $fillable=[
        'company_id',
        'vendor_id',
        'invoice_num',
        'notes',
        'invoice_date',
        'total_amount',
        'total_discount',
        'total_tax',
        'total_with_tax',
        'paid_amount',
        'rest_amount',
        'method_id',
        'created_by',
    ];
}
