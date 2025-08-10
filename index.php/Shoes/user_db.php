<?php
// db.php
$host = "localhost";
$dbname = "shoes";
$username = "root"; // اگر تبدیل ہے تو بدل دیں
$password = "";     // اگر تبدیل ہے تو بدل دیں

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // production میں یہ پیغام چھپائیں اور لائگ کریں؛ یہاں debug کے لیے دکھایا گیا ہے
    die("Database connection failed: " . $e->getMessage());
}
