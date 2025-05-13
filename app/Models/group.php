<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\subjects;

class Group extends Model
{
    use HasFactory;

    protected $table='groups';
    protected $fillable = ['groupname'];
    public function students()
    {
        return $this->hasMany(Student::class);
    }

}
