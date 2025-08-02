<?php
session_start();
require_once 'includes/database.php'; // $pdo PDO instance

// Force refresh when theme changes
$cache_buster = $_SESSION['theme_changed'] ?? time();

// Initialize cart if not set
if (!isset($_SESSION['cart_total'])) {
    $_SESSION['cart_total'] = 0.00;
    $_SESSION['cart_items'] = [];
}

// Handle adding items to cart
if (isset($_GET['add_to_cart'])) {
    $product_id = (int)$_GET['add_to_cart'];
    
    // Get product price from database
    $stmt = $pdo->prepare("SELECT base_price FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product) {
        $_SESSION['cart_total'] += $product['base_price'];
        $_SESSION['cart_items'][] = $product_id;
    }
}

// Handle resetting cart
if (isset($_GET['reset_cart'])) {
    $_SESSION['cart_total'] = 0.00;
    $_SESSION['cart_items'] = [];
}

// --- Filter inputs ---
$category = $_GET['category'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$search = $_GET['search'] ?? '';

// --- Build SQL query ---
$sql = "SELECT * FROM products WHERE 1=1";
$params = [];
$valid_categories = ['cameras', 'audio', 'lighting', 'software', 'accessories'];

if ($category !== '' && in_array($category, $valid_categories)) {
    $sql .= " AND category = :category";
    $params[':category'] = $category;
}

if (is_numeric($min_price)) {
    $sql .= " AND base_price >= :min_price";
    $params[':min_price'] = $min_price;
}

if (is_numeric($max_price)) {
    $sql .= " AND base_price <= :max_price";
    $params[':max_price'] = $max_price;
}

if ($search !== '') {
    $sql .= " AND name LIKE :search";
    $params[':search'] = "%" . $search . "%";
}

$sql .= " ORDER BY created_at DESC";

// Execute query
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

  <link rel="stylesheet" href="assets/css/<?= $current_theme ?>-theme.css?v=<?= $cache_buster ?>">

</head>
<body class="products-page">
<?php include 'includes/navbar.php'; ?>

<section class="product-listing">
  <!-- Cart Total Header -->
  <div class="cart-total-header">
    <h2>Current Total: $<?= number_format($_SESSION['cart_total'], 2) ?> USD</h2>
    <a href="products.php?reset_cart=1" class="reset-cart-btn">Reset Total</a>
  </div>

  <!-- Filter Form -->
  <form method="GET" action="products.php" class="products-filter-form" aria-label="Product filters">
    <div class="filter-group search-group">
      <input type="text" id="search" name="search" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
    </div>
    
    <div class="filter-group">
      <select id="category" name="category">
        <option value="">All Categories</option>
        <?php foreach ($valid_categories as $cat): ?>
          <option value="<?= htmlspecialchars($cat) ?>" <?= $cat === $category ? 'selected' : '' ?>><?= ucfirst($cat) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    
    <div class="filter-group">
      <input type="number" id="min_price" name="min_price" min="0" step="0.01" placeholder="Min Price" value="<?= htmlspecialchars($min_price) ?>">
    </div>
    
    <div class="filter-group">
      <input type="number" id="max_price" name="max_price" min="0" step="0.01" placeholder="Max Price" value="<?= htmlspecialchars($max_price) ?>">
    </div>
    
    <div class="filter-group submit-group">
      <button type="submit">Filter</button>
    </div>
  </form>

  <div class="products-grid">
    <?php if (count($products) > 0): ?>
      <?php foreach ($products as $product):
          $image_path = 'assets/images/placeholder.png';
          foreach ($allowed_extensions as $ext) {
              $potential_path = $image_dir . $product['id'] . '.' . $ext;
              if (file_exists($potential_path)) {
                  $image_path = $potential_path;
                  break;
              }
          }
      ?>
        <div class="products-product-card">
          <img src="<?= $image_path ?>" alt="<?= htmlspecialchars($product['name']) ?>" width="800" height="800">
          <h3><?= htmlspecialchars($product['name']) ?></h3>
          <p>Category: <?= htmlspecialchars($product['category']) ?></p>
          <p>From $<?= number_format($product['base_price'], 2) ?></p>
          <div class="product-card-buttons">
            <a href="product-detail.php?id=<?= $product['id'] ?>" class="products-btn-primary">View</a>
            <a href="products.php?add_to_cart=<?= $product['id'] ?>" class="products-btn-primary">Add (+$<?= number_format($product['base_price'], 2) ?>)</a>
          </div>
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