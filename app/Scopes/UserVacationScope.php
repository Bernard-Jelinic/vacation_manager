<?php
 
namespace App\Scopes;
 
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
 
class UserVacationScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'employee') {
                $builder->where('user_id', $user->id);
                return;
            }
            else if ($user->role == 'manager') {
                $department_id = $user->department_id;
                $department_users = User::select('id')->where('department_id', $department_id)->where('role', 'employee')->get();
                $builder->whereIn('user_id', $department_users);
                return;
            }
        }
    }
}