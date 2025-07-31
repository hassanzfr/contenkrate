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

// Image settings
$image_dir = 'assets/images/products/';
$allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>All Products - Contenkrate</title>
  <link rel="stylesheet" href="assets/css/youtubered-theme.css" />
  <link rel="stylesheet" href="assets/css/products.css" />
</head>
<body class="products-page">
<?php include 'includes/navbar.php'; ?>

<section class="product-listing">

  <!-- Filter Form -->
  <form method="GET" action="products.php" class="products-filter-form" aria-label="Product filters">
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

  <div class="products-grid">
    <?php if (count($products) > 0): ?>
      <?php foreach ($products as $product):
          // Find product image by ID
          $image_path = 'assets/images/placeholder.png'; // default fallback
          
          foreach ($allowed_extensions as $ext) {
              $potential_path = $image_dir . $product['id'] . '.' . $ext;
              if (file_exists($potential_path)) {
                  $image_path = $potential_path;
                  break;
              }
          }
      ?>
        <div class="products-product-card">
          <img src="<?= $image_path ?>" 
               alt="<?= htmlspecialchars($product['name']) ?>"
               width="800"
               height="800">
          <h3><?= htmlspecialchars($product['name']) ?></h3>
          <p>Category: <?= htmlspecialchars($product['category']) ?></p>
          <p>From $<?= number_format($product['base_price'], 2) ?></p>
          <a href="product-detail.php?id=<?= $product['id'] ?>" class="products-btn-primary">View</a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="products-no-results">No products found.</p>
    <?php endif; ?>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>