<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\Order;
use App\Models\Place;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('place', function(User $user){
            return $user->roles()->where('name', 'place')->count() > 0;
        });

        Gate::define('courier', function(User $user){
            return $user->roles()->where('name', 'courier')->count() > 0;
        });

        Gate::define('admin', function(User $user){
            return $user->roles()->where('name', 'admin')->count() > 0;
        });

        /*Gate::define('view-order', function(User $user){
            dd($order);
            return Gate::allows('courier') || in_array(Order::findOrFail($id)->place_id, Place::where('user_id', Auth::user()->id)->pluck('id'));
        });*/

        Gate::define('change-order-status', function(User $user, Order $order){
            return Gate::allows('admin') || $order->courier_id == $user->id;
        });
    }
}
