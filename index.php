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
  <link rel="stylesheet" href="assets/css/common.css">
  <link rel="stylesheet" href="assets/css/home-products.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <?php include 'includes/navbar.php'; ?>

  <!-- Banner Section -->
  <section class="main-banner">
    <img src="assets/images/banner.png" alt="Contenkrate Banner" class="banner-image">
    <div class="banner-content">
    </div>
  </section>

  <section class="home-products-section">
    <h2 class="home-products-title">Featured Products</h2>
    <div class="home-products-grid">
      <?php
      $stmt = $pdo->prepare("SELECT * FROM products WHERE is_featured = 1 LIMIT 4");
      $stmt->execute();
      $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      // Image settings
      $image_dir = 'assets/images/products/';
      $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
      
      foreach ($products as $product) {
          // Find product image by ID
          $image_path = 'assets/images/placeholder.png'; // default fallback
          
          foreach ($allowed_extensions as $ext) {
              $potential_path = $image_dir . $product['id'] . '.' . $ext;
              if (file_exists($potential_path)) {
                  $image_path = $potential_path;
                  break;
              }
          }
          
          echo '<div class="home-product-card">';
          echo '<img src="' . $image_path . '" alt="' . htmlspecialchars($product['name']) . '" loading="lazy" class="home-product-image">';
          echo '<h3 class="home-product-name">' . htmlspecialchars($product['name']) . '</h3>';
          echo '<p class="home-product-category">' . ucfirst(htmlspecialchars($product['category'])) . '</p>';
          echo '<a href="product-detail.php?id=' . $product['id'] . '" class="home-product-btn">View Details</a>';
          echo '</div>';
      }
      ?>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>
</body>
</html>