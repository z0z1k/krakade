<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\DB;

use App\Contracts\Messages;
use App\Services\Messages\Telegram;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Messages::class, function(){
            return new Telegram();
        });
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*DB::beforeExecuting(function($sql){
            print_r($sql);
        });*/
    }
}
