<?php
$servername = "localhost"; // Your server name
$username = "root";        // Your database username
$password = "";            // Your database password
$dbname = "sentectest"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
