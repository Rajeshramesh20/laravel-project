<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use APP\Models\student_subject_maping;


class subjects extends Model
{
    use HasFactory;
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
