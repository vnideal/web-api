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
}
