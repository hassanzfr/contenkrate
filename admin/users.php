<?php
require_once '../includes/database.php';
require_once '../includes/functions.php';

session_start();
redirect_if_not_admin();

// Handle user deletion
if (isset($_GET['delete'])) {
    $user_id = (int)$_GET['delete'];
    if ($user_id === $_SESSION['user_id']) {
        $_SESSION['error'] = "You cannot delete your own account";
    } else {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        if ($stmt->execute([$user_id])) {
            $_SESSION['success'] = "User deleted successfully";
        } else {
            $_SESSION['error'] = "Failed to delete user";
        }
    }
    header("Location: users.php");
    exit();
}

// Fetch all users
$users = get_all_users();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users - Contenkrate</title>
    <link rel="stylesheet" href="../assets/css/youtubered-theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <?php include '../includes/admin-navbar.php'; ?>
    
    <div class="admin-content">
        <h1>Manage Users</h1>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Joined</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= date('M j, Y', strtotime($user['created_at'])) ?></td>
                    <td><?= ucfirst($user['user_type'] ?? 'user') ?></td>
                    <td class="actions">
                        <a href="user-edit.php?id=<?= $user['id'] ?>" class="btn-small"><i class="fas fa-edit"></i></a>
                        <a href="users.php?delete=<?= $user['id'] ?>" class="btn-small btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>