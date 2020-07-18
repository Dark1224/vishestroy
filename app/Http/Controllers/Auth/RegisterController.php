<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\BitrixQuery;

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
    protected function redirectTo()
    {
        return redirect()->back()->getTargetUrl();

    }
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
        $messages = [
            'name.required' => 'Имя пользователя должно быть заполнено',
            'name.string' => 'Имя пользователя может содержать только буквы',
            'string.min:5' => 'Имя пользователя должно состоять как минимум из 5 символов',
            'last_name.required' => 'Фамилия пользователя должно быть заполнено',
            'last_name.string' => 'Фамилия пользователя может содержать только буквы',
            'last_name.min:5' => 'Фамилия пользователя должно состоять как минимум из 5 символов',
            'email.required' => 'E-Mail адрес должен быть заполнен',
            'email.email' => 'Указан некорректный E-Mail',
            'password.required' => 'Пароль должен быть заполнено',
        ];
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:5'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public static function create(array $data)
    {
        $res_main = BitrixQuery::callMethod("crm.lead.add", [
            'fields' =>
                [
                    'TITLE' => $data['name']. ' ' . $data['last_name'],
                    'NAME' => $data['name'],
                    'LAST_NAME' => $data['last_name'],
                    'EMAIL' => [ 'VALUE' => $data['email'], 'VALUE_TYPE' => 'WORK' ]
                ]
        ]);
        return User::create([
            'bx_id' => $res_main,
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'avatar' => '/img/avatars/ava-3.png',
            'password' => Hash::make($data['password']),
        ]);
    }
}
