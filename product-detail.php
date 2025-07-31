<?php
session_start();
require_once 'includes/database.php';
require_once 'includes/functions.php';

// Validate & fetch product
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($product_id <= 0) {
    header("Location: products.php");
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();
if (!$product) {
    header("Location: products.php");
    exit;
}

// Fetch options
$stmt2 = $pdo->prepare("SELECT * FROM product_options WHERE product_id = ?");
$stmt2->execute([$product_id]);
$options = $stmt2->fetchAll();

// Determine image path
$image_dir = 'assets/images/products/';
$allowed_ext = ['jpg','jpeg','png','webp'];
$image_path = 'assets/images/placeholder.png';
foreach ($allowed_ext as $ext) {
    $p = $image_dir . $product['id'] . ".$ext";
    if (file_exists($p)) { $image_path = $p; break; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($product['name']) ?> – Contenkrate</title>
  <link rel="stylesheet" href="assets/css/youtubered-theme.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<main class="product-details-container">
  <div class="product-details-flex-wrapper">
    
    <!-- Image Box -->
    <div class="product-details-image-box">
      <div class="product-details-image-container">
        <img class="product-details-image"
             src="<?= $image_path ?>"
             alt="<?= htmlspecialchars($product['name']) ?>"
             loading="lazy">
      </div>
    </div>
    
    <!-- Info Box -->
    <div class="product-details-info-box">
      <h1 class="product-details-title"><?= htmlspecialchars($product['name']) ?></h1>
      <p><strong>Category:</strong> <?= ucfirst(htmlspecialchars($product['category'])) ?></p>
      <div class="product-details-price">$<?= number_format($product['base_price'],2) ?></div>
      
      <!-- Action Buttons -->
      <div class="product-details-actions">
        <?php if (isset($_SESSION['user_id'])): ?>
          <?php if (is_in_wishlist($_SESSION['user_id'],$product['id'])): ?>
            <form action="wishlist-action.php" method="post">
              <input type="hidden" name="action" value="remove">
              <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
              <button class="product-details-btn product-details-btn-secondary">
                <i class="fas fa-heart"></i> Remove from Wishlist
              </button>
            </form>
          <?php else: ?>
            <form action="wishlist-action.php" method="post">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
              <button class="product-details-btn product-details-btn-primary">
                <i class="far fa-heart"></i> Add to Wishlist
              </button>
            </form>
          <?php endif; ?>
        <?php else: ?>
          <a href="login.php?redirect=product-detail.php?id=<?= $product['id'] ?>"
             class="product-details-btn product-details-btn-primary">
            <i class="far fa-heart"></i> Login to Add to Wishlist
          </a>
        <?php endif; ?>
        
        <?php if ($product['amazon_ca_url']): ?>
          <a href="<?= htmlspecialchars($product['amazon_ca_url']) ?>"
             target="_blank" rel="noopener"
             class="product-details-btn product-details-btn-primary">
            <i class="fab fa-amazon"></i> Buy on Amazon
          </a>
        <?php endif; ?>

        <button onclick="openModal('product-details-info-modal')"
                class="product-details-btn product-details-btn-secondary">
          <i class="fas fa-info-circle"></i> Product Details
        </button>

        <?php if (count($options) > 0): ?>
          <button onclick="openModal('product-details-options-modal')"
                  class="product-details-btn product-details-btn-tertiary">
            <i class="fas fa-cog"></i> View Options
          </button>
        <?php endif; ?>
      </div>
    </div>

  </div>

  <!-- Back Link -->
  <div style="text-align:center; margin-top:30px;">
    <a href="products.php" class="product-details-btn product-details-btn-secondary">
      <i class="fas fa-arrow-left"></i> Back to All Products
    </a>
  </div>
</main>

<!-- Info Modal -->
<div id="product-details-info-modal" class="product-details-modal">
  <div class="product-details-modal-content">
    <button class="product-details-close-modal"
            onclick="closeModal('product-details-info-modal')">&times;</button>
    <h2 class="product-details-modal-title">Product Details</h2>
    <h3>Description</h3>
    <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
    <h3>Specifications</h3>
    <?php if ($product['specifications']): ?>
      <?php $specs = json_decode($product['specifications'],true); ?>
      <ul class="product-details-specs-list">
        <?php foreach($specs as $k=>$v): ?>
          <li>
            <span class="product-details-spec-name"><?=htmlspecialchars($k)?>:</span>
            <span class="product-details-spec-value">
              <?= is_array($v)
                  ? htmlspecialchars(implode(', ',$v))
                  : htmlspecialchars($v) ?>
            </span>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No specifications available.</p>
    <?php endif; ?>
  </div>
</div>

<!-- Options Modal -->
<div id="product-details-options-modal" class="product-details-modal">
  <div class="product-details-modal-content">
    <button class="product-details-close-modal"
            onclick="closeModal('product-details-options-modal')">&times;</button>
    <h2 class="product-details-modal-title">Available Options</h2>
    <ul class="product-details-options-list">
      <?php foreach($options as $opt): ?>
        <li class="product-details-option-item">
          <h3><?= htmlspecialchars($opt['option_name']) ?></h3>
          <?php if ($opt['option_description']): ?>
            <p><?= nl2br(htmlspecialchars($opt['option_description'])) ?></p>
          <?php endif; ?>
          <p>Price: $<?= number_format($product['base_price'] + $opt['price_modifier'],2) ?></p>
          <?php if ($opt['amazon_url']): ?>
            <a href="<?= htmlspecialchars($opt['amazon_url']) ?>"
               target="_blank" rel="noopener"
               class="product-details-btn product-details-btn-primary">
              <i class="fab fa-amazon"></i> Buy This Option
            </a>
          <?php else: ?>
            <span>No purchase link</span>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<script>
function openModal(id) {
  document.getElementById(id).style.display = 'block';
  document.body.style.overflow = 'hidden';
}
function closeModal(id) {
  document.getElementById(id).style.display = 'none';
  document.body.style.overflow = 'auto';
}
window.onclick = e => {
  if (e.target.classList.contains('product-details-modal')) {
    e.target.style.display = 'none';
    document.body.style.overflow = 'auto';
  }
};
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
