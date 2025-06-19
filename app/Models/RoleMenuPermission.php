<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Roles;
use App\Models\Menu;

class RoleMenuPermission extends Model
{
    use HasFactory;
    protected $fillable = ['role_id', 'menu_id', 'fullaccess', 'viewonly', 'hidden'];

    public function role()
    {
        return $this->belongsTo(Roles::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
