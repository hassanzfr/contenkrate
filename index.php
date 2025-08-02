<?php
session_start();
require_once 'includes/database.php';
require_once 'includes/config.php';

// Force refresh when theme changes
$cache_buster = $_SESSION['theme_changed'] ?? time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contenkrate - Home</title>
  <link rel="stylesheet" href="assets/css/<?= $current_theme ?>-theme.css?v=<?= $cache_buster ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <?php include 'includes/navbar.php'; ?>

  <!-- Banner Section -->
  <section class="main-banner">
    <?php
    // Get fresh theme from session
    $current_theme = $_SESSION['current_theme'] ?? 'youtubered';
    
    // Map themes to banner versions
    $theme_banners = [
        'youtubered' => 'banner1',
        'instapink' => 'banner2',
        'tiktokcyan' => 'banner3'
    ];
    
    $current_banner = $theme_banners[$current_theme] ?? 'banner1';
    ?>
    <img src="assets/images/<?= $current_banner ?>.png?v=<?= $cache_buster ?>" alt="Contenkrate Banner" class="banner-image">
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