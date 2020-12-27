<?php

namespace App\Utils;

class ArrayUtil
{
    // PRIMARY COLOR 500
    const DEFAULT_PALETTE = [
        '#f44336', // Red
        '#e91e63', // Pink
        '#9c27b0', // Purple
        '#673ab7', // Deep Purple
        '#3f51b5', // Indigo
        '#2196f3', // Blue
        '#03a9f4', // Light Blue
        '#00bcd4', // Cyan
        '#009688', // Teal
        '#4caf50', // Green
        '#8bc34a', // Light Green
        '#cddc39', // Lime
        '#ffeb3b', // Yellow
        '#ffc107', // Amber
        '#ff9800', // Orange
        '#ff5722', // Deep Orange
        '#795548', // Brown
        '#9e9e9e', // Grey
        '#607d8b', // Blue Grey
    ];

    /**
     * Array filter use key
     *
     * @param array $params
     * @param array $allowed
     */
    public static function filter($params, $allowed)
    {
        return array_filter(
            $params,
            function ($key) use ($allowed) {
                return in_array($key, $allowed);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}
