<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\group;
use App\Models\subjects;
use App\Models\student_subject_maping;

class Student extends Model
{
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
        'is_deleted',
    ];
    use HasFactory;
      
    public function groups()
    {
        return $this->belongsToMany(group::class, 'student_subject_mapings');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subjects::class, 'student_subject_mapings');
    }
    public function student_subject_maping()
    {
        return $this->hasMany(student_subject_maping::class);
    }
}


