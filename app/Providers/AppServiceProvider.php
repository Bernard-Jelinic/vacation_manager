<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('admin_area', function(User $user){
            return $user->role == 'admin';
        });

        Gate::define('admin_manager_area', function(User $user){
            return $user->role == 'admin' || $user->role == 'manager';
        });

        Gate::define('manager_employee_area', function(User $user){
            return $user->role == 'manager' || $user->role == 'employee';
        });

        Gate::define('employee_area', function(User $user){
            return $user->role == 'employee';
        });

    }
}
