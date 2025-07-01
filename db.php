<?php
$host = "localhost";
$user = "root";
$password = ""; // leave blank if using XAMPP or WAMP
$database = "users_db";

// Check if mysqli extension is loaded
if (!extension_loaded('mysqli')) {
    die("Error: The MySQLi extension is not enabled in your PHP installation.");
}

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
