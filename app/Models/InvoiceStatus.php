<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\invoice;

class InvoiceStatus extends Model
{
    use HasFactory;
     
    protected $primaryKey = 'invoice_status_id';
    protected $fillable = ['invoice_status'];

    public function invoices()
    {
        return $this->hasMany(invoice::class);
    }
}
