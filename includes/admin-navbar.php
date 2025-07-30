<?php
// includes/admin-navbar.php
?>
<header class="admin-navbar">
  <div class="admin-nav-container">
    <a href="dashboard.php" class="admin-logo">Contenkrate Admin</a>
    
    <nav class="admin-main-nav">
      <ul>
        <li class="<?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>">
          <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) === 'products.php' ? 'active' : '' ?>">
          <a href="products.php"><i class="fas fa-box-open"></i> Products</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) === 'users.php' ? 'active' : '' ?>">
          <a href="users.php"><i class="fas fa-users"></i> Users</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'active' : '' ?>">
          <a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a>
        </li>
      </ul>
    </nav>
    
    <div class="admin-utility-nav">
      <ul>
        <li>
          <a href="../products.php" title="Store Front"><i class="fas fa-store"></i></a>
        </li>
        <li>
          <a href="wiki.php" title="Help"><i class="fas fa-question-circle"></i></a>
        </li>
        <li>
          <a href="../logout.php" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
        </li>
      </ul>
    </div>
  </div>
</header>