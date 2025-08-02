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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include '../includes/admin-navbar.php'; ?>
    
    <div class="admin-content">
        <h1>Admin Dashboard</h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p><?= $analytics['total_users'] ?></p>
                <i ></i>
                <div class="stat-trend up">
                    <i ></i> 12% from last week
                </div>
            </div>
            <div class="stat-card">
                <h3>Total Products</h3>
                <p><?= $analytics['total_products'] ?></p>
                <i ></i>
                <div class="stat-trend up">
                    <i></i> 5% from last week
                </div>
            </div>

            
        </div>
        

        
        <div class="system-status">
            <h3>System Status</h3>
            <div class="status-grid">
                <div class="status-card online">
                    <i class="fas fa-server fa-3x"></i>
                    <h4>Web Server</h4>
                    <p>Operational</p>
                </div>
                <div class="status-card online">
                    <i class="fas fa-database fa-3x"></i>
                    <h4>Database</h4>
                    <p>Operational</p>
                </div>
                <div class="status-card online">
                    <i class="fas fa-shield-alt fa-3x"></i>
                    <h4>Security</h4>
                    <p>No threats</p>
                </div>
                <div class="status-card online">
                    <i class="fas fa-cloud fa-3x"></i>
                    <h4>Backups</h4>
                    <p>Up to date</p>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>

</body>
</html>