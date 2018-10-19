<?php

namespace eLife\Patterns\ViewModel;

trait TitleLength
{
    private static function designateTitleLength($title) : string
    {
        static $length_limits = [
        19 => 'xx-short',
        35 => 'x-short',
        46 => 'short',
        57 => 'medium',
        80 => 'long',
        120 => 'x-long',
    ];

        static $max_length = 'xx-long';


        $charCount = mb_strlen(strip_tags($title));

        foreach ($length_limits as $maxLength => $value) {
            if ($charCount <= $maxLength) {
                return $value;
            }
        }

        return $max_length;
    }


}
