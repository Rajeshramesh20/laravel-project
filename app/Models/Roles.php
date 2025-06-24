<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\RoleMenuPermission;

class Roles extends Model
{
    use HasFactory;
    protected $table= 'roles';
   protected $fillable =[
        'name'
   ];
   
    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function menuPermissions()
    {
        return $this->hasMany(RoleMenuPermission::class);
    }
}
