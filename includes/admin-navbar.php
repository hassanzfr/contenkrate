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


         <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
          <li class="theme-switcher-container">
            <div class="theme-switcher">
              <label for="themeSelect">Theme:</label>
              <select id="themeSelect">
                <option value="youtubered" <?= $current_theme === 'youtubered' ? 'selected' : '' ?>>Blue</option>
                <option value="instapink" <?= $current_theme === 'instapink' ? 'selected' : '' ?>>Green</option>
                <option value="tiktokcyan" <?= $current_theme === 'tiktokcyan' ? 'selected' : '' ?>>Pink</option>
              </select>
            </div>
          </li>
          <?php endif; ?>
          <li class="<?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>">
            <a href="dashboard.php">Dashboard</a>
          </li>
          <li class="<?= basename($_SERVER['PHP_SELF']) === 'products.php' ? 'active' : '' ?>">
            <a href="products.php">Products</a>
          </li>
          <li class="<?= basename($_SERVER['PHP_SELF']) === 'users.php' ? 'active' : '' ?>">
            <a href="users.php">Users</a>
          </li>

         

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
            // Update banner preview if exists
            const bannerMap = {
                'youtubered': 'banner1',
                'instapink': 'banner2',
                'tiktokcyan': 'banner3'
            };
            const bannerThumbnail = document.querySelector('.banner-thumbnail');
            if (bannerThumbnail) {
                bannerThumbnail.src = `../assets/images/${bannerMap[selectedTheme]}.png?t=${new Date().getTime()}`;
            }
            
            // Create and show notification
            const notification = document.createElement('div');
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            notification.style.color = 'white';
            notification.style.padding = '15px';
            notification.style.borderRadius = '8px';
            notification.style.zIndex = '1000';
            notification.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
            notification.style.display = 'flex';
            notification.style.flexDirection = 'column';
            notification.style.gap = '10px';
            notification.style.maxWidth = '300px';
            notification.style.backdropFilter = 'blur(5px)';
            notification.style.border = '1px solid rgba(255,255,255,0.1)';
            notification.style.transform = 'translateX(100%)';
            notification.style.transition = 'transform 0.3s ease-out';
            
            notification.innerHTML = `
                <div style="font-weight: bold; font-size: 16px;">Theme Changed</div>
                <div style="font-size: 14px;">${themeName} applied to Storefront</div>
                <button style="
                    background: rgba(255,255,255,0.2);
                    color: white;
                    border: none;
                    padding: 8px 12px;
                    border-radius: 4px;
                    cursor: pointer;
                    font-size: 14px;
                    margin-top: 5px;
                    transition: background 0.2s;
                " onclick="window.open('../index.php?force_refresh=1', '_blank')">
                    View Storefront
                </button>
            `;
            
            document.body.appendChild(notification);
            
            // Trigger the slide-in animation
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 5000);
            
            // Close on click outside
            notification.addEventListener('click', (e) => {
                if (e.target === notification) {
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }
            });
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