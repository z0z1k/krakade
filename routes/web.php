<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Orders as OrdersC;
use App\Http\Controllers\Users as UsersC;
use App\Http\Controllers\Auth\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function(){
    return view('home');
});

Route::resource('orders', OrdersC::class);

Route::resource('users', UsersC::class);
Route::get('users/{id}/roles', [ UsersC::class, 'roles' ])->name('users.roles');
Route::put('users/{id}/roles', [ UsersC::class, 'saveRoles']);

Route::controller(Session::class)->group(function(){
    Route::get('/auth/login', 'create')->name('login');
    Route::post('/auth/login', 'store')->name('login.store');
});