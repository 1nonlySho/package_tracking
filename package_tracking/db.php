<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "package_tracking";
$port = 3306; // your MySQL port

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
