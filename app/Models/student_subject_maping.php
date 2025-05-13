<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_subject_maping extends Model
{
    use HasFactory;
    // protected $fillable = ['student_id', 'group_id', 'subject_id'];
    protected $fillable = ['student_id', 'subject_id'];
     protected $table = 'student_subject_mapings'; 
}
