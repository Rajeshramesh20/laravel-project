<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_id',
        'reference_name',
        'line1',
        'line2',
        'line3',
        'line4',
        'pincode',
        'created_by',
        'updated_by',
        'is_deleted',
    ];

}
