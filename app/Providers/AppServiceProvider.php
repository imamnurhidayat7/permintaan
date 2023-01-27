<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Models\Pemberitahuan;

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
        view()->composer('*', function ($view) 
        {
            if(Session::get('id') != null){
                $data['pemberitahuan'] = Pemberitahuan::where('id_user', Auth::user()->id)->orderBy('id', 'desc')->take(5)->get();
                $data['count'] = Pemberitahuan::where('id_user', Auth::user()->id)->where('status', 0)->orderBy('id', 'desc')->take(5)->count();
                $view->with($data);  
            }

            //...with this variable
              
        });  
    }
}
