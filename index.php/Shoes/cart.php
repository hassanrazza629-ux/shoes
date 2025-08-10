<?php
session_start();
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<h2>Your cart is empty!</h2>";
    echo "<a href='user_dashboard.php'>Continue Shopping</a>";
    exit;
}

$total = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Your Shopping Cart</h1>
<table border="1" cellpadding="10">
<tr>
    <th>Name</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Total</th>
</tr>
<?php foreach ($_SESSION['cart'] as $item): ?>
<tr>
    <td><?php echo $item['name']; ?></td>
    <td>$<?php echo $item['price']; ?></td>
    <td><?php echo $item['quantity']; ?></td>
    <td>$<?php echo $item['price'] * $item['quantity']; ?></td>
</tr>
<?php $total += $item['price'] * $item['quantity']; ?>
<?php endforeach; ?>
<tr>
    <td colspan="3"><b>Grand Total</b></td>
    <td><b>$<?php echo $total; ?></b></td>
</tr>
</table>
<br>
<a href="checkout.php">Proceed to Checkout</a> |
<a href="user_dashboard.php">Continue Shopping</a>
</body>
</html>
