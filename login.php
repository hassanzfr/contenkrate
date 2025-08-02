<?php
session_start();
require 'includes/database.php';

$errors = [];
$cache_buster = $_SESSION['theme_changed'] ?? time();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF protection
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errors[] = "Invalid CSRF token";
    } else {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 'active'");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['user_role'] = $user['user_type']; // For admin functions
                
                $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $stmt->execute([$user['id']]);
                
                // Redirect admin to dashboard
                if ($user['user_type'] === 'admin') {
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            } else {
                $errors[] = "Invalid credentials or account inactive.";
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}

// Generate CSRF token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login - Contenkrate</title>
  <link rel="stylesheet" href="assets/css/<?= $current_theme ?>-theme.css?v=<?= $cache_buster ?>">

</head>
<body>
  <div class="auth-container">
    <div class="auth-box">
      <h2 class="auth-title">Login</h2>
      
      <?php foreach ($errors as $error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
      <?php endforeach; ?>
      
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
      <?php endif; ?>
      
      <form method="post" action="" class="auth-form">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" required />
        </div>
        
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required />
        </div>
        
        <button type="submit" class="btn btn-primary btn-block">Login</button>
      </form>
      
      <div class="auth-links">
        <p>No account yet? <a href="register.php">Register here</a></p>
        <p><a href="forgot-password.php">Forgot password?</a></p>
      </div>
    </div>
  </div>
</body>
</html>