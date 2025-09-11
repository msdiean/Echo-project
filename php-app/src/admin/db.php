<?php
$servername = "mysql-service";
$username = "root";
$password = "rootpassword";
$dbname = "echo_digital_works";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
