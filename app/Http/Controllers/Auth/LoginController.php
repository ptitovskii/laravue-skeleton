<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers {}

    /** @var string */
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'me']);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'login';
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function authenticated(Request $request, $user)
    {
        return \Response::json($user->toArray());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        /** @var User $user */
        $user = \Auth::user();

        $result = $user->toArray();

        $result['is_admin'] = in_array($user->role, ['admin']);
        $result['is_manager'] = in_array($user->role, ['manager']);

        return \Response::json($result);
    }

    /**
     * @param Request $request
     *
     * @return \Response
     */
    protected function loggedOut(Request $request)
    {
        return \Response::noContent(200);
    }
}
