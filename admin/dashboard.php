<?php
require_once '../includes/database.php';
require_once '../includes/functions.php';

session_start();
redirect_if_not_admin();

$analytics = get_site_analytics();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Contenkrate</title>
    <link rel="stylesheet" href="../assets/css/youtubered-theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <?php include '../includes/admin-navbar.php'; ?>
    
    <div class="admin-content">
        <h1>Admin Dashboard</h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p><?= $analytics['total_users'] ?></p>
                <i class="fas fa-users fa-2x"></i>
            </div>
            <div class="stat-card">
                <h3>Total Products</h3>
                <p><?= $analytics['total_products'] ?></p>
                <i class="fas fa-box-open fa-2x"></i>
            </div>
            <div class="stat-card">
                <h3>Total Orders</h3>
                <p><?= $analytics['total_orders'] ?></p>
                <i class="fas fa-shopping-cart fa-2x"></i>
            </div>
        </div>
        
        <div class="recent-orders">
            <h2>Recent Orders</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($analytics['recent_orders'] as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['order_number']) ?></td>
                        <td><?= date('M j, Y', strtotime($order['created_at'])) ?></td>
                        <td>$<?= number_format($order['total_amount'], 2) ?></td>
                        <td><?= ucfirst($order['status']) ?></td>
                        <td><a href="order-details.php?id=<?= $order['id'] ?>" class="btn-small">View</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>