<?php
session_start();
require_once 'includes/database.php';

// Get product ID from URL, validate it as integer
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id <= 0) {
    // Invalid ID, redirect or show error
    header("Location: products.php");
    exit;
}

// Fetch product info
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    // No product found, redirect or show error
    header("Location: products.php");
    exit;
}

// Fetch product options
$stmt2 = $pdo->prepare("SELECT * FROM product_options WHERE product_id = ?");
$stmt2->execute([$product_id]);
$options = $stmt2->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($product['name']) ?> - Contenkrate</title>
  <link rel="stylesheet" href="assets/css/youtubered-theme.css" />
  <style>
    /* Quick styling for product detail */
    .product-detail {
      max-width: 900px;
      margin: 20px auto;
      color: white;
      background: #1C1C1C;
      padding: 20px;
      border-radius: 8px;
    }
    .product-image {
      max-width: 100%;
      height: auto;
      border-radius: 6px;
      margin-bottom: 15px;
    }
    .option-list {
      list-style: none;
      padding-left: 0;
    }
    .option-list li {
      border: 1px solid #444;
      padding: 12px;
      margin-bottom: 10px;
      border-radius: 6px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .btn-primary {
      background: #FF0000;
      padding: 8px 15px;
      color: white;
      text-decoration: none;
      border-radius: 4px;
      transition: background 0.3s;
    }
    .btn-primary:hover {
      background: #FF4444;
    }
    pre.specifications {
      background: #222;
      padding: 15px;
      border-radius: 6px;
      overflow-x: auto;
      white-space: pre-wrap;
      word-wrap: break-word;
    }
  </style>
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<section class="product-detail">
  <h1><?= htmlspecialchars($product['name']) ?></h1>
  <img class="product-image" src="assets/images/products/<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" loading="lazy">

  <p><strong>Category:</strong> <?= htmlspecialchars($product['category']) ?></p>
  <p><strong>Base Price:</strong> $<?= number_format($product['base_price'], 2) ?></p>

  <p><strong>Description:</strong></p>
  <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

  <?php if ($product['amazon_ca_url']): ?>
    <p>
      <a href="<?= htmlspecialchars($product['amazon_ca_url']) ?>" target="_blank" rel="noopener" class="btn-primary">
        Buy on Amazon Canada
      </a>
    </p>
  <?php endif; ?>

  <h2>Specifications</h2>
  <?php if ($product['specifications']): ?>
    <?php
      $specs = json_decode($product['specifications'], true);
    ?>
 <ul>
  <?php foreach ($specs as $key => $value): ?>
    <li><strong><?= htmlspecialchars($key) ?>:</strong> <?= htmlspecialchars($value) ?></li>
  <?php endforeach; ?>
</ul>
 <?php else: ?>
    <p>No specifications available.</p>
  <?php endif; ?>

  <h2>Available Options</h2>
  <?php if (count($options) > 0): ?>
    <ul class="option-list">
      <?php foreach ($options as $option): ?>
        <li>
          <div>
            <strong><?= htmlspecialchars($option['option_name']) ?></strong><br>
            <small><?= nl2br(htmlspecialchars($option['option_description'])) ?></small>
          </div>
          <div>
            $<?= number_format($product['base_price'] + $option['price_modifier'], 2) ?><br>
            <?php if ($option['amazon_url']): ?>
              <a href="<?= htmlspecialchars($option['amazon_url']) ?>" target="_blank" rel="noopener" class="btn-primary">Buy</a>
            <?php else: ?>
              <span style="color: #ccc;">No link</span>
            <?php endif; ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>No options available.</p>
  <?php endif; ?>

  <p><a href="products.php" class="btn-primary" style="background:#555;">Back to All Products</a></p>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>
