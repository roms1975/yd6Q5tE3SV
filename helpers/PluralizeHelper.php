<?php

    namespace app\helpers;

class PluralizeHelper {
    public static function pluralize($number, $forms) {
        if ($number % 10 === 1 && $number % 100 !== 11) {
            return $forms[0];
        }
        elseif (($number % 10 >= 2 && $number % 10 <= 4) &&
            !($number % 100 >= 12 && $number % 100 <= 14)) {
            return $forms[1];
        }
        else {
            return $forms[2];
        }
    }
}