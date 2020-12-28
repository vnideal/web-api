<?php

namespace App\Classes\Helper;

use Storage;

class GCSHelper
{
    public static function getUrl($path)
    {
        if (!$path) {
            return null;
        }

        $disk = Storage::disk('gcs');
        return $disk->url($path);
    }
}
