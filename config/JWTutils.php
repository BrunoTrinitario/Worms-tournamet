<?php
require __DIR__."/../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = "SECRET123";

class JWTutils{
    public static function generateToken($user_id) {
        global $secret_key;
    
        $payload = [
            'iat' => time(),
            'exp' => time() + (60*15),
            'sub' => $user_id
        ];
    
        return JWT::encode($payload, $secret_key, 'HS256');
    }

    public static function validateToken($token) {
        global $secret_key;
    
        try {
            $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
            return (array) $decoded;
        } catch (Exception $e) {
            return null;
        }
    }
    
}

?>