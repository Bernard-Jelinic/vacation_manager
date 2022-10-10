<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vacation extends Model
{
    use HasFactory;

    protected $table = 'vacations';

    protected $fillable = [
        'depart',
        'return',
        'created_at',
        'updated_at',
        'status',
        'admin_read',
        'manager_read',
        'employee_read',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
