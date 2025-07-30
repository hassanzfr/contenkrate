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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Additional styles for featured products */
    .featured-products {
      padding: 40px 20px;
      background-color: #1C1C1C;
      margin-top: 30px;
    }
    
    .featured-products h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #FF0000;
    }
    
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 25px;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .product-card {
      background: #252525;
      border: 1px solid #2D2D2D;
      border-radius: 8px;
      padding: 15px;
      transition: transform 0.3s;
    }
    
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    
    .product-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 6px;
      margin-bottom: 15px;
    }
    
    .product-card h3 {
      margin: 0 0 10px 0;
      font-size: 1.2rem;
    }
    
    .product-card p {
      color: #aaa;
      margin-bottom: 15px;
    }
    
    .btn-secondary {
      display: inline-block;
      background: #555;
      color: white;
      padding: 8px 15px;
      border-radius: 4px;
      text-decoration: none;
      transition: background 0.3s;
    }
    
    .btn-secondary:hover {
      background: #666;
    }
  </style>
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
          
          echo '<div class="product-card">';
          echo '<img src="' . $image_path . '" alt="' . htmlspecialchars($product['name']) . '" loading="lazy">';
          echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
          echo '<p>' . ucfirst(htmlspecialchars($product['category'])) . '</p>';
          echo '<a href="product-detail.php?id=' . $product['id'] . '" class="btn-secondary">View Details</a>';
          echo '</div>';
      }
      ?>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>
</body>
</html>