<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/';

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
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $profileImage = 'data:image/png;base64,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';

        // dd($profileImage);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'verified' => $data['verified'],
            'profileImage' => $profileImage,
        ]);
    }
}
