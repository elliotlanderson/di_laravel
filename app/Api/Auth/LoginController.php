<?php

namespace App\Api\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * POST /api/login
     *
     * Form-Data:
     * ['email', 'password']
     *
     * Return-Data:
     * Logged in User Instance
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function login(Request $request)
    {
        if
        (Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'verified' => true
        ], true))
        {
            # User logged in successfully
            $this->response->addData('User', Auth::user());
            return $this->response->response();
        }
        else
        {
            $this->response->errorResponse(new \Exception('Invalid credentials for login.'));
        }

    }

    public function checkAuth()
    {
        $this->response->addData('User', Auth::user());
        return $this->response->response();
    }
}