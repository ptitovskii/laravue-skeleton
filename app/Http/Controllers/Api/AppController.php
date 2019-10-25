<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class AppController extends Controller
{
    /**
     * AppController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *
     * @return mixed
     */
    public function getParams()
    {
        $response = [];

        return \Response::json($response);
    }
}
