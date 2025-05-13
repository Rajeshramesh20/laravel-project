<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use App\Models\Subjects;


class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

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
        'is_deleted',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function subjects()
    {
        return $this->belongsToMany(Subjects::class, 'student_subject_mapings', 'student_id', 'subject_id');
    }
}
