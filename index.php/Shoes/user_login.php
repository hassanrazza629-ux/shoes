<?php
// user_login.php
session_start();
require 'db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Enter a valid email.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // set session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: user_dashboard.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>User Login</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="card" style="max-width:520px;margin:0 auto">
      <div class="header">
        <div class="brand">
          <div class="logo">S</div>
          <h1>SHOES — Login</h1>
        </div>
        <div>
          <a class="button secondary" href="user_register.php">Register</a>
        </div>
      </div>

      <?php if($error): ?>
        <div class="msg error"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <form class="form" method="POST" novalidate>
        <div class="field">
          <input class="input" type="email" name="email" placeholder="Email address" required>
        </div>
        <div class="field">
          <input class="input" type="password" name="password" placeholder="Password" required>
        </div>
        <div class="field">
          <button class="button" type="submit">Login</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
