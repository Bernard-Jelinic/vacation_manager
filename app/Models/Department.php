<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';
    protected $appends = ['manager'];

    protected $fillable = [
        'name',
        'updated_at'
    ];

    // // ADDITIONAL ATTRIBUTES
    public function getManagerAttribute()
    {
        $user = User::where('department_id', $this->id)->where('role', 'manager')->first();
        return $user == null ? "Department doesn't have manager" : $user;
    }
}
