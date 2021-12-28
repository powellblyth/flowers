<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
    protected $redirectTo = '/family';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register', ['privacyContent' => config('static_content.privacy_content')]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required_without_all:address,postcode|unique:users|string|email|max:255',
            'address' => 'required_without:email|max:255',
            'postcode' => 'required_without:email|max:10',
            'password' => 'required|string|min:2|confirmed',

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    public function create($extraData = [])
    {
        $data = [
            'firstname' => $extraData['firstname'],
            'lastname' => $extraData['lastname'],
            'email' => $extraData['email'],
            'address' => $extraData['address'],
            'address2' => $extraData['address2'],
            'addresstown' => $extraData['addresstown'],
            'postcode' => $extraData['postcode'],
            'password' => Hash::make($extraData['password']),
            'auth_token' => md5((string) random_int(PHP_INT_MIN, PHP_INT_MAX)),
            'password_reset_token' => '',
            'type' => User::TYPE_DEFAULT,
        ];
        $canRetainData = array_key_exists('can_retain_data', $extraData) && 1 == (int) $extraData['can_retain_data'];
        $canEmail = array_key_exists('can_email', $extraData) && 1 == (int) $extraData['can_email'];
        $canSms = array_key_exists('can_sms', $extraData) && 1 == (int) $extraData['can_sms'];
        $canPost = array_key_exists('can_post', $extraData) && 1 == (int) $extraData['can_post'];

        $data['can_retain_data'] = (int) $canRetainData;
        $data['can_email'] = (int) $canEmail;
        $data['can_sms'] = (int) $canSms;
        $data['can_post'] = (int) $canPost;

        $res = User::create($data);
        $res->makeDefaultEntrant();
        return $res;
    }

    public function dcreate($extraData = [])
    {
        return view($this->templateDir . '.create', $extraData);
    }

}
