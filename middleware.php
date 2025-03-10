<?php
require_once 'auth.php';

function checkAuth() {
    if (!isset($_SESSION['token'])) {
        header('Location: login.php');
        exit();
    }

    $token = $_SESSION['token'];
    $decoded = Auth::validateToken($token);

    if (!$decoded) {
        session_unset();
        session_destroy();
        setcookie('auth_token', '', time() - 3600, '/');
        header('Location: login.php');
        exit();
    }

    return $decoded;
}
?>