<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;

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
    //!! Changed to function authenticated
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:eksmp')->except('logout');
    }

    public function logout(Request $request)
    {
        if (Auth::user()) {
            $help = Auth::user()->id_helpdesk;
            if ($help)
                $log = logoutHelpdesk($help);
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($request->redirect != '' && decrypt($request->redirect) == 'business_matching') {
            return redirect()->intended('/front_end/event_zoom');
        }

        return redirect('/home');
    }
}
