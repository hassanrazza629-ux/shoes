<?php
require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$name, $email, $password]);
        $message = "Registration successful! <a href='login.php'>Login here</a>";
    } catch (PDOException $e) {
        $message = "Error: Email might already exist.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            background-color: #8B0000; /* Dark red */
            font-family: Arial, sans-serif;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: #f0f0f0; /* Light gray */
            color: black;
            padding: 30px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.3);
        }
        input[type=text], input[type=email], input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: white;
        }
        button {
            background-color: #8B0000;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover { background-color: #a00000; }
        a { color: #8B0000; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 style="text-align:center;">Register</h2>
        <p style="color:green;"><?= $message ?></p>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <p style="text-align:center;">Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
