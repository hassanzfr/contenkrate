<nav class="navbar">
  <div class="logo"><a href="index.php">Contenkrate</a></div>
  <ul class="nav-links">
    <li><a href="products.php">Catalog</a></li>
    <li><a href="setups.php">Setup Guides</a></li>
    <li><a href="blog.php">Blog</a></li>
    <li><a href="contact.php">Contact</a></li>
    <?php if (isset($_SESSION['user_id'])): ?>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="logout.php">Logout</a></li>
    <?php else: ?>
      <li><a href="login.php">Login</a></li>
      <li><a href="register.php">Sign Up</a></li>
    <?php endif; ?>
  </ul>
</nav>
