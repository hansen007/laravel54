<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        \View::composer('layout.sidebar',function($view){

            $topics = \App\Topic::all();
            $view->with('topics',$topics);
        });

        \DB::listen(function($query){
            $sql = $query->sql;
            $bindings = $query->bindings;
            $time = $query->time;
            if($time > 10){
                \Log::debug(var_export(compact('sql','bindings','time'),true));
            }
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
