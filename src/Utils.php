<?php

namespace Tlab\IpmaApi;

class Utils
{
    public static function distance(float $latitudeFrom, float $longitudeFrom, float $latitudeTo, float $longitudeTo): float
    {
        $R = 6371000; // metres
        $phi1 = $latitudeFrom * M_PI / 180; // φ, λ in radians
        $phi2 = $latitudeTo * M_PI / 180;
        $deltaPhi = ($latitudeTo - $latitudeFrom) * M_PI / 180;
        $deltaLambda = ($longitudeTo - $longitudeFrom) * M_PI / 180;

        $a = sin($deltaPhi / 2) * sin($deltaPhi / 2) +
            cos($phi1) * cos($phi2) *
            sin($deltaLambda / 2) * sin($deltaLambda / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round(($R * $c) / 1000, 2); // in Km
    }

    public static function compareString(string $haystack, string $needle, bool $strict): bool
    {
        if($strict) {
            return strtolower($haystack) === strtolower($needle);
        }

        return str_contains(strtolower($haystack), strtolower($needle));
    }
}
