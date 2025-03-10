<?php
session_start();

// Clear session
session_unset();
session_destroy();

// Clear auth cookie
setcookie('auth_token', '', time() - 3600, '/');

// Redirect to login
header('Location: login.php');
exit();
?>