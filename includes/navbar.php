<?php
// Allowed themes
$allowed_themes = ['youtubered', 'instapink', 'tiktokcyan'];

// Set theme if in GET and valid (admin only)
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin' && 
    isset($_GET['theme']) && in_array($_GET['theme'], $allowed_themes)) {
    $_SESSION['theme'] = $_GET['theme'];
}

// Current theme from session or default
$current_theme = $_SESSION['theme'] ?? 'youtubered';
?>
<header>
    <a href="index.php" class="sticky-logo">
      <img src="/path/to/contentkrate-high-resolution-logo-transparent.png" alt="Contenkrate Small Logo">
    </a>

  <nav>
    <ul>
      <li><a href="index.php" <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'class="active"' : '' ?>>Home</a></li>
      <li><a href="products.php" <?= basename($_SERVER['PHP_SELF']) === 'products.php' ? 'class="active"' : '' ?>>Products</a></li>
      <li><a href="about.php" <?= basename($_SERVER['PHP_SELF']) === 'about.php' ? 'class="active"' : '' ?>>About</a></li>
      <li><a href="contact.php" <?= basename($_SERVER['PHP_SELF']) === 'contact.php' ? 'class="active"' : '' ?>>Contact</a></li>
      <li><a href="review.php" <?= basename($_SERVER['PHP_SELF']) === 'review.php' ? 'class="active"' : '' ?>>Reviews</a></li>
      <?php if (isset($_SESSION['user_id'])): ?>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
          <li><a href="admin/dashboard.php" <?= strpos($_SERVER['PHP_SELF'], 'admin/') !== false ? 'class="active"' : '' ?>>Admin</a></li>
        <?php endif; ?>
        <li><a href="profile.php" <?= basename($_SERVER['PHP_SELF']) === 'profile.php' ? 'class="active"' : '' ?>>Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
    <div class="theme-switcher">
      <label for="themeSelect" style="color: white; margin-right: 8px;">Theme:</label>
      <select id="themeSelect" style="padding: 5px; border-radius: 4px;">
        <option value="youtubered" <?= $current_theme === 'youtubered' ? 'selected' : '' ?>>YouTube Red</option>
        <option value="instapink" <?= $current_theme === 'instapink' ? 'selected' : '' ?>>Instagram Pink</option>
        <option value="tiktokcyan" <?= $current_theme === 'tiktokcyan' ? 'selected' : '' ?>>TikTok Cyan</option>
      </select>
    </div>
    <script>
    document.getElementById('themeSelect').addEventListener('change', function() {
      const selectedTheme = this.value;
      const params = new URLSearchParams(window.location.search);
      params.set('theme', selectedTheme);
      window.location.search = params.toString();
    });
    </script>
  <?php endif; ?>
</header>

<a href="index.php" class="floating-logo">
  <img src="assets\images\contentkrate-high-resolution-logo-transparent.png" alt="Contenkrate Logo">
</a>

<script>
  window.addEventListener('scroll', () => {
    const header = document.querySelector('header');
    if (window.scrollY > 100) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });
</script>
