<?php
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function redirect_if_not_logged_in() {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit();
    }
}

/**
 * Wishlist functions
 */
function add_to_wishlist($user_id, $product_id) {
    global $pdo;
    
    // Check if already in wishlist
    $stmt = $pdo->prepare("SELECT id FROM wishlists WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    
    if ($stmt->fetch()) {
        return false; // Already in wishlist
    }
    
    // Add to wishlist
    $stmt = $pdo->prepare("INSERT INTO wishlists (user_id, product_id) VALUES (?, ?)");
    return $stmt->execute([$user_id, $product_id]);
}

function remove_from_wishlist($user_id, $product_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM wishlists WHERE user_id = ? AND product_id = ?");
    return $stmt->execute([$user_id, $product_id]);
}

function get_wishlist_items($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT p.*, w.id as wishlist_id 
        FROM products p
        JOIN wishlists w ON p.id = w.product_id
        WHERE w.user_id = ?
        ORDER BY w.created_at DESC
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function is_in_wishlist($user_id, $product_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM wishlists WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    return (bool)$stmt->fetch();
}

// Add these to your existing functions.php

function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function redirect_if_not_admin() {
    if (!is_admin()) {
        header("Location: index.php");
        exit();
    }
}

function get_all_users() {
    global $pdo;
    $stmt = $pdo->query("SELECT id, username, email, created_at FROM users ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_user_details($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_site_analytics() {
    global $pdo;
    return [
        'total_users' => $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(),
        'total_products' => $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn(),
        'total_orders' => $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
        'recent_orders' => $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC)
    ];
}

function showThemeChangeNotification() {
    if (isset($_SESSION['theme_change_notification'])) {
        $notification = $_SESSION['theme_change_notification'];
        unset($_SESSION['theme_change_notification']);
        
        echo <<<HTML
        <div id="theme-change-notification" style="position: fixed; top: 20px; right: 20px; background-color: #4CAF50; color: white; padding: 15px; border-radius: 5px; z-index: 1000; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <p>Site theme has been updated to: {$notification['theme_name']}</p>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('theme-change-notification').remove();
            }, 5000);
        </script>
HTML;
    }
}

function currentPageURL() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}