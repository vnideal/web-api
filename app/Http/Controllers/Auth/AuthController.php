<?php

namespace App\Http\Controllers\Auth;

use App\Biz\UserBiz;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

class AuthController extends Controller
{
    use ApiResponser;

    public function __construct(UserBiz $userBiz)
    {
        $this->userBiz = $userBiz;
    }

    public function login(Request $request)
    {
        $attr = $this->validateLogin($request);

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials mismatch', 401);
        }

        return $this->token($this->getPersonalAccessToken());
    }

    public function signup(Request $request)
    {
        $attr = $this->validateSignup($request);

        $this->userBiz->signup([
            'first_name' => $attr['first_name'],
            'last_name' => $attr['last_name'],
            'name' => $attr['name'],
            'email' => $attr['email'],
            'password' => $attr['password'],
        ]);

        Auth::attempt(['email' => $attr['email'], 'password' => $attr['password']]);

        return $this->token($this->getPersonalAccessToken(), 'User Created', 201);
    }

    public function user()
    {

        return $this->success(Auth::user());
    }

    public function logout()
    {
        Auth::user()->token()->revoke();
        return $this->success(true, 'User Logged Out', 200);
    }

    public function getPersonalAccessToken()
    {
        if (request()->remember_me == 1) {
            Passport::personalAccessTokensExpireIn(now()->addDays(365));
        }

        return Auth::user()->createToken('Personal Access Token');
    }

    public function validateLogin($request)
    {
        return $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
    }

    public function validateSignup($request)
    {
        return $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
}
