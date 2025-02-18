<?php
require __DIR__."/../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTutils{
    private const secret_key="SECRET123";

    public static function generateToken($user_id, $role){
        $payload = [
            'iat' => time(),
            'exp' => time() + (60*15),
            'sub' => $user_id,
            'role' => $role
        ];
    
        return JWT::encode($payload, self::secret_key, 'HS256');
    }

    public static function validateToken($token) {
        global $secret_key;
    
        try {
            $decoded = JWT::decode($token, new Key(self::secret_key, 'HS256'));
            return (array) $decoded;
        } catch (Exception $e) {
            return null;
        }
    }

    public static function getPayload($token){
        return JWT::decode($token, new Key(self::secret_key, 'HS256'));
    }

    public static function getRoleFromToken($token) {
        $payload = self::getPayload($token);
        return $payload->role;
    }
    
}

?>