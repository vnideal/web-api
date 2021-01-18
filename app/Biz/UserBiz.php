<?php

namespace App\Biz;

use App\Models\User;
use App\Utils\ArrayUtil;
use App\Utils\RandomUtil;
use Illuminate\Support\Facades\Hash;

class UserBiz extends BaseBiz
{
    const STATUS_UNVERIFIED = 0;
    const STATUS_VERIFIED = 1;

    public function getModel()
    {
        return User::class;
    }

    public function signup($params)
    {
        $attributes = ArrayUtil::filter($params, ['first_name', 'last_name', 'email', 'password', 'name']);
        $letter = '';
        if ($attributes['name']) {
            $letter = $attributes['name'][0];
        }
        $attributes['avatar_letter'] = strtoupper($letter);
        $attributes['avatar_color'] = RandomUtil::generateRandomColor();
        $attributes['status'] = self::STATUS_VERIFIED;
        $attributes['password'] = Hash::make($attributes['password']);

        return $this->create($attributes);
    }

    public function updateUserProfile($id, $params)
    {
        $attributes = ArrayUtil::filter($params, ['first_name', 'last_name', 'name', 'avatar', 'phone', 'country', 'state']);
        $letter = '';
        if ($attributes['name']) {
            $letter = $attributes['name'][0];
        }
        $attributes['avatar_letter'] = strtoupper($letter);
        $attributes['avatar_color'] = RandomUtil::generateRandomColor();

        return $this->update($id, $attributes);
    }

    public function updateUserAvatar($id, $params)
    {
        $attributes = ArrayUtil::filter($params, ['avatar']);

        return $this->update($id, $attributes);
    }

    public function updatePassword($id, $params)
    {
        $attributes = ArrayUtil::filter($params, ['password']);
        $attributes['password'] = Hash::make($attributes['password']);

        return $this->update($id, $attributes);
    }
}
