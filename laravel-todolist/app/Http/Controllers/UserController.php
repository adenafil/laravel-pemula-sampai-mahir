<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login()
    {
        return response()
            ->view('user.login', [
                'title' => 'Login'
            ]);
    }

    public function doLogin()
    {

    }

    public function doLogout()
    {

    }
}
