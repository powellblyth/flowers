<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller {
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'bail|required|unique:users|string|email|max:255',
            'password' => 'required|string|min:2|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    public function create( $extraData = []) {
        return User::create([
            'firstname' => $extraData['firstname'],
            'lastname' => $extraData['lastname'],
            'email' => $extraData['email'],
            'password' => Hash::make($extraData['password']),
            'auth_token' => md5(random_int(PHP_INT_MIN,PHP_INT_MAX)),
            'password_reset_token' => '',
            'type' => User::DEFAULT_TYPE,
            ]);
        parent::create();
    }
    public function dcreate($extraData = [])
    {
        return view($this->templateDir  .'.create', $extraData);
    }

}
