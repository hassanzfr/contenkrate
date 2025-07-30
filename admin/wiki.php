<?php
require_once '../includes/database.php';
require_once '../includes/functions.php';

session_start();
redirect_if_not_admin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Documentation - Contenkrate</title>
    <link rel="stylesheet" href="../assets/css/youtubered-theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <?php include '../includes/admin-navbar.php'; ?>
    
    <div class="admin-content">
        <h1>Admin Documentation</h1>
        
        <div class="wiki-container">
            <div class="wiki-section">
                <h2>Getting Started</h2>
                <div class="feature-card">
                    <h3>How to Access Admin Dashboard</h3>
                    <p>After logging in with an admin account, you'll be automatically redirected to the admin dashboard.</p>
                </div>
                
                <div class="feature-card">
                    <h3>Admin Account Security</h3>
                    <p>Your admin account has full access to the system. Follow these security best practices:</p>
                    <ul>
                        <li>Use a strong, unique password</li>
                        <li>Never share your credentials</li>
                        <li>Log out after each session</li>
                    </ul>
                </div>
            </div>
            
            <div class="wiki-section">
                <h2>Admin Features</h2>
                <div class="feature-card">
                    <h3>Product Management</h3>
                    <p>As an admin, you can:</p>
                    <ul>
                        <li>Add/edit/remove products</li>
                        <li>Mark products as featured</li>
                        <li>Manage categories</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>