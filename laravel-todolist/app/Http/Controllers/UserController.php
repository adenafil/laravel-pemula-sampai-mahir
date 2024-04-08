<?php

namespace App\Http\Controllers;

use App\Services\UserServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private UserServices $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    public function login(): Response
    {
        return response()
            ->view('user.login', [
                'title' => 'Login'
            ]);
    }

    public function doLogin(Request $request): Response|RedirectResponse
    {
        $username = $request->input('user');
        $password = $request->input('password');

        // validate input

        if (empty($username) || empty($password)) {
            return \response()->view('user.login', [
                'title' => 'Login',
                'error' => 'User or password is required',
            ]);
        }

        if ($this->userServices->login($username, $password)) {
            session()->put('user', $username);
            return redirect('/');
        }

        return \response()
            ->view('user.login', [
                'title' => 'Login',
                'error' => 'User or Password is wrong'
            ]);
    }

    public function doLogout(Request $request): RedirectResponse
    {
        $request->session()->forget('user');
        return redirect('/');
    }
}
