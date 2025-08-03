<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';


// Define valid help pages
$valid_pages = ['products', 'users', 'dashboard'];
$page = isset($_GET['page']) && in_array($_GET['page'], $valid_pages) ? $_GET['page'] : 'products';

// Set the help content path
$help_content = "../includes/wiki/admin/{$page}.php";
$sidebar_content = "../includes/wiki/admin/{$page}-sidebar.php";

// Verify files exist
if (!file_exists($help_content)) {
    $help_content = "../includes/wiki/admin/products.php";
}
if (!file_exists($sidebar_content)) {
    $sidebar_content = "../includes/wiki/admin/products-sidebar.php";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Help - ContentKrate</title>
    <link rel="stylesheet" href="../assets/css/<?= $current_theme ?>-theme.css">
    <style>
        /* Dark theme styles from previous implementation */
        :root {
            --help-bg: #1a1a1a;
            --help-text: #e0e0e0;
            --help-border: #333;
            --help-accent: var(--accent-one);
            --help-card-bg: #252525;
        }
        
        .help-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--help-bg);
            color: var(--help-text);
        }
        
        /* Rest of your admin help styles */
    </style>
</head>
<body>
    <?php include '../includes/admin-navbar.php'; ?>
    
    <div class="help-container">
        <div class="help-header">
            <h1 class="help-title">Admin Help Center</h1>
            <p>Documentation for store administrators</p>
        </div>
        
        <div class="help-nav">
            <a href="help.php?page=products" class="<?= $page === 'products' ? 'active' : '' ?>">Products</a>
            <a href="help.php?page=users" class="<?= $page === 'users' ? 'active' : '' ?>">Users</a>
        </div>
        
        <div class="help-content">
            <div class="help-sidebar">
                <?php include $sidebar_content; ?>
            </div>
            
            <div class="help-main">
                <?php include $help_content; ?>
            </div>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>