<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{

    public static function CreateToken($userEmail, $userID): string
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + 60 * 60 * 24,
            'userEmail' => $userEmail,
            'userID' => $userID
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

        public static function CreateTokenForVerifyOtp($userEmail): string
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + 60 * 5,
            'userEmail' => $userEmail,
            'userID' => "0"
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    public static function VerifyToken($token): string|object
    {
        if (empty($token)) {
            return "Unauthorized"; // Prevents passing null to decode()
        }
        try {
            $key = env('JWT_KEY');
            $decode = JWT::decode($token, new Key($key, 'HS256'));
            return $decode;
        } catch (Exception $e) {
            return "Unauthorized";
        }
    }
}
