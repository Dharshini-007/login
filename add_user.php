<?php
header('Content-Type: application/json');
include 'db.php';

$username = trim($_POST['new_username'] ?? '');
$password = trim($_POST['new_password'] ?? '');

if ($username === '' || $password === '') {
    echo json_encode(['success' => false, 'error' => 'Username and password required.']);
    exit;
}

// Check if user exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo json_encode(['success' => false, 'error' => 'Username already exists.']);
    exit;
}
$stmt->close();

// Insert new user
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Database error.']);
}
$stmt->close();
$conn->close();
?>