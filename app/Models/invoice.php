<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InvoiceStatus;
use App\Models\InvoiceItem;


class invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    // protected $fillable = [
    //     'invoice_no',
       
    //     'invoice_date',
    //     'invoice_due_date',
    //     'payment_terms',
    //     'invoice_status_id',
    //     'created_by',
    //     'updated_by',
    //     'is_deleted'
    // ];



    protected $fillable = [
        'invoice_no',
        'invoice_date',
        'invoice_due_date',
        'payment_terms',
        'total_amount',
        'paid_amount',
        'balance_amount',
        'additional_text',
        'invoice_status_id',
        'con_org_id',
        'is_payment_received',
        'location',
        'company_id',
        'org_id',
        'company_financial_year_id',
        'company_bank_details_id',
        'status',
        'email_send_status',
        'created_type',
        'created_from',
        'created_by',
        'updated_by',
        'is_deleted',
    ];

    // Relationships
    public function status()
    {
        return $this->belongsTo(InvoiceStatus::class, 'invoice_status_id');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

  
}
