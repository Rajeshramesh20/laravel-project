<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class temp_student extends Model
{
    use HasFactory;

    protected $table = 'temp_student';
    protected $casts = [
        'subject_ids' => 'array',
    ];
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'age',
        'gender',
        'date_of_birth',
        'mobile_number',
        'class',
        'batch',
        'medium',
        'group_id',
        'subject_ids',
        'action',
        'maker_by',
        'maker_at',
    ];

  
}
