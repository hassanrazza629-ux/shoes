<?php
require 'db.php';

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $name = $_POST['product_name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // Insert product into DB
        $sql = "INSERT INTO products (category_id, product_name, description, price, stock, image_url) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$category, $name, $description, $price, $stock, $image]);
        $message = "Product added successfully!";
    } else {
        $message = "Error uploading image.";
    }
}

// Fetch categories from DB
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            background-color: #f0f0f0;
        }
        .sidebar {
            background-color: #8B0000;
            width: 220px;
            height: 100vh;
            padding: 20px;
            color: white;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
            margin-bottom: 10px;
            background: #a00000;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background: #b30000;
        }
        .content {
            flex: 1;
            padding: 30px;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #8B0000;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        button:hover {
            background-color: #a00000;
        }
        .message {
            color: green;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="#">Add Men Shoes</a>
        <a href="#">Add Women Shoes</a>
        <a href="#">Add Kids Shoes</a>
        <a href="#">Add Sale Shoes</a>
    </div>

    <div class="content">
        <h2 style="text-align:center;">Add New Product</h2>
        <p class="message"><?= $message ?></p>

        <div class="form-container">
            <form method="POST" enctype="multipart/form-data">
                <label>Category</label>
                <select name="category" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['category_id'] ?>"><?= $cat['category_name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Product Name</label>
                <input type="text" name="product_name" required>

                <label>Description</label>
                <textarea name="description" rows="3"></textarea>

                <label>Price</label>
                <input type="number" step="0.01" name="price" required>

                <label>Stock</label>
                <input type="number" name="stock" required>

                <label>Image</label>
                <input type="file" name="image" accept="image/*" required>

                <button type="submit">Add Product</button>
            </form>
        </div>
    </div>

</body>
</html>
