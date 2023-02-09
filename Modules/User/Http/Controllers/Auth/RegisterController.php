<?php

namespace Modules\User\Http\Controllers\Auth;

use Modules\User\Http\Controllers\Controller;
use Modules\User\Entities\User;
use Modules\User\Notifications\UserRegistered;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    public function redirectTo(){

        $this->redirectTo = 'dashboard';

        switch (Auth::user()->role) {
            case 'user':
                $this->redirectTo = 'dashboard';
                break;
            case 'admin':
                $this->redirectTo = 'settings';
                break;
            default:
                $this->redirectTo = 'dashboard';
                break;
        }
        return $this->redirectTo;

    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
        $secret = config('recaptcha.api_secret_key');
        $site_key = config('recaptcha.api_site_key');
        
        if ($secret && $site_key) {
            $rules['g-recaptcha-response'] = 'recaptcha';
        }
        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $data['role'] = 'user';
        $user = User::create([
               'name'          => $data['name'],
               'email'         => $data['email'],
               'role'          => $data['role'],
               'password'      => Hash::make($data['password']),
        ]);
        $user->notify((new UserRegistered())->onQueue('mail'));

        return $user; 
        
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        
        return view('themes::' . config('app.SITE_LANDING') . '.auth.register');
    }
}
