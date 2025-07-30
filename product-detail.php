<?php
session_start();
require_once 'includes/database.php';
require_once 'includes/functions.php';

// Get product ID from URL, validate it as integer
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id <= 0) {
    header("Location: products.php");
    exit;
}

// Fetch product info
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    header("Location: products.php");
    exit;
}

// Fetch product options
$stmt2 = $pdo->prepare("SELECT * FROM product_options WHERE product_id = ?");
$stmt2->execute([$product_id]);
$options = $stmt2->fetchAll();

// Image settings
$image_dir = 'assets/images/products/';
$allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
$image_path = 'assets/images/placeholder.png'; // default fallback

// Find product image by ID
foreach ($allowed_extensions as $ext) {
    $potential_path = $image_dir . $product['id'] . '.' . $ext;
    if (file_exists($potential_path)) {
        $image_path = $potential_path;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($product['name']) ?> - Contenkrate</title>
  <link rel="stylesheet" href="assets/css/youtubered-theme.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    .product-detail {
      max-width: 900px;
      margin: 20px auto;
      color: white;
      background: #1C1C1C;
      padding: 30px;
      border-radius: 8px;
      border: 1px solid #2D2D2D;
    }
    
    .product-image-container {
      max-width: 100%;
      margin: 0 auto 25px;
      text-align: center;
    }
    
    .product-image {
      max-width: 100%;
      max-height: 500px;
      border-radius: 8px;
      object-fit: contain;
      box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }
    
    .product-meta {
      margin-bottom: 20px;
    }
    
    .product-meta p {
      margin: 8px 0;
      font-size: 1.1rem;
    }
    
    .price-highlight {
      color: #FF0000;
      font-size: 1.5rem;
      font-weight: bold;
    }
    
    .option-list {
      list-style: none;
      padding-left: 0;
      margin-top: 30px;
    }
    
    .option-list li {
      border: 1px solid #444;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 8px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #252525;
      transition: transform 0.3s;
    }
    
    .option-list li:hover {
      transform: translateX(5px);
      border-color: #FF0000;
    }
    
    .option-info {
      flex: 1;
    }
    
    .option-price {
      text-align: right;
      margin-left: 20px;
    }
    
    .specs-list {
      background: #252525;
      padding: 20px;
      border-radius: 8px;
      margin: 20px 0;
    }
    
    .specs-list li {
      margin-bottom: 10px;
      padding-bottom: 10px;
      border-bottom: 1px dashed #444;
    }
    
    .specs-list li:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }
    
    .wishlist-section {
      margin: 25px 0;
    }
    
    .btn-primary {
      display: inline-block;
      background: #FF0000;
      padding: 10px 20px;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      transition: all 0.3s;
      border: none;
      cursor: pointer;
      font-size: 1rem;
    }
    
    .btn-primary:hover {
      background: #FF4444;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(255,0,0,0.3);
    }
    
    .btn-secondary {
      background: #555;
    }
    
    .btn-secondary:hover {
      background: #666;
    }
    
    @media (max-width: 768px) {
      .option-list li {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .option-price {
        margin-left: 0;
        margin-top: 10px;
        text-align: left;
        width: 100%;
      }
      
      .product-image {
        max-height: 300px;
      }
    }
  </style>
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<section class="product-detail">
  <h1><?= htmlspecialchars($product['name']) ?></h1>
  
  <div class="product-image-container">
    <img class="product-image" src="<?= $image_path ?>" 
         alt="<?= htmlspecialchars($product['name']) ?>" 
         loading="lazy">
  </div>
  
  <div class="product-meta">
    <p><strong>Category:</strong> <?= ucfirst(htmlspecialchars($product['category'])) ?></p>
    <p class="price-highlight">$<?= number_format($product['base_price'], 2) ?></p>
  </div>
  
  <!-- Wishlist Button -->
  <div class="wishlist-section">
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php if (is_in_wishlist($_SESSION['user_id'], $product['id'])): ?>
            <form action="wishlist-action.php" method="post">
                <input type="hidden" name="action" value="remove">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="redirect" value="product-detail.php?id=<?= $product['id'] ?>">
                <button type="submit" class="btn-primary btn-secondary">
                    <i class="fas fa-heart"></i> Remove from Wishlist
                </button>
            </form>
        <?php else: ?>
            <form action="wishlist-action.php" method="post">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="redirect" value="product-detail.php?id=<?= $product['id'] ?>">
                <button type="submit" class="btn-primary">
                    <i class="far fa-heart"></i> Add to Wishlist
                </button>
            </form>
        <?php endif; ?>
    <?php else: ?>
        <a href="login.php?redirect=product-detail.php?id=<?= $product['id'] ?>" class="btn-primary">
            <i class="far fa-heart"></i> Login to Add to Wishlist
        </a>
    <?php endif; ?>
  </div>
  
  <div class="product-description">
    <h2>Description</h2>
    <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
  </div>
  
  <?php if ($product['amazon_ca_url']): ?>
    <div class="amazon-link" style="margin: 25px 0;">
      <a href="<?= htmlspecialchars($product['amazon_ca_url']) ?>" 
         target="_blank" 
         rel="noopener" 
         class="btn-primary">
        <i class="fab fa-amazon"></i> Buy on Amazon Canada
      </a>
    </div>
  <?php endif; ?>
  
  <div class="product-specs">
    <h2>Specifications</h2>
    <?php if ($product['specifications']): ?>
      <?php $specs = json_decode($product['specifications'], true); ?>
      <ul class="specs-list">
        <?php foreach ($specs as $key => $value): ?>
          <li><strong><?= htmlspecialchars($key) ?>:</strong> <?= htmlspecialchars($value) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No specifications available.</p>
    <?php endif; ?>
  </div>
  
  <div class="product-options">
    <h2>Available Options</h2>
    <?php if (count($options) > 0): ?>
      <ul class="option-list">
        <?php foreach ($options as $option): ?>
          <li>
            <div class="option-info">
              <h3><?= htmlspecialchars($option['option_name']) ?></h3>
              <?php if ($option['option_description']): ?>
                <p><?= nl2br(htmlspecialchars($option['option_description'])) ?></p>
              <?php endif; ?>
            </div>
            <div class="option-price">
              <p class="price-highlight">$<?= number_format($product['base_price'] + $option['price_modifier'], 2) ?></p>
              <?php if ($option['amazon_url']): ?>
                <a href="<?= htmlspecialchars($option['amazon_url']) ?>" 
                   target="_blank" 
                   rel="noopener" 
                   class="btn-primary">
                  Buy Option
                </a>
              <?php else: ?>
                <span style="color: #aaa;">Purchase link not available</span>
              <?php endif; ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No additional options available for this product.</p>
    <?php endif; ?>
  </div>
  
  <div style="margin-top: 40px; text-align: center;">
    <a href="products.php" class="btn-primary btn-secondary">
      <i class="fas fa-arrow-left"></i> Back to All Products
    </a>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>