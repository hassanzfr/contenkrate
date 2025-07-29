<?php
session_start();
require_once 'includes/database.php'; // Make sure this creates a $pdo PDO instance

// --- Step 1: Get filter inputs safely ---
$category = $_GET['category'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$search = $_GET['search'] ?? '';

// --- Step 2: Build dynamic SQL with filters ---
$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

// Validate category filter before adding
$valid_categories = ['cameras', 'audio', 'lighting', 'software', 'accessories'];
if ($category !== '' && in_array($category, $valid_categories)) {
    $sql .= " AND category = ?";
    $params[] = $category;
}

// Min price filter
if (is_numeric($min_price)) {
    $sql .= " AND base_price >= ?";
    $params[] = $min_price;
}

// Max price filter
if (is_numeric($max_price)) {
    $sql .= " AND base_price <= ?";
    $params[] = $max_price;
}

// Search keyword filter (case-insensitive)
if ($search !== '') {
    $sql .= " AND name LIKE ?";
    $params[] = "%$search%";
}

$sql .= " ORDER BY created_at DESC";

// --- Step 3: Prepare and execute query ---
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>All Products - Contenkrate</title>
  <link rel="stylesheet" href="assets/css/youtubered-theme.css" />
  <style>
    /* Quick inline styling to help form layout - adjust or move to your CSS */
    .filter-form label {
      margin-right: 5px;
    }
    .filter-form input,
    .filter-form select {
      margin-right: 15px;
      padding: 4px 6px;
    }
    .filter-form button {
      padding: 6px 12px;
      cursor: pointer;
    }
    .product-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    .product-card {
      width: calc(33% - 20px);
      border: 1px solid #444;
      border-radius: 6px;
      padding: 10px;
      background: #1C1C1C;
      color: white;
      box-sizing: border-box;
      text-align: center;
    }
    .product-card img {
      max-width: 100%;
      height: auto;
      margin-bottom: 10px;
      border-radius: 4px;
    }
    .btn-primary {
      display: inline-block;
      background: #FF0000;
      color: white;
      padding: 8px 15px;
      text-decoration: none;
      border-radius: 4px;
      transition: background 0.3s;
    }
    .btn-primary:hover {
      background: #FF4444;
    }
  </style>
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<section class="product-listing">
  <h1>All Products</h1>

  <!-- Filter Form -->
  <form method="GET" action="products.php" class="filter-form" style="margin-bottom: 20px;">
    <label for="category">Category:</label>
    <select name="category" id="category">
      <option value="" <?= $category === '' ? 'selected' : '' ?>>All</option>
      <option value="cameras" <?= $category === 'cameras' ? 'selected' : '' ?>>Cameras</option>
      <option value="audio" <?= $category === 'audio' ? 'selected' : '' ?>>Audio</option>
      <option value="lighting" <?= $category === 'lighting' ? 'selected' : '' ?>>Lighting</option>
      <option value="software" <?= $category === 'software' ? 'selected' : '' ?>>Software</option>
      <option value="accessories" <?= $category === 'accessories' ? 'selected' : '' ?>>Accessories</option>
    </select>

    <label for="min_price">Min Price:</label>
    <input type="number" name="min_price" id="min_price" min="0" step="0.01" placeholder="0.00" value="<?= htmlspecialchars($min_price) ?>">

    <label for="max_price">Max Price:</label>
    <input type="number" name="max_price" id="max_price" min="0" step="0.01" placeholder="10000" value="<?= htmlspecialchars($max_price) ?>">

    <label for="search">Search:</label>
    <input type="text" name="search" id="search" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">

    <button type="submit" class="btn-primary">Filter</button>
  </form>

  <!-- Products Grid -->
  <div class="product-grid">
    <?php while ($product = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
      <div class="product-card">
        <img src="assets/images/products/<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" loading="lazy">
        <h3><?= htmlspecialchars($product['name']) ?></h3>
        <p>Category: <?= htmlspecialchars($product['category']) ?></p>
        <p>From $<?= number_format($product['base_price'], 2) ?></p>
        <a href="product-detail.php?id=<?= (int)$product['id'] ?>" class="btn-primary">View</a>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>
