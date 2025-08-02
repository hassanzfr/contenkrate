<?php
include 'includes/navbar.php';

session_start();
require_once 'includes/database.php'; // $pdo PDO instance

// Force refresh when theme changes
$cache_buster = $_SESSION['theme_changed'] ?? time();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />


  <link rel="stylesheet" href="assets/css/<?= $current_theme ?>-theme.css?v=<?= $cache_buster ?>">

</head>
<body>
<!-- Inside your main container -->
<main class="about-page-container">
  <div class="about-page-content">

    <!-- Header Section -->

      <h1 class="about-page-title">About Contenkrate</h1>
      <p class="about-page-intro">
        Contenkrate is your go-to Canadian content creator equipment marketplace designed to empower both budding and professional creators across platforms like YouTube, Instagram, and TikTok. We specialize in providing a curated selection of the best creator tools, setup guides tailored to your content type and budget, and smart filtering options for faster product discovery.
      </p>


    <!-- Mission Block -->

      <p class="about-page-mission-text">
        Whether you're building a beginner setup or looking to upgrade with high-end gear, Contenkrate helps you make informed decisions with expert recommendations, user reviews, and affiliate-based purchasing options. With a strong emphasis on Canadian pricing and availability, our mission is to save creators time and money.
      </p>


    <!-- Features Section -->
    <section class="about-page-features">
      <h2 class="about-page-features-title">Our Features</h2>
      <ul class="about-page-features-list">
        <li class="about-page-feature-item"> • Curated product recommendations for creators</li>
        <li class="about-page-feature-item"> • Setup guides based on platform and budget</li>
        <li class="about-page-feature-item"> • Interactive tools and reviews to support smart purchases</li>
        <li class="about-page-feature-item"> • Multiple layout themes and responsive design</li>
        <li class="about-page-feature-item"> • Admin dashboard for content management and user control</li>
      </ul>
    </section>

  </div>
</main>
</body>
<?php
include 'includes/footer.php';
?>

</html>

