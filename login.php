<?php
// filepath: c:\Users\vdhar\OneDrive\Tài liệu\login\login.php
session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Prepared statement for security
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $_SESSION['username'] = $username;
        header("Location: index.html"); // Change to index.php if you want session protection
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - PetPal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <style>
    body {
        background: #f8f9fa;
        font-family: Arial, sans-serif;
    }
    .login-container {
        max-width: 350px;
        margin: 60px auto;
        background: #fff;
        padding: 2rem 2rem 1.5rem 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
    }
    .login-container h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #4a4a4a;
    }
    .login-container form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .login-container input[type="text"],
    .login-container input[type="password"] {
        padding: 0.7rem;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1rem;
    }
    .login-container button {
        padding: 0.7rem;
        background: #ffb6b9;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.2s;
    }
    .login-container button:hover {
        background: #ff6f91;
    }
    .error-message {
        color: #d8000c;
        background: #ffd2d2;
        padding: 0.5rem;
        border-radius: 6px;
        margin-bottom: 1rem;
        text-align: center;
    }
    @media (max-width: 500px) {
        .login-container {
            padding: 1rem;
        }
    }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login to PetPal</h2>
        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST" autocomplete="off">
            <input type="text" name="username" placeholder="Username" required >
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>