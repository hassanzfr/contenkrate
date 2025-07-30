<?php
require 'includes/database.php';

// Check if admin already exists
$stmt = $pdo->query("SELECT id FROM users WHERE email = 'admin@contenkrate.com'");
if ($stmt->fetch()) {
    die("Admin user already exists");
}

// Create admin user
$username = 'admin';
$email = 'admin@contenkrate.com';
$password = 'StrongAdminPassword123!'; // Change this to a secure password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, user_type, status, created_at) 
                          VALUES (?, ?, ?, 'admin', 'active', NOW())");
    $stmt->execute([$username, $email, $password_hash]);
    
    echo "Admin user created successfully!<br>";
    echo "Username: admin@contenkrate.com<br>";
    echo "Password: StrongAdminPassword123!<br>";
    echo "<strong>IMPORTANT:</strong> Change this password immediately after login!";
} catch (PDOException $e) {
    die("Error creating admin user: " . $e->getMessage());
}