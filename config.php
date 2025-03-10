// config.php
<?php
// Database credentials
$host = 'localhost';
$dbname = 'fuch_database';
$username = 'dush';
$password = '';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>