<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
           echo "<pre>";
            print_r($query->sql);
            echo "<br>";
            print_r($query->bindings);
         echo "</pre>";
        }); 
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
