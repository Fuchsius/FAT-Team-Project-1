<?php
include "../config.php"; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];

    $sql = "UPDATE Users SET name=?, email=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["message" => "User updated successfully"]);
    } else {
        echo json_encode(["error" => "Error updating user"]);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
