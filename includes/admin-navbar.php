<?php
// includes/admin-navbar.php
?>
<header class="admin-navbar">
  <div class="admin-nav-container">
    <a href="dashboard.php" class="admin-logo">Contenkrate Admin</a>
    
    <div class="admin-nav-right">
      <nav class="admin-main-nav">
        <ul>
          <li class="<?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>">
            <a href="dashboard.php">Dashboard</a>
          </li>
          <li class="<?= basename($_SERVER['PHP_SELF']) === 'products.php' ? 'active' : '' ?>">
            <a href="products.php">Products</a>
          </li>
          <li class="<?= basename($_SERVER['PHP_SELF']) === 'users.php' ? 'active' : '' ?>">
            <a href="users.php">Users</a>

          </li>

          <li>
            <a href="../products.php" target="_blank" class="storefront-btn">Storefront</a>
          </li>

          <li>
            <a href="wiki.php">Help</a>
          </li>

          <li>
            <a href="../docs.php">Docs</a>
          </li>


          <li>
            <a href="../logout.php">Logout</a>
          </li>
        </ul>
      </nav>

    </div>
  </div>
</header>