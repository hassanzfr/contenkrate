<?php
// admin/admin-sidebar.php
?>
<div class="admin-sidebar">
    <div class="admin-sidebar-header">
        <h3>Admin Panel</h3>
        <div class="admin-user-info">
            <i class="fas fa-user-circle"></i>
            <span><?= htmlspecialchars($_SESSION['username']) ?></span>
        </div>
    </div>
    
    <ul class="admin-menu">
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
        <li class="<?= basename($_SERVER['PHP_SELF']) === 'reviews.php' ? 'active' : '' ?>">
            <a href="reviews.php"><i class="fas fa-star"></i> Reviews</a>
        </li>
        <li class="<?= basename($_SERVER['PHP_SELF']) === 'wiki.php' ? 'active' : '' ?>">
            <a href="wiki.php"><i class="fas fa-book"></i> Guide</a>
        </li>
    </ul>
    
    <ul class="admin-actions">
        <li>
            <a href="../index.php"><i class="fas fa-store"></i> Store Front</a>
        </li>
        <li>
            <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
    </ul>
</div>