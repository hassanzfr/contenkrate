<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define allowed themes and corresponding CSS files
$allowed_themes = ['youtubered', 'instapink', 'tiktokcyan'];
$current_theme = $_SESSION['theme'] ?? 'youtubered';

$theme_css_files = [
    'youtubered' => 'assets/css/youtubered-theme.css',
    'instapink'  => 'assets/css/instapink-theme.css',
    'tiktokcyan' => 'assets/css/tiktokcyan-theme.css',
];

// Fallback to default if somehow invalid
if (!in_array($current_theme, $allowed_themes)) {
    $current_theme = 'youtubered';
}
?>

<footer>
  <div class="footer-container" style="max-width:1200px; margin:0 auto; padding:20px; text-align:center; color:#ccc; font-size:0.9rem; border-top:1px solid #333;">
    <p>&copy; <?= date('Y') ?> Contenkrate. All rights reserved.</p>
    <nav class="footer-nav" style="margin-top:10px;">
      <a href="privacy.php" style="color:#ccc; text-decoration:none; margin:0 8px;">Privacy Policy</a>
      <span style="color:#555;">|</span>
      <a href="terms.php" style="color:#ccc; text-decoration:none; margin:0 8px;">Terms of Service</a>
      <span style="color:#555;">|</span>
      <a href="about.php" style="color:#ccc; text-decoration:none; margin:0 8px;">About Us</a>
      <span style="color:#555;">|</span>
      <a href="contact.php" style="color:#ccc; text-decoration:none; margin:0 8px;">Contact</a>
    </nav>
  </div>

  <!-- Theme CSS dynamically included -->
  <link rel="stylesheet" href="<?= htmlspecialchars($theme_css_files[$current_theme]) ?>" />
</footer>
