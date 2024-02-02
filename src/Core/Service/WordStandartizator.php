<?php

namespace App\Core\Service;

class WordStandartizator
{
    public static function convert(string $word): string
    {
        return trim(mb_strtolower($word));
    }
}