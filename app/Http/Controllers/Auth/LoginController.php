<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
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
    protected $redirectTo = "/dashboard";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
	{
		if($user->user_type != "super_admin"){
			if ($user->company->status != 'active') {
				$errors = [$this->username() => _lang('Your account is').' '.ucwords($user->company->status).' !'];
			    Auth::logout();
				return redirect()->back()
								 ->withInput($request->only($this->username(), 'remember'))
								 ->withErrors($errors);
			}
			
		}
		
		date_default_timezone_set(get_option('timezone'));
		$user = \App\User::find(Auth::User()->id);
		$user->last_activity = date("Y-m-d H:i:s");
		$user->save();
	}
}
