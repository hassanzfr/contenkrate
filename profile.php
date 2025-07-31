<?php
require_once 'includes/database.php';
require_once 'includes/functions.php';

session_start();
redirect_if_not_logged_in();

$user_id = $_SESSION['user_id'];
$wishlist_items = get_wishlist_items($user_id);

// Handle remove from wishlist if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_wishlist'])) {
    $product_id = (int)$_POST['product_id'];
    if (remove_from_wishlist($user_id, $product_id)) {
        $_SESSION['success'] = "Item removed from wishlist";
        header("Location: profile.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to remove item from wishlist";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile - Contenkrate</title>
  <link rel="stylesheet" href="assets/css/youtubered-theme.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="profile-container">
  <!-- Display success/error messages -->
  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
      <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
  <?php endif; ?>
  
  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error">
      <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
  <?php endif; ?>

  <div class="profile-header">
    <div class="profile-avatar">
      <i class="fas fa-user"></i>
    </div>
    <div class="profile-info">
      <h1><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></h1>
      <p>Member since <?= date('F Y', strtotime($_SESSION['created_at'] ?? 'now')) ?></p>
    </div>
  </div>

  <div class="tab-container">
    <div class="tab-buttons">
      <button class="tab-button active" data-tab="wishlist">My Wishlist</button>
      <button class="tab-button" data-tab="account">Account Settings</button>
    </div>
  </div>

  <div id="wishlist" class="tab-content active">
    <h2 class="section-title">My Wishlist</h2>
    
    <?php if (count($wishlist_items) > 0): ?>
      <div class="wishlist-grid">
        <?php foreach ($wishlist_items as $item): ?>
          <div class="wishlist-item">
            <div class="wishlist-item-content">
              <h3><?= htmlspecialchars($item['name']) ?></h3>
              <p>$<?= number_format($item['base_price'], 2) ?></p>
              <div class="wishlist-actions">
                <a href="product-detail.php?id=<?= $item['id'] ?>" class="btn-primary">View</a>
                <form action="profile.php" method="post" style="display:inline;">
                  <input type="hidden" name="remove_wishlist" value="1">
                  <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                  <button type="submit" class="btn btn-secondary">Remove</button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="empty-wishlist">
        <i class="far fa-heart"></i>
        <h3>Your wishlist is empty</h3>
        <p>Add products to your wishlist to save them for later</p>
        <a href="products.php" class="btn-primary">Browse Products</a>
      </div>
    <?php endif; ?>
  </div>

  <div id="account" class="tab-content">
    <h2 class="section-title">Account Settings</h2>
    <div class="account-settings">
      <form action="update-profile.php" method="post">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" value="<?= htmlspecialchars($_SESSION['username'] ?? '') ?>">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>">
        </div>
        <button type="submit" class="btn-primary">Update Profile</button>
      </form>
      
      <div class="change-password">
        <h3>Change Password</h3>
        <form action="change-password.php" method="post">
          <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" required>
          </div>
          <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" required>
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
          </div>
          <button type="submit" class="btn-primary">Change Password</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
// Tab functionality
document.querySelectorAll('.tab-button').forEach(button => {
  button.addEventListener('click', () => {
    // Remove active class from all buttons and contents
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    
    // Add active class to clicked button and corresponding content
    button.classList.add('active');
    const tabId = button.getAttribute('data-tab');
    document.getElementById(tabId).classList.add('active');
  });
});
</script>
</body>
</html>