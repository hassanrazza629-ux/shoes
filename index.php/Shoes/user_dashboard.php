<?php
// user_dashboard.php
session_start();
require 'db.php';

// Ensure logged in (if you want public browsing remove this check)
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

// get categories
$cats = $pdo->query("SELECT * FROM categories ORDER BY category_name ASC")->fetchAll(PDO::FETCH_ASSOC);

// which category selected?
$cat_id = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
if ($cat_id === 0 && count($cats)>0) {
    // default to first category
    $cat_id = $cats[0]['category_id'];
}

// fetch products for category
$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? ORDER BY product_id DESC");
$stmt->execute([$cat_id]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>User Dashboard</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="header">
        <div class="brand">
          <div class="logo">S</div>
          <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
        </div>
        <div style="display:flex;gap:10px;align-items:center">
          <a class="button secondary" href="admin_dashboard.php">Admin</a>
          <a class="button" href="logout.php">Logout</a>
        </div>
      </div>

      <div class="grid">
        <div>
          <div class="card sidebar" style="padding:16px;">
            <h3>Categories</h3>
            <div class="nav">
              <?php foreach($cats as $c): 
                $active = ($c['category_id']==$cat_id) ? 'active' : '';
              ?>
                <a class="<?php echo $active?>" href="?cat=<?php echo $c['category_id']; ?>"><?php echo htmlspecialchars($c['category_name']); ?></a>
              <?php endforeach; ?>
            </div>
          </div>

          <div style="margin-top:16px" class="card">
            <h3>About</h3>
            <p style="color:#6b7280;font-size:14px">Browse shoes by category. Click a product to see details (you can extend this to a product page).</p>
          </div>
        </div>

        <div>
          <div class="card">
            <h3>Products</h3>
            <?php if(empty($products)): ?>
              <p style="color:#6b7280">No products found in this category.</p>
            <?php else: ?>
              <div class="products" style="margin-top:12px">
                <?php foreach($products as $p): ?>
                  <div class="product">
                    <?php
                      $img = !empty($p['image_url']) ? 'uploads/'.htmlspecialchars($p['image_url']) : 'https://via.placeholder.com/84';
                    ?>
                    <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($p['product_name']); ?>">
                    <div class="p-info">
                      <h4><?php echo htmlspecialchars($p['product_name']); ?></h4>
                      <div class="p-meta">Price: Rs <?php echo number_format($p['price'],2); ?> • Stock: <?php echo (int)$p['stock']; ?></div>
                      <p style="margin-top:8px;color:#374151;font-size:14px"><?php echo htmlspecialchars(substr($p['description'],0,120)); ?></p>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

    </div>
  </div>
</body>
</html>
