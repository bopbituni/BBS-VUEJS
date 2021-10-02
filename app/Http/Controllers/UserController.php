<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            return redirect(route('dashboard-board'));
        }

        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            $this->saveUserTokenToSession();

            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'auth' => __('message.auth.web.login_failed'),
        ])->withInput();
    }

    private function saveUserTokenToSession()
    {
        $user = auth('web')->user();
        $tokenResult = $user->createToken('Vue token');
        $token = $tokenResult->token;
        $token->save();
        session(['vue-token' => $tokenResult->accessToken]);
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        return redirect(route('user-login-index'));
    }
}
