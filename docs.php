<?php
// doc.php - Complete Documentation Page (Front-end & Back-end)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contenkrate Documentation</title>
   <script src="documentation.jss"></script>
    <style>
        /* CSS Variables from your main theme design system */
        :root {
            --bg-dark: #0F0F0F;
            --bg-dark-secondary: #0F0F0F;
            --bg-dark-tertiary: #0F0F0F;
            --text-primary: #fff;
            --text-secondary: #ddd;
            --text-tertiary: #aaa;
            --accent-one: #4384a6;
            --accent-two: #2b576e;
            --accent-three: #4CAF50;
            --border-dark: #333;
            --font-primary: sans-serif, 'Open Sans', 'Segoe UI', system-ui, sans-serif;
        }

        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-primary);
            font-family: var(--font-primary);
            line-height: 1.6;
        }

        /* Main Container */
        .doc-container {
            min-height: 100vh;
        }

        /* Header with Tabs */
        .doc-header {
            background-color: var(--bg-dark-secondary);
            border-bottom: 2px solid var(--border-dark);
            padding: 20px 0;
            position: relative;
            top: 0;
            z-index: 1000;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .doc-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .doc-title h1 {
            font-size: 2.5em;
            color: var(--accent-one);
            margin-bottom: 5px;
        }

        .doc-title p {
            color: var(--text-secondary);
            font-size: 1.1em;
        }

        /* Tab Navigation */
        .tab-nav {
            display: flex;
            justify-content: center;
            gap: 0;
        }

        .tab-btn {
            background: none;
            border: 2px solid var(--border-dark);
            color: var(--text-secondary);
            padding: 15px 30px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 0;
        }

        .tab-btn:first-child {
            border-radius: 8px 0 0 8px;
        }

        .tab-btn:last-child {
            border-radius: 0 8px 8px 0;
            border-left: none;
        }

        .tab-btn.active {
            background-color: var(--accent-one);
            color: var(--text-primary);
            border-color: var(--accent-one);
        }

        .tab-btn:hover:not(.active) {
            background-color: var(--accent-two);
            color: var(--text-primary);
        }

        /* Content Layout */
        .content-wrapper {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Tab Content */
        .tab-content {
            display: none;
            width: 100%;
        }

        .tab-content.active {
            display: flex;
        }

        /* Sidebar Navigation */
        .doc-sidebar {
            width: 280px;
            background-color: var(--bg-dark-secondary);
            border-right: 1px solid var(--border-dark);
            padding: 30px 20px;
            height: calc(100vh - 140px);
            overflow-y: auto;
            position: sticky;
            top: 0px;
        }

        .doc-sidebar h3 {
            color: var(--accent-one);
            margin-bottom: 20px;
            font-size: 1.3em;
            border-bottom: 2px solid var(--accent-one);
            padding-bottom: 10px;
        }

        .doc-nav ul {
            list-style: none;
        }

        .doc-nav ul li {
            margin-bottom: 8px;
        }

        .doc-nav ul li a {
            color: var(--text-secondary);
            text-decoration: none;
            padding: 8px 12px;
            display: block;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 0.95em;
        }

        .doc-nav ul li a:hover {
            background-color: var(--accent-one);
            color: var(--text-primary);
        }

        .doc-nav ul li.active a {
            background-color: var(--accent-two);
            color: var(--text-primary);
        }

        /* Main Content */
        .doc-content {
            flex: 1;
            padding: 40px;
            max-width: calc(100% - 280px);
        }

        /* Section Styles */
        .doc-section {
            margin-bottom: 50px;
            scroll-margin-top: 160px;
        }

        .doc-section h2 {
            color: var(--accent-one);
            font-size: 2em;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-dark);
        }

        .doc-section h3 {
            color: var(--text-primary);
            font-size: 1.4em;
            margin: 30px 0 15px 0;
        }

        .doc-section h4 {
            color: var(--text-primary);
            font-size: 1.2em;
            margin: 25px 0 10px 0;
        }

        .doc-section p {
            color: var(--text-secondary);
            margin-bottom: 15px;
            line-height: 1.7;
        }

        .doc-section ul {
            color: var(--text-secondary);
            margin-left: 20px;
            margin-bottom: 20px;
        }

        .doc-section ul li {
            margin-bottom: 8px;
        }

        /* Code Blocks */
        .code-block {
            background-color: #1a1a1a;
            border: 1px solid var(--border-dark);
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            overflow-x: auto;
            position: relative;
        }

        .code-block::before {
            position: absolute;
            top: 10px;
            right: 15px;
            background-color: var(--accent-one);
            color: var(--text-primary);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            font-weight: bold;
        }

        .code-block.css::before { content: 'CSS'; }
        .code-block.php::before { content: 'PHP'; }
        .code-block.sql::before { content: 'SQL'; }
        .code-block.text::before { content: 'TEXT'; }

        .code-block pre {
            color: #f8f8f2;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
            line-height: 1.4;
            margin: 0;
        }

        /* Color Variables Display */
        .color-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .color-item {
            background-color: var(--bg-dark-secondary);
            border: 1px solid var(--border-dark);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }

        .color-preview {
            width: 100%;
            height: 60px;
            border-radius: 6px;
            margin-bottom: 10px;
            border: 1px solid var(--border-dark);
        }

        .color-name {
            font-weight: bold;
            color: var(--text-primary);
            margin-bottom: 5px;
        }

        .color-value {
            color: var(--text-tertiary);
            font-family: monospace;
            font-size: 0.9em;
        }

        /* Component Examples */
        .component-example {
            background-color: var(--bg-dark-secondary);
            border: 1px solid var(--border-dark);
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .component-example h4 {
            color: var(--accent-one);
            margin-bottom: 15px;
        }

        /* Button Examples */
        .btn-primary {
            background-color: var(--accent-one);
            color: var(--text-primary);
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .btn-secondary {
            background-color: #555;
            color: var(--text-primary);
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .btn-danger {
            background-color: #F44336;
            color: var(--text-primary);
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        /* Database Schema Table */
        .schema-table {
            background-color: var(--bg-dark-secondary);
            border: 1px solid var(--border-dark);
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            overflow-x: auto;
        }

        .schema-table h4 {
            color: var(--accent-one);
            margin-bottom: 15px;
            border-bottom: 1px solid var(--border-dark);
            padding-bottom: 8px;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .content-wrapper {
                flex-direction: column;
            }

            .doc-sidebar {
                width: 100%;
                height: auto;
                position: static;
                border-right: none;
                border-bottom: 1px solid var(--border-dark);
            }

            .doc-content {
                max-width: 100%;
                padding: 20px;
            }

            .tab-btn {
                padding: 12px 20px;
                font-size: 1em;
            }
        }

        @media (max-width: 768px) {
            .doc-title h1 {
                font-size: 2em;
            }

            .doc-section h2 {
                font-size: 1.6em;
            }

            .code-block {
                padding: 15px;
            }

            .color-grid {
                grid-template-columns: 1fr;
            }

            .tab-nav {
                flex-direction: column;
                align-items: center;
            }

            .tab-btn {
                border-radius: 8px !important;
                margin-bottom: 5px;
                border-left: 2px solid var(--border-dark) !important;
            }
        }

        /* Scroll Behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-dark);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent-one);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-two);
        }
    </style>
</head>
<body>
    <div class="doc-container">
        <!-- Header with Tab Navigation -->
        <header class="doc-header">
            <div class="header-content">
                <div class="doc-title">
                    <h1>Contenkrate Documentation</h1>
                    <p>Complete front-end and back-end documentation, along admin inside back-end</p>
                </div>
                <nav class="tab-nav">
                    <button class="tab-btn active" onclick="switchTab('frontend')">Front-end</button>
                    <button class="tab-btn" onclick="switchTab('backend')">Back-end</button>
                </nav>
            </div>
        </header>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Frontend Tab Content -->
            <div id="frontend" class="tab-content active">
                <!-- Frontend Sidebar -->
                <aside class="doc-sidebar">
                    <h3>Front-end Docs</h3>
                    <nav class="doc-nav">
                        <ul>
                            <li class="active"><a href="#fe-overview">Overview</a></li>
                            <li><a href="#fe-color-variables">Color Variables</a></li>
                            <li><a href="#fe-base-styles">Base Styles</a></li>
                            <li><a href="#fe-buttons">Buttons</a></li>
                            <li><a href="#fe-layout-components">Layout Components</a></li>
                            <li><a href="#fe-header-nav">Header & Navigation</a></li>
                            <li><a href="#fe-footer">Footer</a></li>
                            <li><a href="#fe-product-components">Product Components</a></li>
                            <li><a href="#fe-auth-components">Auth Components</a></li>
                            <li><a href="#fe-admin-dashboard">Admin Dashboard</a></li>
                            <li><a href="#fe-responsive-design">Responsive Design</a></li>
                        </ul>
                    </nav>
                </aside>

                <!-- Frontend Main Content -->
                <main class="doc-content">
                    <!-- Frontend Overview Section -->
                    <section id="fe-overview" class="doc-section">
                        <h2>Front-end Overview</h2>
                        <p>This documentation covers the CSS styles for the main theme, including:</p>
                        <ul>
                            <li>Color variables and design system</li>
                            <li>Base styles and typography</li>
                            <li>Component styles (buttons, cards, forms)</li>
                            <li>Layout components (header, footer, grids)</li>
                            <li>Page-specific styles (product pages, admin, auth)</li>
                            <li>Responsive design breakpoints</li>
                        </ul>
                    </section>

                    <!-- Frontend Color Variables Section -->
                    <section id="fe-color-variables" class="doc-section">
                        <h2>Color Variables</h2>
                        <p>Our main theme design system uses CSS custom properties for consistent theming:</p>
                        
                        <div class="code-block css">
                            <pre>:root {
  --bg-dark: #0F0F0F;
  --bg-dark-secondary: #0F0F0F;
  --bg-dark-tertiary: #0F0F0F;
  --text-primary: #fff;
  --text-secondary: #ddd;
  --text-tertiary: #aaa;
  --accent-one: #4384a6;
  --accent-two: #2b576e;
  --accent-three: #4CAF50;
  --border-dark: #333;
  --font-primary: sans-serif, 'Open Sans', 'Segoe UI', system-ui, sans-serif;
}</pre>
                        </div>

                        <div class="color-grid">
                            <div class="color-item">
                                <div class="color-preview" style="background-color: #0F0F0F;"></div>
                                <div class="color-name">Background Dark</div>
                                <div class="color-value">--bg-dark: #0F0F0F</div>
                            </div>
                            <div class="color-item">
                                <div class="color-preview" style="background-color: #fff;"></div>
                                <div class="color-name">Text Primary</div>
                                <div class="color-value">--text-primary: #fff</div>
                            </div>
                            <div class="color-item">
                                <div class="color-preview" style="background-color: #4384a6;"></div>
                                <div class="color-name">Accent One</div>
                                <div class="color-value">--accent-one: #4384a6</div>
                            </div>
                            <div class="color-item">
                                <div class="color-preview" style="background-color: #2b576e;"></div>
                                <div class="color-name">Accent Two</div>
                                <div class="color-value">--accent-two: #2b576e</div>
                            </div>
                            <div class="color-item">
                                <div class="color-preview" style="background-color: #4CAF50;"></div>
                                <div class="color-name">Accent Three</div>
                                <div class="color-value">--accent-three: #4CAF50</div>
                            </div>
                        </div>
                    </section>

                    <!-- Frontend Base Styles Section -->
                    <section id="fe-base-styles" class="doc-section">
                        <h2>Base Styles</h2>
                        <p>Foundation styles for typography and basic elements:</p>
                        
                        <div class="code-block css">
                            <pre>body {
  background-color: var(--bg-dark);
  color: var(--text-primary);
  font-family: var(--font-primary);
  margin: 0;
  padding: 0;
}

a { 
  color: var(--accent-one); 
  text-decoration: none; 
}
a:hover { 
  color: var(--accent-two); 
}</pre>
                        </div>
                    </section>

                    <!-- Frontend Buttons Section -->
                    <section id="fe-buttons" class="doc-section">
                        <h2>Buttons</h2>
                        <p>Various button styles for different use cases:</p>

                        <div class="component-example">
                            <h4>Button Examples</h4>
                            <button class="btn-primary">Primary Button</button>
                            <button class="btn-secondary">Secondary Button</button>
                            <button class="btn-danger">Danger Button</button>
                        </div>

                        <h3>Primary Button</h3>
                        <div class="code-block css">
                            <pre>.btn-primary {
  background-color: var(--accent-one);
  color: var(--text-primary);
  padding: 10px 20px;
  border: none;
  border-radius: 8px;
}</pre>
                        </div>

                        <h3>Secondary Button</h3>
                        <div class="code-block css">
                            <pre>.btn-secondary {
  background-color: #555;
  color: var(--text-primary);
  padding: 8px 12px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}</pre>
                        </div>

                        <h3>Danger Button</h3>
                        <div class="code-block css">
                            <pre>.btn-danger {
  background-color: #F44336;
  color: var(--text-primary);
}</pre>
                        </div>
                    </section>

                    <!-- Frontend Layout Components Section -->
                    <section id="fe-layout-components" class="doc-section">
                        <h2>Layout Components</h2>
                        
                        <h3>Hero Section</h3>
                        <div class="code-block css">
                            <pre>.hero {
  background-color: var(--bg-dark-secondary);
  padding: 60px 20px;
  text-align: center;
}</pre>
                        </div>

                        <h3>Product Grid</h3>
                        <div class="code-block css">
                            <pre>.product-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  padding: 30px;
  justify-content: center;
}</pre>
                        </div>
                    </section>

                    <!-- Frontend Header & Navigation Section -->
                    <section id="fe-header-nav" class="doc-section">
                        <h2>Header & Navigation</h2>
                        <div class="code-block css">
                            <pre>header {
  background-color: var(--bg-dark-secondary);
  padding: 15px 30px;
  display: flex;
  justify-content: right;
  align-items: center;
  position: sticky;
  top: 0;
  z-index: 1000;
  height: 50px;
}

nav ul {
  list-style: none;
  display: flex;
  gap: 20px;
}

nav ul li a {
  color: var(--text-primary);
  text-decoration: none;
  font-weight: 600;
  padding: 6px 10px;
  border-radius: 4px;
}</pre>
                        </div>
                    </section>

                    <!-- Frontend Footer Section -->
                    <section id="fe-footer" class="doc-section">
                        <h2>Footer</h2>
                        <div class="code-block css">
                            <pre>footer {
  background-color: var(--bg-dark-secondary);
  padding: 25px 30px;
  text-align: center;
  border-top: 1px solid var(--border-dark);
}</pre>
                        </div>
                    </section>

                    <!-- Frontend Product Components Section -->
                    <section id="fe-product-components" class="doc-section">
                        <h2>Product Components</h2>
                        
                        <h3>Product Card</h3>
                        <div class="code-block css">
                            <pre>.product-card {
  background-color: var(--bg-dark-secondary);
  border: 1px solid var(--border-dark);
  border-radius: 12px;
  padding: 15px;
  width: 220px;
  text-align: center;
}</pre>
                        </div>

                        <h3>Product Detail Page</h3>
                        <div class="code-block css">
                            <pre>.product-detail img {
  width: 300px;
  border-radius: 10px;
}

.detail-header {
  display: flex;
  gap: 40px;
  padding: 40px;
  align-items: flex-start;
}</pre>
                        </div>
                    </section>

                    <!-- Frontend Auth Components Section -->
                    <section id="fe-auth-components" class="doc-section">
                        <h2>Auth Components</h2>
                        <div class="code-block css">
                            <pre>.auth-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: var(--bg-dark);
}

.auth-box {
  background-color: var(--bg-dark-secondary);
  border: 1px solid var(--border-dark);
  border-radius: 12px;
  padding: 30px;
  width: 100%;
  max-width: 400px;
}</pre>
                        </div>
                    </section>

                    <!-- Frontend Admin Dashboard Section -->
                    <section id="fe-admin-dashboard" class="doc-section">
                        <h2>Admin Dashboard</h2>
                        <div class="code-block css">
                            <pre>.admin-container {
  display: flex;
  min-height: 100vh;
}

.admin-sidebar {
  width: 250px;
  background-color: var(--bg-dark-secondary);
  padding: 20px;
  border-right: 1px solid var(--border-dark);
}

.admin-content {
  flex: 1;
  padding: 20px;
}</pre>
                        </div>
                    </section>

                    <!-- Frontend Responsive Design Section -->
                    <section id="fe-responsive-design" class="doc-section">
                        <h2>Responsive Design</h2>
                        <p>The CSS includes comprehensive responsive design with multiple breakpoints:</p>

                        <h3>Tablet Breakpoint (768px)</h3>
                        <div class="code-block css">
                            <pre>@media (max-width: 768px) {
  header {
    flex-direction: column;
    height: auto;
  }
  
  .product-grid {
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  }
}</pre>
                        </div>

                        <h3>Mobile Breakpoint (480px)</h3>
                        <div class="code-block css">
                            <pre>@media (max-width: 480px) {
  .product-detail img {
    width: 100%;
  }
  
  .detail-header {
    flex-direction: column;
    padding: 20px;
  }
}</pre>
                        </div>

                        <h3>Breakpoint Summary</h3>
                        <ul>
                            <li><strong>1024px</strong> - Small desktops</li>
                            <li><strong>768px</strong> - Tablets</li>
                            <li><strong>599px</strong> - Large phones</li>
                            <li><strong>480px</strong> - Small phones</li>
                            <li><strong>360px</strong> - Very small screens</li>
                        </ul>

                        <h3>Additional Notes</h3>
                        <ul>
                            <li>Dark mode is the default theme with CSS variables for easy theming</li>
                            <li>The admin dashboard has specific styles for tables, forms, and navigation</li>
                            <li>Product pages have both grid and detail view styles</li>
                            <li>Accessibility considerations include reduced motion media query and high DPI display optimizations</li>
                            <li>Sufficient color contrast maintained throughout</li>
                        </ul>
                    </section>
                </main>
            </div>

            <!-- Backend Tab Content -->
            <div id="backend" class="tab-content">
                <!-- Backend Sidebar -->
                <aside class="doc-sidebar">
                    <h3>Back-end Docs</h3>
                    <nav class="doc-nav">
                        <ul>
                            <li class="active"><a href="#be-overview">Overview</a></li>
                            <li><a href="#be-database-config">Database Configuration</a></li>
                            <li><a href="#be-authentication">Authentication System</a></li>
                            <li><a href="#be-product-management">Product Management</a></li>
                            <li><a href="#be-admin-system">Admin System</a></li>
                            <li><a href="#be-database-schema">Database Schema</a></li>
                            <li><a href="#be-security-measures">Security Measures</a></li>
                            <li><a href="#be-file-structure">File Structure</a></li>
                        </ul>
                    </nav>
                </aside>

                <!-- Backend Main Content -->
                <main class="doc-content">
                    <!-- Backend Overview Section -->
                    <section id="be-overview" class="doc-section">
                        <h2>Back-end Overview</h2>
                        <p>This documentation covers the back-end architecture for Contenkrate, including:</p>
                        <ul>
                            <li>Database configuration and connections</li>
                            <li>Authentication and authorization system</li>
                            <li>Product management functionality</li>
                            <li>Admin system capabilities</li>
                            <li>Complete database schema</li>
                            <li>Security implementations</li>
                            <li>Project file structure</li>
                        </ul>
                    </section>

                    <!-- Database Configuration Section -->
                    <section id="be-database-config" class="doc-section">
                        <h2>Database Configuration</h2>
                        
                        <h3>config.php</h3>
                        <div class="code-block php">
                            <pre>&lt;?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'contenkrate');
define('DB_USER', 'root');
define('DB_PASS', ''); // Use your local MySQL password if any
?&gt;</pre>
                        </div>

                        <h3>database.php</h3>
                        <p>Establishes PDO connection to MySQL database with the following features:</p>
                        <ul>
                            <li>Sets error mode to exceptions for better error handling</li>
                            <li>Connection is stored in $pdo variable for reuse</li>
                            <li>Proper error handling with try-catch blocks</li>
                        </ul>

                        <div class="code-block php">
                            <pre>&lt;?php
require_once 'config.php';

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?&gt;</pre>
                        </div>
                    </section>

                    <!-- Authentication System Section -->
                    <section id="be-authentication" class="doc-section">
                        <h2>Authentication System</h2>
                        
                           <p><strong>Key Features:</strong></p>
                        <ul>
                            <li>Secure password hashing with password_hash()</li>
                            <li>CSRF protection on all forms</li>
                            <li>Session-based authentication</li>
                            <li>Role-based access control (admin/user)</li>
                        </ul>

                        <h3>login.php</h3>
                        <ul>
                            <li>Validates credentials against database</li>
                            <li>Implements CSRF protection</li>
                            <li>Sets session variables on successful login</li>
                            <li>Redirects admins to admin dashboard</li>
                        </ul>

                        <h3>register.php</h3>
                        <ul>
                            <li>Validates input (email format, password strength)</li>
                            <li>Checks for existing username/email</li>
                            <li>Hashes password before storage</li>
                            <li>Shows success/error messages</li>
                        </ul>

                        <h3>logout.php</h3>
                        <p>Destroys session and redirects to homepage</p>
                    </section>

                    <!-- Product Management Section -->
                    <section id="be-product-management" class="doc-section">
                        <h2>Product Management</h2>
                        
                        <h3>products.php</h3>
                        <ul>
                            <li>Displays paginated product listings</li>
                            <li>Implements filtering by category, price range, and search keywords</li>
                            <li>Secure SQL query building with prepared statements</li>
                        </ul>

                        <h3>product-detail.php</h3>
                        <ul>
                            <li>Shows detailed product information</li>
                            <li>Handles wishlist actions</li>
                            <li>Displays product options/variants</li>
                            <li>Secure ID validation</li>
                        </ul>

                        <h3>wishlist-action.php</h3>
                        <ul>
                            <li>Requires authentication</li>
                            <li>Handles adding/removing from wishlist</li>
                            <li>Validates all inputs</li>
                            <li>Returns to referring page</li>
                        </ul>
                    </section>

                    <!-- Admin System Section -->
                    <section id="be-admin-system" class="doc-section">
                        <h2>Admin System</h2>
                        
                        <h3>Access Control</h3>
                        <ul>
                            <li>Admin check via redirect_if_not_admin()</li>
                            <li>Separate admin interface</li>
                            <li>Restricted actions based on role</li>
                        </ul>

                        <h3>Admin Features</h3>
                        <h4>Product Management</h4>
                        <ul>
                            <li>CRUD operations for products</li>
                            <li>Category management</li>
                            <li>Featured product flagging</li>
                        </ul>

                        <h4>User Management</h4>
                        <ul>
                            <li>View all users</li>
                            <li>Delete users (with safeguards)</li>
                        </ul>

                        <h4>Dashboard</h4>
                        <ul>
                            <li>Site analytics</li>
                            <li>Quick access to key functions</li>
                        </ul>

                        <h3>Security</h3>
                        <ul>
                            <li>Separate admin authentication</li>
                            <li>Protection against self-deletion</li>
                            <li>All actions require admin privileges</li>
                        </ul>
                    </section>

                    <!-- Database Schema Section -->
                    <section id="be-database-schema" class="doc-section">
                        <h2>Database Schema</h2>
                        
                        <h3>Tables Structure</h3>
                        
                        <div class="schema-table">
                            <h4>users</h4>
                            <div class="code-block sql">
                                <pre>CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    user_type ENUM('admin','user') DEFAULT 'user',
    status ENUM('active','inactive') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_login DATETIME
);</pre>
                            </div>
                        </div>

                        <div class="schema-table">
                            <h4>products</h4>
                            <div class="code-block sql">
                                <pre>CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category ENUM('cameras','audio','lighting','software','accessories') NOT NULL,
    description TEXT,
    base_price DECIMAL(10,2) NOT NULL,
    amazon_ca_url VARCHAR(255),
    image_url VARCHAR(255),
    specifications JSON,
    is_featured BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);</pre>
                            </div>
                        </div>

                        <div class="schema-table">
                            <h4>product_options</h4>
                            <div class="code-block sql">
                                <pre>CREATE TABLE product_options (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    option_name VARCHAR(100) NOT NULL,
    option_description TEXT,
    price_modifier DECIMAL(10,2) DEFAULT 0.00,
    amazon_url VARCHAR(255),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);</pre>
                            </div>
                        </div>

                        <div class="schema-table">
                            <h4>wishlists</h4>
                            <div class="code-block sql">
                                <pre>CREATE TABLE wishlists (
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    added_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, product_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);</pre>
                            </div>
                        </div>
                    </section>

                    <!-- Security Measures Section -->
                    <section id="be-security-measures" class="doc-section">
                        <h2>Security Measures</h2>
                        
                        <h3>Input Validation</h3>
                        <ul>
                            <li>All user inputs are validated</li>
                            <li>Type checking for IDs and numbers</li>
                            <li>Email format validation</li>
                        </ul>

                        <h3>SQL Injection Protection</h3>
                        <ul>
                            <li>Prepared statements for all queries</li>
                            <li>Parameterized queries</li>
                            <li>No direct variable interpolation in SQL</li>
                        </ul>

                        <h3>CSRF Protection</h3>
                        <ul>
                            <li>Token generation and validation</li>
                            <li>Required for all form submissions</li>
                        </ul>

                        <h3>Authentication</h3>
                        <ul>
                            <li>Secure password hashing</li>
                            <li>Session management</li>
                            <li>Role-based access control</li>
                        </ul>

                        <h3>Error Handling</h3>
                        <ul>
                            <li>Custom error messages</li>
                            <li>No database details exposed to users</li>
                            <li>Logging of database errors</li>
                        </ul>
                    </section>

                    <!-- File Structure Section -->
                    <section id="be-file-structure" class="doc-section">
                        <h2>File Structure</h2>
                        
                        <div class="code-block text">
                            <pre>project-root/
│
├── admin/              # Admin backend
│   ├── dashboard.php   # Admin dashboard
│   ├── products.php    # Product management
│   ├── users.php       # User management
│   └── ...            # Other admin files
│
├── assets/             # Static assets
│   ├── css/            # Theme stylesheets
│   ├── fonts/          # Font files
│   └── images/         # Product images
│
├── includes/           # Shared components
│   ├── config.php      # Database config
│   ├── database.php    # DB connection
│   ├── functions.php   # Helper functions
│   └── navbar.php      # Navigation bar
│
├── index.php           # Homepage
├── login.php           # Login page
├── products.php        # Product listings
└── ...                 # Other frontend pages</pre>
                        </div>

                        
                        <h3>Key Directories</h3>
                        <ul>
                            <li><strong>admin/</strong> - Contains all administrative functionality</li>
                            <li><strong>assets/</strong> - Static files (CSS, images, fonts)</li>
                            <li><strong>includes/</strong> - Shared PHP components and configurations</li>
                        </ul>

                        <h3>Important Files</h3>
                        <ul>
                            <li><strong>config.php</strong> - Database connection settings</li>
                            <li><strong>database.php</strong> - PDO connection establishment</li>
                            <li><strong>functions.php</strong> - Helper functions for authentication and utilities</li>
                        </ul>

                        <h3>Development Notes</h3>
                        <ul>
                            <li>All PHP files include proper error handling</li>
                            <li>Database queries use prepared statements for security</li>
                            <li>Session management is implemented throughout</li>
                            <li>Admin functions are separated from user functions</li>
                            <li>File uploads (product images) are handled securely</li>
                            <li>Environment-specific configurations should be in config.php</li>
                        </ul>
                    </section>
                </main>
            </div>
        </div>