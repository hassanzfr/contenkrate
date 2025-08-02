
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'contenkrate');
define('DB_USER', 'root');
define('DB_PASS', ''); // Use your local MySQL password if any


// Database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


function getCurrentTheme() {
    global $conn;
    $query = "SELECT setting_value FROM site_settings WHERE setting_name = 'current_theme'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['current_theme'] = $row['setting_value']; // Update session
        return $row['setting_value'];
    }
    return 'youtubered'; // default theme
}

$current_theme = getCurrentTheme();
?>