<?php

// Allowed themes
$allowed_themes = ['youtubered', 'instapink', 'tiktokcyan'];

// Set theme if in GET and valid
if (isset($_GET['theme']) && in_array($_GET['theme'], $allowed_themes)) {
    $_SESSION['theme'] = $_GET['theme'];
}

// Current theme from session or default
$current_theme = $_SESSION['theme'] ?? 'youtubered';

// Prepare current query params without theme for URL building (for JS usage later)
$queryParams = $_GET;
unset($queryParams['theme']);
$currentQuery = http_build_query($queryParams);
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
    <a href="logout.php">Logout</a>
<?php else: ?>
    <a href="login.php">Login</a> | <a href="register.php">Register</a>
<?php endif; ?>
    </ul>
  </nav>

  <div class="theme-switcher" style="margin-left: 20px;">
    <label for="themeSelect" style="color: white; margin-right: 8px;">Theme:</label>
    <select id="themeSelect" style="padding: 5px; border-radius: 4px;">
      <option value="youtubered" <?= $current_theme === 'youtubered' ? 'selected' : '' ?>>YouTube Red</option>
      <option value="instapink" <?= $current_theme === 'instapink' ? 'selected' : '' ?>>Instagram Pink</option>
      <option value="tiktokcyan" <?= $current_theme === 'tiktokcyan' ? 'selected' : '' ?>>TikTok Cyan</option>
    </select>
  </div>
</header>

<script>
document.getElementById('themeSelect').addEventListener('change', function() {
  const selectedTheme = this.value;
  // Preserve current query parameters except theme
  const params = new URLSearchParams(window.location.search);
  params.set('theme', selectedTheme);
  // Redirect to current page with new theme parameter
  window.location.search = params.toString();
});
</script>
