<?php
$host="localhost";
$username="root";
$password="root";
$dbname="crud";

$conn=mysqli_connect($host,$username,$password,$dbname);
if (!$conn) {
    die("Connection Failed:" . mysqli_connect_error());
}
?>