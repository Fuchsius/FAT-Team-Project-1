<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
   <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Login" style="background-color: #4CAF50; color: white; cursor: pointer;">
            </div>
            <div>
                Don't have an account? <a href="Signup.php">Sign up here</a>
            </div>
        </form>
    </div>

<?php
session_start();
require_once 'config.php';
require_once 'auth.php';

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                // Generate JWT token
                $token = Auth::generateToken($user['id'], $user['username']);
                
                // Store token in session
                $_SESSION['token'] = $token;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                // Set token in cookie (optional)
                setcookie('auth_token', $token, time() + 3600, '/');
                
                header("Location: dashboard.php");
                exit();
            } else {
                echo "<div class='error'>Invalid email or password</div>";
            }
        } else {
            echo "<div class='error'>Invalid email or password</div>";
        }
        
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>
</body>
</html>