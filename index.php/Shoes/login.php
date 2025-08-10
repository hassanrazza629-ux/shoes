<?php
session_start();
require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['name'] = $user['name'];
        header("Location: admin_dashboard.php"); // Redirect to dashboard
        exit;
    } else {
        $message = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { background-color: #8B0000; font-family: Arial; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .form-container { background: #f0f0f0; padding: 25px; border-radius: 8px; width: 300px; box-shadow: 0 0 10px rgba(0,0,0,0.3); }
        input { width: 100%; padding: 10px; margin: 8px 0; border-radius: 5px; border: 1px solid #ccc; }
        button { background-color: #8B0000; color: white; border: none; padding: 10px; width: 100%; border-radius: 5px; }
        button:hover { background-color: #a00000; }
        a { color: #8B0000; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 style="text-align:center;">Login</h2>
        <p style="color:red;"><?= $message ?></p>
        <form method="POST">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p style="text-align:center;">Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
