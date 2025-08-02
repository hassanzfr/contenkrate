<?php
// includes/admin-navbar.php
require_once __DIR__ . '/../includes/config.php';

// Theme to banner mapping
$theme_banners = [
    'youtubered' => 'banner1', // Blue theme
    'instapink' => 'banner2',  // Pink theme
    'tiktokcyan' => 'banner3'  // Green theme
];
$current_banner = $theme_banners[$current_theme] ?? 'banner1';
?>

<header class="admin-navbar">
  <div class="admin-nav-container">
    <a href="dashboard.php" class="admin-logo">Contenkrate Admin</a>
    
    <div class="admin-nav-right">
      <nav class="admin-main-nav">
        <ul>
          <li class="<?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>">
            <a href="dashboard.php">Dashboard</a>
          </li>
          <li class="<?= basename($_SERVER['PHP_SELF']) === 'products.php' ? 'active' : '' ?>">
            <a href="products.php">Products</a>
          </li>
          <li class="<?= basename($_SERVER['PHP_SELF']) === 'users.php' ? 'active' : '' ?>">
            <a href="users.php">Users</a>
          </li>

          <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
          <li class="theme-switcher-container">
            <div class="theme-switcher">
              <label for="themeSelect">Theme:</label>
              <select id="themeSelect">
                <option value="youtubered" <?= $current_theme === 'youtubered' ? 'selected' : '' ?>>Blue</option>
                <option value="instapink" <?= $current_theme === 'instapink' ? 'selected' : '' ?>>Pink</option>
                <option value="tiktokcyan" <?= $current_theme === 'tiktokcyan' ? 'selected' : '' ?>>Green</option>
              </select>
            </div>
            <div class="banner-preview">
              <img src="../assets/images/<?= $current_banner ?>.png" alt="Current Banner" class="banner-thumbnail">
              <span>Current Banner</span>
            </div>
          </li>
          <?php endif; ?>

          <li>
            <a href="../products.php" target="_blank" class="storefront-btn">Storefront</a>
          </li>

          <li>
            <a href="wiki.php">Help</a>
          </li>

          <li>
            <a href="../docs.php">Docs</a>
          </li>

          <li>
            <a href="../logout.php">Logout</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</header>

<?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
<script>
document.getElementById('themeSelect').addEventListener('change', function() {
    const selectedTheme = this.value;
    const themeName = this.options[this.selectedIndex].text;
    
    fetch('../update-theme.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'theme=' + encodeURIComponent(selectedTheme)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update banner preview
            const bannerMap = {
                'youtubered': 'banner1',
                'instapink': 'banner2',
                'tiktokcyan': 'banner3'
            };
            document.querySelector('.banner-thumbnail').src = `../assets/images/${bannerMap[selectedTheme]}.png?t=${new Date().getTime()}`;
            
            // Force refresh the storefront
            window.open('../index.php?force_refresh=1', '_blank');
            
            // Show notification
            const notification = document.createElement('div');
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.backgroundColor = '#4CAF50';
            notification.style.color = 'white';
            notification.style.padding = '15px';
            notification.style.borderRadius = '5px';
            notification.style.zIndex = '1000';
            notification.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
            notification.innerHTML = `
                <p>Theme and banner changed to ${themeName}!</p>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }
    });
});
</script>
<?php endif; ?>

<style>
/* Original CSS preserved */
.admin-navbar .theme-switcher-container {
    display: flex;
    align-items: center;
    padding: 0 15px;
}

.admin-navbar .theme-switcher {
    display: flex;
    align-items: center;
}

.admin-navbar .theme-switcher label {
    color: white;
    margin-right: 8px;
    font-size: 14px;
}

.admin-navbar .theme-switcher select {
    padding: 5px;
    border-radius: 4px;
    border: 1px solid #ddd;
    background: var(--bg-dark-secondary);
    font-size: 14px;
}

/* New banner preview styles */
.banner-preview {
    margin-left: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.banner-thumbnail {
    width: 80px;
    height: auto;
    border: 2px solid white;
    border-radius: 4px;
}

.banner-preview span {
    color: white;
    font-size: 12px;
    margin-top: 5px;
}
</style>