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
        </div>
        
       
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>