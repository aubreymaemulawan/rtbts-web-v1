<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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

    public function redirectTo(){
        $user_type = Auth::user()->user_type;
        switch($user_type){
            case 1:
                return redirect()->guest(route('admin'));
                break;
            case 2:
                return redirect()->guest(route('conductor'));
                break;
            case 3:
                return redirect()->guest(route('dispatcher'));
                break;
            case 4:
                return redirect()->guest(route('operator'));
                break;
            default:
                return '/';
                break;
        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
