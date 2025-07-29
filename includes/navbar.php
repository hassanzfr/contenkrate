<?php
// Allowed themes
$allowed_themes = ['youtubered', 'instapink', 'tiktokcyan'];

// Set theme if in GET and valid
if (isset($_GET['theme']) && in_array($_GET['theme'], $allowed_themes)) {
    $_SESSION['theme'] = $_GET['theme'];
}

// Current theme from session or default
$current_theme = $_SESSION['theme'] ?? 'youtubered';
?>
<header>
  <a href="index.php" class="logo">Contenkrate</a>
  <nav>
    <ul>
      <li><a href="index.php" <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'class="active"' : '' ?>>Home</a></li>
      <li><a href="products.php" <?= basename($_SERVER['PHP_SELF']) === 'products.php' ? 'class="active"' : '' ?>>Products</a></li>
      <li><a href="about.php" <?= basename($_SERVER['PHP_SELF']) === 'about.php' ? 'class="active"' : '' ?>>About</a></li>
      <li><a href="contact.php" <?= basename($_SERVER['PHP_SELF']) === 'contact.php' ? 'class="active"' : '' ?>>Contact</a></li>
      <li><a href="review.php" <?= basename($_SERVER['PHP_SELF']) === 'review.php' ? 'class="active"' : '' ?>>Reviews</a></li>
      <?php if (isset($_SESSION['user_id'])): ?>
        <li><a href="profile.php" <?= basename($_SERVER['PHP_SELF']) === 'profile.php' ? 'class="active"' : '' ?>>Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>