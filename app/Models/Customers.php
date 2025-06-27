<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Addresses;

class Customers extends Model
{
    use HasFactory;
    protected $table = 'customers';
    public $timestamps = true;
    protected $primaryKey = 'customer_id';
    protected $fillable = [
        'customer_name',
        'customer_email',
        'contact_name',
        'contact_number',
        'address_id',
        'created_by',
        'updated_by',
    
    ];

    public function address()
    {
        return $this->belongsTo(Addresses::class, 'address_id', 'address_id');
    }
}
