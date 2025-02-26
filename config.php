
<?php
$host = "localhost";  // Server name
$user = "root";       // Default MySQL username
$password = "";       // Default MySQL password (empty)
$dbname = "agrios_db"; // Database name

// Create a connection
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Database connected successfully!";
?>
