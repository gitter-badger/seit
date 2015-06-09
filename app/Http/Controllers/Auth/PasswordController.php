<?php namespace SeIT\Http\Controllers\Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use SeIT\Http\Controllers\Controller;

/**
 * Class PasswordController
 * @package SeIT\Http\Controllers\Auth
 */
class PasswordController extends Controller
{

    /*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

    /*
     * @property string redirectPath
     */
    protected $redirectPath = '';

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
     */
    public function __construct(Guard $auth, PasswordBroker $passwords)
    {
        $this->auth = $auth;
        $this->passwords = $passwords;
        $this->redirectPath = '/';
        
        $this->middleware('guest');
    }
}
