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