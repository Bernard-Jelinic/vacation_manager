<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'employee_notified',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
