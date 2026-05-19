<?php

/**
 * Standardize JSON responses
 */

use Illuminate\Support\Facades\Log;

if (!function_exists('send_200')) {
    function send_200($message, $result = null)
    {
        $response = [
            'status'    => 'success',
            'message'   => $message,
            'data'      => $result,
        ];

        return response()->json($response, 200);
    }
}

if (!function_exists('send_201')) {
    function send_201($message, $result = null)
    {
        $response = [
            'status'    => 'success',
            'message'   => $message,
            'data'      => $result,
        ];

        return response()->json($response, 201);
    }
}

if (!function_exists('send_400')) {
    function send_400($error)
    {
        $response = [
            'status'    => 'failed',
            'message'   => $error,
        ];

        return response()->json($response, 400);
    }
}

if (!function_exists('send_401')) {
    function send_401($error)
    {
        $response = [
            'status'    => 'failed',
            'message'   => $error,
        ];

        return response()->json($response, 401);
    }
}

if (!function_exists('send_404')) {
    function send_404($error)
    {
        $response = [
            'status'    => 'failed',
            'message'   => $error,
        ];

        return response()->json($response, 404);
    }
}

if (!function_exists('send_500')) {
    function send_500($error)
    {
        $response = [
            'status'    => 'failed',
            'message'   => $error,
        ];

        return response()->json($response, 500);
    }
}

if (!function_exists('hslToHex')) {
    function hslToHex($h, $s, $l) {
        // Convert 0-360 degrees to 0-1 fraction
        $h /= 360;
        // Convert 0-100% to 0-1 fraction
        $s /= 100;
        $l /= 100;

        $r = $l;
        $g = $l;
        $b = $l;

        $v = ($l <= 0.5) ? ($l * (1 + $s)) : ($l + $s - $l * $s);
        
        if ($v > 0) {
            $m = $l + $l - $v;
            $sv = ($v - $m) / $v;
            $h *= 6;
            $sextant = floor($h);
            $fract = $h - $sextant;
            $vsf = $v * $sv * $fract;
            $mid1 = $m + $vsf;
            $mid2 = $v - $vsf;

            switch ($sextant % 6) {
                case 0: $r = $v; $g = $mid1; $b = $m; break;
                case 1: $r = $mid2; $g = $v; $b = $m; break;
                case 2: $r = $m; $g = $v; $b = $mid1; break;
                case 3: $r = $m; $g = $mid2; $b = $v; break;
                case 4: $r = $mid1; $g = $m; $b = $v; break;
                case 5: $r = $v; $g = $m; $b = $mid2; break;
            }
        }

        $res = sprintf("#%02x%02x%02x", round($r * 255), round($g * 255), round($b * 255));

        return $res;
    }
}