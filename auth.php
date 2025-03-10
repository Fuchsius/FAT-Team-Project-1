<?php
require_once 'vendor/autoload.php';
use \Firebase\JWT\JWT;

class Auth {
    private static $secret_key = 'dushanthan123';
    private static $algorithm = 'HS256';

    public static function generateToken($user_id, $username) {
        $issued_at = time();
        $expiration = $issued_at + (24* 60 * 60); // 24 hour expiration

        $payload = array(
            'user_id' => $user_id,
            'username' => $username,
            'iat' => $issued_at,
            'exp' => $expiration
        );

        return JWT::encode($payload, self::$secret_key, self::$algorithm);
    }

    public static function validateToken($token) {
        try {
            $decoded = JWT::decode($token, self::$secret_key, array(self::$algorithm));
            return $decoded;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>