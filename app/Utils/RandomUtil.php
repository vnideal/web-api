<?php

namespace App\Utils;

class RandomUtil
{
    const CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const LETTERS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const DIGITS = '0123456789';
    const RANDOM_TYPE_CHARACTERS = 0;
    const RANDOM_TYPE_NUMBERS = 1;
    const RANDOM_TYPE_LETTERS = 2;

    /**
     * Generate random string
     *
     * @return string
     */
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

    /**
     * Generate random color
     *
     * @return string
     */
    public static function generateRandomColor()
    {
        $colors = ArrayUtil::DEFAULT_PALETTE;
        $size = sizeof($colors);

        return $colors[rand(0, $size - 1)];
    }

}
