<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{
    //
    use AuthenticatesUsers;
    protected $redirect='';
//
//    public function redirectToProvider(){
//        return Socialite::driver('')->redirect();
//    }
//
//    public function handleProviderCallback(){
//        $user=Socialite::driver('github')->stateless()->user();
//        return $user->getName();
//    }


}
