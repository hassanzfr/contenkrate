<footer>
  <div class="footer-container">
    <p>&copy; <?= date('Y') ?> Contenkrate. All rights reserved.</p>
    <nav class="footer-nav">
      <a href="privacy.php">Privacy Policy</a>
      <span>|</span>
      <a href="terms.php">Terms of Service</a>
      <span>|</span>
      <a href="about.php">About Us</a>
      <span>|</span>
      <a href="contact.php">Contact</a>
    </nav>
  </div>

  <style>
    footer {
      background-color: #1C1C1C;
      color: #888;
      padding: 15px 20px;
      text-align: center;
      font-size: 14px;
      border-top: 1px solid #333;
      margin-top: 40px;
    }
    .footer-container {
      max-width: 1200px;
      margin: 0 auto;
    }
    .footer-nav {
      margin-top: 8px;
    }
    .footer-nav a {
      color: #888;
      text-decoration: none;
      margin: 0 8px;
      transition: color 0.3s ease;
    }
    .footer-nav a:hover {
      color: #FF0000;
    }
    .footer-nav span {
      color: #555;
    }
  </style>
</footer>
