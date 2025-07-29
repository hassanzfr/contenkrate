<?php
session_start();
require_once 'includes/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contenkrate - Home</title>
  <link rel="stylesheet" href="assets/css/youtubered-theme.css">
  <link rel="stylesheet" href="assets/css/common.css"> <!-- common styles -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <?php include 'includes/navbar.php'; ?>

    <section class="hero">
    <div class="hero-content">
      <h1>Welcome to Contenkrate</h1>
      <p>Your ultimate Canadian marketplace for content creation gear.</p>
      <a href="calculator.php" class="btn-primary">Try the Setup Calculator</a>
    </div>
  </section>

    <section class="featured-products">
    <h2>Featured Products</h2>
    <div class="product-grid">
      <?php
      $stmt = $pdo->prepare("SELECT * FROM products WHERE is_featured = 1 LIMIT 4");
      $stmt->execute();
      $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($products as $product) {
          echo '<div class="product-card">';
          echo '<img src="assets/images/products/' . htmlspecialchars($product['image_url']) . '" alt="' . htmlspecialchars($product['name']) . '">';
          echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
          echo '<p>' . htmlspecialchars($product['category']) . '</p>';
          echo '<a href="product-detail.php?id=' . $product['id'] . '" class="btn-secondary">View Details</a>';
          echo '</div>';
      }
      ?>
    </div>
  </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
