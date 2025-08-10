<?php
session_start();
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<h2>Your cart is empty!</h2>";
    echo "<a href='user_dashboard.php'>Go Back</a>";
    exit;
}

if (isset($_POST['confirm_order'])) {
    // Normally you would save the order to database here
    $_SESSION['cart'] = [];
    echo "<h2>Thank you! Your order has been placed successfully.</h2>";
    echo "<a href='user_dashboard.php'>Continue Shopping</a>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Checkout</h1>
<form method="post">
    <label>Full Name:</label><br>
    <input type="
