<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Kalnoy\Nestedset\NodeTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, NodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'role',
        'department_id',
        'remember_token',
        'email',
        'email_verified_at',
        'password',
        'image',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $append = ['full_name'];

    // // ADDITIONAL ATTRIBUTES
    public function getFullNameAttribute()
    {
        return $this->name . " " . $this->last_name;
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public static function getManagers()
    {
        return User::select('id', 'name', 'last_name')
            ->where('role', '=', 'manager')
            ->get();
    }
}
