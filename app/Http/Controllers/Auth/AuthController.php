<?php

namespace App\Http\Controllers\Auth;

use App\Biz\UserBiz;
use App\Classes\Helper\GCSHelper;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Storage;

class AuthController extends ApiController
{
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
        $userInfo = Auth::user()->toArray();
        $userInfo['avatar'] = GCSHelper::getUrl($userInfo['avatar']);
        return $this->success($userInfo);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $attr = $this->validateUpdate($request);
        $avatar = null;

        if ($request->hasFile('avatar')) {
            $disk = Storage::disk('gcs');
            $avatar = $disk->put('users/images', $request->file('avatar'));
            $image_remove = $user->avatar;
            if ($image_remove) {
                $disk->delete($image_remove);
            }
        }

        $userInfo = $this->userBiz->updateUserProfile($user->id, [
            'first_name' => $attr['first_name'],
            'last_name' => $attr['last_name'],
            'name' => $attr['name'],
            'phone' => isset($attr['phone']) ? $attr['phone'] : '',
            'country' => $attr['country'],
            'state' => $attr['state'],
            'avatar' => $avatar,
        ]);
        $userInfo['avatar'] = GCSHelper::getUrl($userInfo['avatar']);

        return $this->success($userInfo);
    }

    public function updateAvatar(Request $request) {
        $user = Auth::user();

        $attr = $this->validateUpdateAvatar($request);
        $avatar = null;

        if ($request->hasFile('avatar')) {
            $disk = Storage::disk('gcs');
            $avatar = $disk->put('users/images', $request->file('avatar'));
            $image_remove = $user->avatar;
            if ($image_remove) {
                $disk->delete($image_remove);
            }
        }

        $userInfo = $this->userBiz->updateUserAvatar($user->id, [
            'avatar' => $avatar,
        ]);
        $userInfo['avatar'] = GCSHelper::getUrl($userInfo['avatar']);

        return $this->success($userInfo);
    }

    public function updatePassword(Request $request)
    {
        $attr = $this->validateUpdatePassword($request);
        $user = Auth::user();
        $currentPassword = $user->password;

        if (!Hash::check($attr['password'], $currentPassword)) {
            return $this->error('Credentials mismatch', 401);
        }

        $this->userBiz->updatePassword($user->id, [
            'password' => $attr['new_password'],
        ]);

        $user->token()->revoke();
        return $this->success(true, 'User Logged Out', 200);
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

    public function validateUpdate($request)
    {
        return $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'name' => 'required|string',
            'phone' => 'nullable|string|max:14',
            'country' => 'required|string',
            'state' => 'required|string'
        ]);
    }

    public function validateUpdatePassword($request)
    {
        return $request->validate([
            'password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed|different:password',
        ]);
    }

    public function validateUpdateAvatar($request)
    {
        return $request->validate([
            'avatar' => 'required|file'
        ]);
    }
}
