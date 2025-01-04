<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "elite_estates";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

$conn->close();
?>