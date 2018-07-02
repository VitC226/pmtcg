<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
Use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function weibo() {
        return Socialite::with('weibo')->redirect();
        // return \Socialite::with('weibo')->scopes(array('email'))->redirect();
    }

    public function qq() {
        return Socialite::with('qq')->redirect();
    }

    public function callback() {

        try{
            $oauthUser = Socialite::with('weibo')->user();
            var_dump($oauthUser->getId());
            var_dump($oauthUser->getNickname());
            var_dump($oauthUser->getName());
            var_dump($oauthUser->getEmail());
            var_dump($oauthUser->getAvatar());
        }catch (\Exception $e){
            var_dump($e);
        }
    }

    public function qq_callback() {
        $oauthUser = Socialite::driver('qq')->user();
        dump($oauthUser);
        var_dump($oauthUser->getId());
        var_dump($oauthUser->getNickname());
        var_dump($oauthUser->getName());
        var_dump($oauthUser->getEmail());
        var_dump($oauthUser->getAvatar());
    }
}
