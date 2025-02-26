<?php
include "../config.php"; // Include database connection

$sql = "SELECT id, name, email, created_at FROM Users";
$result = mysqli_query($conn, $sql);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

echo json_encode($users);

mysqli_close($conn);
?>
