<?php

namespace App\Helpers;

class NumberHelper
{
    public static function numberToWords($number)
    {
        $f = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
        return ucfirst($f->format($number));
    }
}
