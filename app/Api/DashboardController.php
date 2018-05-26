<?php

namespace App\Api;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function home()
    {
        $this->response->addData('message', 'You passed the auth test!');
        return $this->response->response();
    }
}