<?php
require_once 'includes/config.php';

$page = isset($_GET['page']) ? basename($_GET['page']) : 'products';
$valid_pages = ['products', 'product-detail', 'profile'];
if (!in_array($page, $valid_pages)) {
    header("Location: help.php?page=products");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Help Center - ContentKrate</title>
    <link rel="stylesheet" href="assets/css/<?= $current_theme ?>-theme.css">
    <style>
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
        
        .help-header {
            border-bottom: 1px solid var(--help-border);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        
        .help-title {
            color: var(--help-accent);
            font-size: 2rem;
        }
        
        .help-nav {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--help-border);
        }
        
        .help-nav a {
            color: var(--help-text);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.2s;
        }
        
        .help-nav a:hover,
        .help-nav a.active {
            background: var(--help-accent);
            color: white;
        }
        
        .help-section {
            margin-bottom: 2rem;
        }
        
        .help-section h2 {
            color: var(--help-accent);
            border-bottom: 1px solid var(--help-border);
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .help-card {
            background: var(--help-card-bg);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--help-border);
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="help-container">
        <div class="help-header">
            <h1 class="help-title">Help Center</h1>
            <p>Find answers to your questions</p>
        </div>
        
<div class="help-nav">
    <a href="help.php?page=products" class="<?= $page === 'products' ? 'active' : '' ?>">Products</a>
    <a href="help.php?page=product-detail" class="<?= $page === 'product-detail' ? 'active' : '' ?>">Product Details</a>
    <a href="help.php?page=profile" class="<?= $page === 'profile' ? 'active' : '' ?>">Profile</a>
</div>
        
        <div class="help-main">
            <div class="help-card">
                <?php include "includes/wiki/user/{$page}.php"; ?>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>