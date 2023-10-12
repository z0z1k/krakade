<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Orders as OrdersC;
use App\Http\Controllers\Users as UsersC;
use App\Http\Controllers\Places as PlacesC;
use App\Http\Controllers\Auth\Session;

use App\Http\Controllers\Profile\Info as ProfileInfo;
use App\Http\Controllers\Profile\Password as ProfilePassword;

use App\Http\Controllers\Registration as RegistrationC;
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
Route::get('orders/create/{place}', [ OrdersC::class, 'create' ])->name('orders.create');

Route::resource('places', PlacesC::class);

Route::resource('users', UsersC::class);
Route::get('users/{id}/roles', [ UsersC::class, 'roles' ])->name('users.roles');
Route::put('users/{id}/roles', [ UsersC::class, 'saveRoles']);

Route::prefix('profile')->group(function(){
    Route::controller(ProfilePassword::class)->group(function(){
        Route::get('/password', 'edit')->name('profile.password.edit');
        Route::put('/password', 'update')->name('profile.password.update');
    });
    

    Route::controller(ProfileInfo::class)->group(function(){
        Route::get('/info', 'show')->name('profile.info');
        Route::put('/info', 'update')->name('profile.update');
    });
});

Route::controller(Session::class)->group(function(){
    Route::middleware('guest')->group(function(){
        Route::get('/auth/login', 'create')->name('login');
        Route::post('/auth/login', 'store')->name('login.store');
    });
    Route::middleware('auth')->group(function(){
        Route::get('/auth/logout', 'exit')->name('login.exit');
        Route::delete('/auth/logout', 'destroy')->name('login.destroy');
    });
});

Route::get('register', [ RegistrationC::class, 'create' ])->name('registration.create');
Route::post('register', [ RegistrationC::class, 'store' ])->name('registration.store');