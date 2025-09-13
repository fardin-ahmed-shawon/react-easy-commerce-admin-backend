<?php
$servername = "localhost";

$username = "root";
$password = "";
$database_name = "easy_landing";

$conn = new mysqli($servername, $username, $password, $database_name);
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>