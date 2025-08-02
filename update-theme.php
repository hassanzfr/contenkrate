<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if (isset($_POST['theme'])) {
    $theme = trim($_POST['theme']);
    $valid_themes = ['youtubered', 'instapink', 'tiktokcyan'];
    
    if (in_array($theme, $valid_themes)) {
        // Update database
        $query = "UPDATE site_settings SET setting_value = ? WHERE setting_name = 'current_theme'";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $theme);
        $result = mysqli_stmt_execute($stmt);
        
        if ($result) {
            // Update session and clear all caches
            $_SESSION['current_theme'] = $theme;
            $_SESSION['theme_changed'] = time(); // Timestamp for cache busting
            clearstatcache();
            
            echo json_encode(['success' => true]);
            exit;
        }
    }
}

echo json_encode(['success' => false, 'message' => 'Invalid theme or update failed']);
?>