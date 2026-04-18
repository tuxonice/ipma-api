<?php

declare(strict_types=1);

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

    public static function compareString(string $haystack, string $needle, bool $strict = true): bool
    {
        // Use mb_strtolower so accented Portuguese characters (ã, ç, õ, á, é…)
        // in location/region names are compared case-insensitively as expected.
        $haystack = mb_strtolower($haystack, 'UTF-8');
        $needle = mb_strtolower($needle, 'UTF-8');

        if ($strict) {
            return $haystack === $needle;
        }

        return str_contains($haystack, $needle);
    }
}
