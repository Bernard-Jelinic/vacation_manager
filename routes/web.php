<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserprofileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('user', UserController::class);

Route::resource('userprofile', UserprofileController::class)->only('edit', 'update');

Route::resource('department', DepartmentController::class);

Route::resource('vacation', VacationController::class)->only(['create', 'store', 'edit', 'update']);

Route::get('vacation/{display}', [VacationController::class , 'index'])->name('vacation');

require __DIR__.'/auth.php';
