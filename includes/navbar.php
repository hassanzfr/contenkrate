<?php
// You can add session or user logic here later if needed
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
    </ul>
  </nav>
</header>
