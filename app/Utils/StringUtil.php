<?php

namespace App\Utils;

class StringUtil
{
    const CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const LETTERS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const DIGITS = '0123456789';
    const RANDOM_TYPE_CHARACTERS = 0;
    const RANDOM_TYPE_NUMBERS = 1;
    const RANDOM_TYPE_LETTERS = 2;

    public static function generateRandomString($length = 10, $type = 0)
    {
        $charactersRandom = [
            self::RANDOM_TYPE_CHARACTERS => self::CHARACTERS,
            self::RANDOM_TYPE_NUMBERS => self::DIGITS,
            self::RANDOM_TYPE_LETTERS => self::LETTERS,
        ];
        $characters = isset($charactersRandom[$type]) ? $charactersRandom[$type] : self::CHARACTERS;

        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
