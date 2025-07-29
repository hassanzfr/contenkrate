<?php
require_once 'includes/database.php';
require_once 'includes/functions.php';

session_start();
redirect_if_not_logged_in();

// Validate action
if (!isset($_POST['action']) || !in_array($_POST['action'], ['add', 'remove']) || !isset($_POST['product_id'])) {
    $_SESSION['error'] = "Invalid request";
    header("Location: products.php");
    exit;
}

$product_id = (int)$_POST['product_id'];
$user_id = $_SESSION['user_id'];

// Process action
if ($_POST['action'] === 'add') {
    if (add_to_wishlist($user_id, $product_id)) {
        $_SESSION['success'] = "Product added to wishlist";
    } else {
        $_SESSION['error'] = "Product is already in your wishlist";
    }
} else {
    if (remove_from_wishlist($user_id, $product_id)) {
        $_SESSION['success'] = "Product removed from wishlist";
    } else {
        $_SESSION['error'] = "Failed to remove product from wishlist";
    }
}

// Redirect back
$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'products.php';
header("Location: $redirect");
exit;