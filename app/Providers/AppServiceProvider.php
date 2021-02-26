<?php

namespace App\Providers;

use App\PushNotification;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
//
//    public function __construct()
//    {
//       $this->middleware('auth');
//    }

    public function boot()
    {
        //
        $user_id=Auth::id();
//        if(Auth::check()) {
//            $notifications = PushNotification::where('source_to', Auth::id())->get();
////
////        }
//        return View::share('notifications',$notifications);
//        $notifications=PushNotification::where('source_to', Auth::id())->limit(5)->get();

        View::composer('*',function (){
            $notifications=PushNotification::where('source_to', Auth::id())->orderBy('id','desc')->limit(5)->get();
            return \Illuminate\Support\Facades\View::share('notifications',$notifications);
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
