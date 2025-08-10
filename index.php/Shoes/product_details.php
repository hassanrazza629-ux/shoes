<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$id = intval($_GET['id']);
$query = $conn->prepare("SELECT * FROM products WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

if (isset($_POST['add_to_cart'])) {
    $cart_item = [
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => $_POST['quantity']
    ];
    $_SESSION['cart'][] = $cart_item;
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $product['name']; ?> - Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1><?php echo $product['name']; ?></h1>
<img src="uploads/<?php echo $product['image']; ?>" width="200">
<p><?php echo $product['description']; ?></p>
<p><b>Price:</b> $<?php echo $product['price']; ?></p>
<form method="post">
    <label>Quantity:</label>
    <input type="number" name="quantity" value="1" min="1" required>
    <button type="submit" name="add_to_cart">Add to Cart</button>
</form>
<a href="user_dashboard.php">Back to Shop</a>
</body>
</html>
