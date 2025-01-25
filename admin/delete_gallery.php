<?php
$item = $_GET['id']; // The event ID to be deleted

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sentectest"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete event
$sql = "DELETE FROM gallery WHERE id = $item";

if ($conn->query($sql) === TRUE) {
    echo "Event deleted successfully.";
} else {
    echo "Error deleting event: " . $conn->error;
}

$conn->close();
?>
