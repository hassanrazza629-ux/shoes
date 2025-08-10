<?php
// user_register.php
session_start();
require 'db.php';

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($name === '') $errors[] = "Name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if ($password !== $confirm) $errors[] = "Passwords do not match.";

    if (empty($errors)) {
        // check duplicate email
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = "Email already registered. Please login.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $ins->execute([$name, $email, $hash]);
            $success = "Registration successful. You can now <a href='user_login.php'>login</a>.";
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>User Register</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="card" style="max-width:760px;margin:0 auto">
      <div class="header">
        <div class="brand">
          <div class="logo">S</div>
          <h1>SHOES — Register</h1>
        </div>
        <div>
          <a class="button secondary" href="user_login.php">Login</a>
        </div>
      </div>

      <?php if(!empty($errors)): ?>
        <div class="msg error">
          <?php foreach($errors as $e) echo htmlspecialchars($e)."<br>"; ?>
        </div>
      <?php endif; ?>

      <?php if($success): ?>
        <div class="msg success"><?php echo $success; ?></div>
      <?php endif; ?>

      <form class="form" method="POST" novalidate>
        <div class="field">
          <input class="input" type="text" name="name" placeholder="Full name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
        </div>
        <div class="field">
          <input class="input" type="email" name="email" placeholder="Email address" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
        </div>
        <div class="field">
          <input class="input" type="password" name="password" placeholder="Password" required>
        </div>
        <div class="field">
          <input class="input" type="password" name="confirm_password" placeholder="Confirm password" required>
        </div>
        <div class="field">
          <button class="button" type="submit">Create account</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
