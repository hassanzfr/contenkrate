<?php
require_once '../includes/database.php';
require_once '../includes/functions.php';

session_start();
redirect_if_not_admin();

// Handle product deletion
if (isset($_GET['delete'])) {
    $product_id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    if ($stmt->execute([$product_id])) {
        $_SESSION['success'] = "Product deleted successfully";
    } else {
        $_SESSION['error'] = "Failed to delete product";
    }
    header("Location: products.php");
    exit();
}

// Fetch all products ordered by ID descending
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products - Contenkrate</title>
    <link rel="stylesheet" href="../assets/css/youtubered-theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <?php include '../includes/admin-navbar.php'; ?>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1>Manage Products</h1>
            <a href="product-edit.php" class="btn-primary"><i class="fas fa-plus"></i> Add Product</a>
        </div>
        
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
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Featured</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= ucfirst($product['category']) ?></td>
                    <td>$<?= number_format($product['base_price'], 2) ?></td>
                    <td data-featured="<?= $product['is_featured'] ?>"><?= $product['is_featured'] ? 'Yes' : 'No' ?></td>
                    <td class="actions">
                        <a href="product-edit.php?id=<?= $product['id'] ?>" class="btn-small"><i class="fas fa-edit"></i></a>
                        <a href="products.php?delete=<?= $product['id'] ?>" class="btn-small btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>