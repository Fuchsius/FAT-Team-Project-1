<!DOCTYPE html>
<html>
<title>Student Database</title>
<body>
<h2>Student Form</h2>
<form action="" method="POST">
  <fieldset>
    <legend>Student information:</legend>
    Name:<br>
    <input type="text" name="name"> <br>
    Age:<br>
    <input type="text" name="age"> <br>
    Email:<br>
    <input type="email" name="email"><br>
    <br><br>
    <input type="submit" name="submit" value="submit">
  </fieldset>
</form>
</body>
</html>

<?php
require_once 'api_middleware.php';
require_once 'config.php';

// Verify authentication
$token = requireAuth();

$response = ['success' => false, 'message' => ''];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        
        $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email) VALUES (?, ?)");
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "ss", $name, $email);
        
        if (mysqli_stmt_execute($stmt)) {
            $response['success'] = true;
            $response['message'] = 'User created successfully';
        }
        
        mysqli_stmt_close($stmt);
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

mysqli_close($conn);
echo json_encode($response);
?>