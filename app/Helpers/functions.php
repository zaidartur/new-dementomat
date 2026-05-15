<?php

/**
 * Standardize JSON responses
 */
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