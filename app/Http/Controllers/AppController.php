<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['login', 'registerByToken', 'forgotPassword', 'resetPassword']);
        $this->middleware('guest')->only(['login', 'resetPassword']);
    }

    /**
     *
     * @return View
     */
    public function index()
    {
        return view(
            'index'
        );
    }

    /**
     *
     * @return View
     */
    public function registerByToken()
    {
        return $this->index();
    }

    /**
     *
     * @return View
     */
    public function forgotPassword()
    {
        return $this->index();
    }

    /**
     *
     * @return View
     */
    public function resetPassword()
    {
        return $this->index();
    }

    /**
     *
     * @return View
     */
    public function login()
    {
        return view(
            'login'
        );
    }
}
