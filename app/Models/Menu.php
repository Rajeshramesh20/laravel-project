<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoleMenuPermission;

class Menu extends Model
{
    use HasFactory;
    public function permissions()
    {
        return $this->hasMany(RoleMenuPermission::class);
    }
}
