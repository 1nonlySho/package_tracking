<?php
$servername = "localhost";
$username = "root";
$password = "";       // default in XAMPP is empty
$database = "tracking_system";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
?>
