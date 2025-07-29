<?php
session_start();
require_once 'includes/database.php'; // $pdo PDO instance

// --- Step 1: Get filter inputs safely ---
$category = $_GET['category'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$search = $_GET['search'] ?? '';

// --- Step 2: Valid categories ---
$valid_categories = ['cameras', 'audio', 'lighting', 'software', 'accessories'];

// --- Step 3: Build dynamic SQL with filters ---
$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

// Category filter
if ($category !== '' && in_array($category, $valid_categories)) {
    $sql .= " AND category = :category";
    $params[':category'] = $category;
}

// Min price filter
if (is_numeric($min_price)) {
    $sql .= " AND base_price >= :min_price";
    $params[':min_price'] = $min_price;
}

// Max price filter
if (is_numeric($max_price)) {
    $sql .= " AND base_price <= :max_price";
    $params[':max_price'] = $max_price;
}

// Search keyword filter (case-insensitive)
if ($search !== '') {
    $sql .= " AND name LIKE :search";
    $params[':search'] = "%" . $search . "%";
}

$sql .= " ORDER BY created_at DESC";

// --- Step 4: Prepare and execute query ---
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>All Products - Contenkrate</title>
  <link rel="stylesheet" href="assets/css/youtubered-theme.css" />
  <style>
    /* Inline CSS for filter form and product grid */
    body {
      background-color: #0F0F0F;
      color: #fff;
      font-family: Arial, sans-serif;
      margin: 0; padding: 0;
    }
    .filter-form {
      padding: 20px;
      background: #1C1C1C;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      align-items: center;
    }
    .filter-form label {
      margin-right: 5px;
      white-space: nowrap;
    }
    .filter-form input[type="text"],
    .filter-form input[type="number"],
    .filter-form select {
      padding: 6px 10px;
      border: none;
      border-radius: 4px;
      background: #2D2D2D;
      color: white;
      min-width: 120px;
    }
    .filter-form button {
      background: #FF0000;
      border: none;
      padding: 8px 15px;
      color: white;
      border-radius: 4px;
      cursor: pointer;
      transition: background 0.3s;
    }
    .filter-form button:hover {
      background: #FF4444;
    }
    .product-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      padding: 20px;
      justify-content: center;
    }
    .product-card {
      background: #1C1C1C;
      border: 1px solid #2D2D2D;
      border-radius: 8px;
      width: 300px;
      padding: 15px;
      box-sizing: border-box;
      text-align: center;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .product-card img {
      max-width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 6px;
      margin-bottom: 15px;
      background-color: #000; /* fallback */
    }
    .btn-primary {
      display: inline-block;
      background: #FF0000;
      color: white;
      padding: 10px 18px;
      text-decoration: none;
      border-radius: 4px;
      margin-top: 10px;
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
  <h1 style="padding: 20px;">All Products</h1>

  <!-- Filter Form -->
  <form method="GET" action="products.php" class="filter-form" aria-label="Product filters">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">

    <label for="category">Category:</label>
    <select id="category" name="category">
      <option value="" <?= $category === '' ? 'selected' : '' ?>>All Categories</option>
      <?php foreach ($valid_categories as $cat): ?>
        <option value="<?= htmlspecialchars($cat) ?>" <?= $cat === $category ? 'selected' : '' ?>><?= ucfirst($cat) ?></option>
      <?php endforeach; ?>
    </select>

    <label for="min_price">Min Price:</label>
    <input type="number" id="min_price" name="min_price" min="0" step="0.01" placeholder="0.00" value="<?= htmlspecialchars($min_price) ?>">

    <label for="max_price">Max Price:</label>
    <input type="number" id="max_price" name="max_price" min="0" step="0.01" placeholder="10000" value="<?= htmlspecialchars($max_price) ?>">

    <button type="submit">Filter</button>
  </form>

  <div class="product-grid">
    <?php if (count($products) > 0): ?>
      <?php foreach ($products as $product):
          // Determine image path or fallback placeholder
          $image_path = 'assets/images/placeholder.png'; // default placeholder

          if (!empty($product['image_url'])) {
              $product_image_path = __DIR__ . '/assets/images/products/' . $product['image_url'];
              if (file_exists($product_image_path)) {
                  $image_path = 'assets/images/products/' . htmlspecialchars($product['image_url']);
              }
          }
      ?>
        <div class="product-card">
          <img src="<?= $image_path ?>" alt="<?= htmlspecialchars($product['name']) ?>" width="800px" height="800px">
          <h3><?= htmlspecialchars($product['name']) ?></h3>
          <p>Category: <?= htmlspecialchars($product['category']) ?></p>
          <p>From $<?= number_format($product['base_price'], 2) ?></p>
          <a href="product-detail.php?id=<?= $product['id'] ?>" class="btn-primary">View</a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="text-align:center;">No products found.</p>
    <?php endif; ?>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>
