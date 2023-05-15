<?php

namespace App\Models;

use App\Models\User;
use App\Models\VacationStatus;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserVacationScope;
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
        'status_id',
        'admin_read',
        'manager_read',
        'employee_read',
        'user_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new UserVacationScope);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(VacationStatus::class);
    }
}
