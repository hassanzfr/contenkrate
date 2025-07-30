<?php
require_once '../includes/database.php';
require_once '../includes/functions.php';

session_start();
redirect_if_not_admin();

$product = ['id' => 0, 'name' => '', 'category' => 'cameras', 'description' => '', 
            'base_price' => 0, 'amazon_ca_url' => '', 'image_url' => '', 
            'specifications' => '{}', 'is_featured' => 0];

// Edit mode - load product
if (isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        $_SESSION['error'] = "Product not found";
        header("Location: products.php");
        exit();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = [
        'id' => (int)$_POST['id'],
        'name' => trim($_POST['name']),
        'category' => $_POST['category'],
        'description' => trim($_POST['description']),
        'base_price' => (float)$_POST['base_price'],
        'amazon_ca_url' => filter_var(trim($_POST['amazon_ca_url']), FILTER_SANITIZE_URL),
        'image_url' => trim($_POST['image_url']),
        'specifications' => json_encode($_POST['specs']),
        'is_featured' => isset($_POST['is_featured']) ? 1 : 0
    ];
    
    // Validate
    $errors = [];
    if (empty($product['name'])) $errors[] = "Product name is required";
    if (!in_array($product['category'], ['cameras', 'audio', 'lighting', 'software', 'accessories'])) {
        $errors[] = "Invalid category";
    }
    if ($product['base_price'] < 0) $errors[] = "Price cannot be negative";

    if (empty($errors)) {
        try {
            if ($product['id'] > 0) {
                // Update existing product
                $stmt = $pdo->prepare("UPDATE products SET 
                    name = ?, category = ?, description = ?, base_price = ?, 
                    amazon_ca_url = ?, image_url = ?, specifications = ?, is_featured = ? 
                    WHERE id = ?");
                $stmt->execute([
                    $product['name'], $product['category'], $product['description'],
                    $product['base_price'], $product['amazon_ca_url'], $product['image_url'],
                    $product['specifications'], $product['is_featured'], $product['id']
                ]);
                $_SESSION['success'] = "Product updated successfully";
            } else {
                // Insert new product
                $stmt = $pdo->prepare("INSERT INTO products 
                    (name, category, description, base_price, amazon_ca_url, image_url, specifications, is_featured) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $product['name'], $product['category'], $product['description'],
                    $product['base_price'], $product['amazon_ca_url'], $product['image_url'],
                    $product['specifications'], $product['is_featured']
                ]);
                $_SESSION['success'] = "Product added successfully";
            }
            header("Location: products.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = "Database error: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = implode("<br>", $errors);
    }
}

// Convert specifications JSON to array
$specs = json_decode($product['specifications'], true) ?: [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $product['id'] ? 'Edit' : 'Add' ?> Product - Contenkrate</title>
    <link rel="stylesheet" href="../assets/css/youtubered-theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <?php include '../includes/admin-navbar.php'; ?>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1><?= $product['id'] ? 'Edit Product' : 'Add New Product' ?></h1>
            <a href="products.php" class="btn-primary"><i class="fas fa-arrow-left"></i> Back to Products</a>
        </div>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <form method="post" class="product-form">
            <input type="hidden" name="id" value="<?= $product['id'] ?>">
            
            <div class="form-group">
                <label for="name">Product Name*</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="category">Category*</label>
                    <select id="category" name="category" required>
                        <option value="cameras" <?= $product['category'] === 'cameras' ? 'selected' : '' ?>>Cameras</option>
                        <option value="audio" <?= $product['category'] === 'audio' ? 'selected' : '' ?>>Audio</option>
                        <option value="lighting" <?= $product['category'] === 'lighting' ? 'selected' : '' ?>>Lighting</option>
                        <option value="software" <?= $product['category'] === 'software' ? 'selected' : '' ?>>Software</option>
                        <option value="accessories" <?= $product['category'] === 'accessories' ? 'selected' : '' ?>>Accessories</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="base_price">Base Price ($)*</label>
                    <input type="number" id="base_price" name="base_price" step="0.01" min="0" 
                           value="<?= number_format($product['base_price'], 2) ?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="amazon_ca_url">Amazon Canada URL</label>
                    <input type="url" id="amazon_ca_url" name="amazon_ca_url" 
                           value="<?= htmlspecialchars($product['amazon_ca_url']) ?>">
                </div>
                
                <div class="form-group">
                    <label for="image_url">Image URL</label>
                    <input type="text" id="image_url" name="image_url" 
                           value="<?= htmlspecialchars($product['image_url']) ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_featured" <?= $product['is_featured'] ? 'checked' : '' ?>>
                    <span>Featured Product</span>
                </label>
            </div>
            
            <div class="form-group">
                <label>Specifications</label>
                <div id="specs-container">
                    <?php foreach ($specs as $key => $value): ?>
                        <div class="spec-row">
                            <input type="text" name="specs[key][]" value="<?= htmlspecialchars($key) ?>" placeholder="Key" required>
                            <input type="text" name="specs[value][]" value="<?= htmlspecialchars($value) ?>" placeholder="Value" required>
                            <button type="button" class="btn-small btn-danger remove-spec"><i class="fas fa-times"></i></button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" id="add-spec" class="btn-small"><i class="fas fa-plus"></i> Add Specification</button>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-primary">Save Product</button>
                <a href="products.php" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
    
    <?php include '../includes/footer.php'; ?>
    
    <script>
    // Add/remove specification fields
    document.getElementById('add-spec').addEventListener('click', function() {
        const container = document.getElementById('specs-container');
        const div = document.createElement('div');
        div.className = 'spec-row';
        div.innerHTML = `
            <input type="text" name="specs[key][]" placeholder="Key" required>
            <input type="text" name="specs[value][]" placeholder="Value" required>
            <button type="button" class="btn-small btn-danger remove-spec"><i class="fas fa-times"></i></button>
        `;
        container.appendChild(div);
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-spec')) {
            e.target.closest('.spec-row').remove();
        }
    });
    </script>
</body>
</html>