<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\invoice;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'item_name',
        'quantity',
        'unit_price',
        'net_amount',
        'gst_percent',     
        'gst_amount',    
        'total',
        'created_by',
        'updated_by',
        'is_deleted'
    ];

    public function invoice()
    {
        return $this->belongsTo(invoice::class ,'invoice_id');
    }
}
