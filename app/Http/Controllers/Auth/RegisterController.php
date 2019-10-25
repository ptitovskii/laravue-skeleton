<?php

namespace App\Http\Controllers\Auth;

use App\Models\RegisterToken;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use libphonenumber\PhoneNumberUtil;

class RegisterController extends Controller
{
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
            'login' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'patronymic' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['phone:RU'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     *
     * @throws
     */
    protected function create(array $data)
    {
        $phone = PhoneNumberUtil::getInstance()->parse($data['phone'], 'RU')->getNationalNumber();

        return User::create([
            'login' => $data['login'],
            'name' => $data['name'],
            'surname' => $data['surname'],
            'patronymic' => $data['patronymic'] ?? '',
            'email' => $data['email'],
            'phone' => $phone,
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * @param string $token
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function registerByToken(string $token) {
        $email = RegisterToken::where('token', '=', $token)->first();

        if (is_null($email)) {
            return view('errors::417', ['message' => 'Не верная или устаревшая ссылка']);
        }

        return view('auth.register', ['email' => $email->getEmail(), 'notEditEmail' => true]);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function validateToken(Request $request)
    {
        $token = $request->get('token');
        $email = RegisterToken::where('token', '=', $token)->first();

        if ($email === null) {
            return \Response::noContent(417);
        }

        return \Response::json($email->toArray());
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function validateLogin(Request $request)
    {
        $login = $request->get('login');

        if ($login === null) {
            return \Response::noContent(417);
        }

        $isLoginExist = User::where('login', '=', $login)->exists();

        return $isLoginExist ? \Response::noContent(400) : \Response::noContent(200);
    }

    /**
     *
     * @return mixed
     */
    protected function registered() {
        return \Response::noContent(200);
    }
}
