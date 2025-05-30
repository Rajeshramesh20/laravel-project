<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use APP\Models\User;

class ExportInfo extends Model
{
    use HasFactory;

    protected $table = 'export_info'; 
    protected $fillable = [
        'user_id',
        'file_name',
        'status',
        'initiated_at',
        'completed_at',
        'error_message',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
