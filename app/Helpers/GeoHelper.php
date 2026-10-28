<?php
namespace App\Helpers;

class GeoHelper
{
    public static function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadiusKm = 6371;

        $lat1Rad = deg2rad($lat1);
        $lon1Rad = deg2rad($lon1);
        $lat2Rad = deg2rad($lat2);
        $lon2Rad = deg2rad($lon2);

        $deltaLat = $lat2Rad - $lat1Rad;
        $deltaLon = $lon2Rad - $lon1Rad;

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) + cos($lat1Rad) * cos($lat2Rad) * sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadiusKm * $c;

        return $distance;
    }

    public static function findNearestLocation($longitude, $latitude, $locations)
    {
        $nearestLocation = null;
        $minDistance = PHP_INT_MAX;

        foreach ($locations as $location) {
            $distance = self::haversineDistance($latitude, $longitude, $location['latitude'], $location['longitude']);
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearestLocation = $location;
            }
        }

        // If the nearest location is within 500 meters, return it, otherwise return null.
        return $minDistance <= 0.5 ? $nearestLocation : null;
    }
}