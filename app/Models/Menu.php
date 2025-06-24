<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoleMenuPermission;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';
    protected $fillable = [
        'name'
    ];
    public function permissions()
    {
        return $this->hasMany(RoleMenuPermission::class);
    }
}
