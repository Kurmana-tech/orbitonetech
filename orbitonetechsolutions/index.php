<?php
require_once __DIR__ . '/config/db.php';

// Safe Router
$allowedPages = [
    'home'                => 'home.php',
    'about'               => 'about.php',
    'services'            => 'services.php',
    'web-development'     => 'web-development.php',
    'app-development'     => 'app-development.php',
    'ai-solutions'        => 'ai-solutions.php',
    'data-analytics'      => 'data-analytics.php',
    'marketing-analytics' => 'marketing-analytics.php',
    'digital-marketing'   => 'digital-marketing.php',
    'industries'          => 'industries.php',
    'process'             => 'process.php',
    'projects'            => 'projects.php',
    'careers'             => 'careers.php',
    'blog'                => 'blog.php',
    'contact'             => 'contact.php',
    'quote'               => 'quote.php',
];

$currentPage = $_GET['page'] ?? 'home';
if (!array_key_exists($currentPage, $allowedPages)) {
    $currentPage = 'home';
}
$pageFile = __DIR__ . '/pages/' . $allowedPages[$currentPage];

// Page Meta Titles
$metaTitles = [
    'home'                => 'Orbitone Tech Solutions — Innovate • Integrate • Elevate',
    'about'               => 'About Us — Orbitone Tech Solutions',
    'services'            => 'Services — Technology & Digital Solutions',
    'web-development'     => 'Web Development — High Performance Web Applications',
    'app-development'     => 'Application Development — Mobile & Software Solutions',
    'ai-solutions'        => 'AI Solutions — Chatbots, ML & Automation Engine',
    'data-analytics'      => 'Data Analytics — Actionable Insights & Executive BI',
    'marketing-analytics' => 'Marketing Analytics — Campaign ROI & Funnel Intelligence',
    'digital-marketing'   => 'Digital Marketing — SEO, SEM & Growth Marketing',
    'industries'          => 'Industries — Sector Solutions Matrix',
    'process'             => 'Our Process — 7-Step Software Lifecycle',
    'projects'            => 'Projects & Portfolio — Digital Experiences Showcase',
    'careers'             => 'Careers — Join Orbitone Tech Solutions',
    'blog'                => 'Insights & Blog — AI, Tech & Marketing Articles',
    'contact'             => 'Contact Us — Orbitone Tech Solutions',
    'quote'               => 'Get a Quote — Scoping Wizard & Cost Estimator'
];

$pageTitle = $metaTitles[$currentPage] ?? 'Orbitone Tech Solutions';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="Orbitone Tech Solutions delivers innovative technology, AI, data analytics, software engineering, and digital marketing solutions. Innovate. Integrate. Elevate.">
  
  <!-- CSS & Icons -->
  <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>

  <!-- Sticky Navbar Header -->
  <header class="site-header">
    <div class="container">
      <div class="header-inner">
        
        <!-- Brand Horizontal Logo -->
        <a href="?page=home" style="display: flex; align-items: center;">
          <img src="assets/images/orbitone-horizontal.png" alt="Orbitone Tech Solutions Logo" class="header-logo-img">
        </a>

        <!-- Desktop Navigation -->
        <nav>
          <ul class="nav-menu">
            <li><a href="?page=home" class="nav-link <?= $currentPage === 'home' ? 'active' : '' ?>">Home</a></li>
            <li><a href="?page=about" class="nav-link <?= $currentPage === 'about' ? 'active' : '' ?>">About</a></li>
            
            <!-- Services Mega Menu -->
            <li class="nav-dropdown">
              <a href="?page=services" class="nav-link <?= in_array($currentPage, ['services','web-development','app-development','ai-solutions','data-analytics','marketing-analytics','digital-marketing']) ? 'active' : '' ?>">
                Services <i class="ri-arrow-down-s-line"></i>
              </a>
              <div class="dropdown-menu">
                <div>
                  <div class="dropdown-column-title">Technology</div>
                  <a href="?page=web-development" class="dropdown-item">
                    <div class="dropdown-item-title">Web Development</div>
                    <div class="dropdown-item-desc">High performance web apps</div>
                  </a>
                  <a href="?page=app-development" class="dropdown-item">
                    <div class="dropdown-item-title">Application Development</div>
                    <div class="dropdown-item-desc">Mobile & enterprise software</div>
                  </a>
                  <a href="?page=ai-solutions" class="dropdown-item">
                    <div class="dropdown-item-title">AI Solutions</div>
                    <div class="dropdown-item-desc">Chatbots, ML & automation</div>
                  </a>
                  <a href="?page=data-analytics" class="dropdown-item">
                    <div class="dropdown-item-title">Data Analytics</div>
                    <div class="dropdown-item-desc">BI dashboards & insights</div>
                  </a>
                </div>

                <div>
                  <div class="dropdown-column-title">Marketing</div>
                  <a href="?page=marketing-analytics" class="dropdown-item">
                    <div class="dropdown-item-title">Marketing Analytics</div>
                    <div class="dropdown-item-desc">ROI & funnel intelligence</div>
                  </a>
                  <a href="?page=digital-marketing" class="dropdown-item">
                    <div class="dropdown-item-title">Digital Marketing</div>
                    <div class="dropdown-item-desc">SEO, SEM & social growth</div>
                  </a>
                </div>
              </div>
            </li>

            <li><a href="?page=industries" class="nav-link <?= $currentPage === 'industries' ? 'active' : '' ?>">Industries</a></li>
            <li><a href="?page=process" class="nav-link <?= $currentPage === 'process' ? 'active' : '' ?>">Our Process</a></li>
            <li><a href="?page=projects" class="nav-link <?= $currentPage === 'projects' ? 'active' : '' ?>">Projects</a></li>
            <li><a href="?page=blog" class="nav-link <?= $currentPage === 'blog' ? 'active' : '' ?>">Insights</a></li>
            <li><a href="?page=careers" class="nav-link <?= $currentPage === 'careers' ? 'active' : '' ?>">Careers</a></li>
            <li><a href="?page=contact" class="nav-link <?= $currentPage === 'contact' ? 'active' : '' ?>">Contact</a></li>
          </ul>
        </nav>

        <!-- CTA Header Button & Dark Theme Redirect Toggle -->
        <div style="display: flex; align-items: center; gap: 0.75rem;">
          <a href="../orbitone/" class="theme-toggle-btn header-theme-toggle" title="Switch to Dark 3D Theme (orbitone)" style="text-decoration: none; display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 20px; border: 1px solid #cbd5e1; background: #ffffff; color: #0b192c; font-weight: 600; font-size: 0.85rem;">
            <i class="ri-moon-clear-line" style="color: #2d8cff;"></i>
            <span>Dark</span>
          </a>
          <a href="?page=quote" class="btn btn-primary btn-sm header-quote-btn">Get a Quote</a>
          <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle navigation">
            <i class="ri-menu-line"></i>
          </button>
        </div>

      </div>
    </div>
  </header>

  <!-- Mobile Drawer -->
  <div class="mobile-nav-drawer" id="mobileNav">
    <a href="?page=home">Home</a>
    <a href="?page=about">About Us</a>
    <a href="?page=services">Services Overview</a>
    <a href="?page=web-development">• Web Development</a>
    <a href="?page=app-development">• Application Development</a>
    <a href="?page=ai-solutions">• AI Solutions</a>
    <a href="?page=data-analytics">• Data Analytics</a>
    <a href="?page=marketing-analytics">• Marketing Analytics</a>
    <a href="?page=digital-marketing">• Digital Marketing</a>
    <a href="?page=industries">Industries</a>
    <a href="?page=process">Our Process</a>
    <a href="?page=projects">Projects & Portfolio</a>
    <a href="?page=blog">Insights / Blog</a>
    <a href="?page=careers">Careers</a>
    <a href="?page=contact">Contact Us</a>
    <div style="margin-top: 1rem; padding: 0.5rem 0;">
      <a href="../orbitone/" class="theme-toggle-btn" style="text-align: center; text-decoration: none; display: flex; justify-content: center; align-items: center; gap: 8px; width: 100%; padding: 10px; border-radius: 20px; border: 1px solid #cbd5e1; background: #ffffff; color: #0b192c; font-weight: 600;">
        <i class="ri-moon-clear-line" style="color: #2d8cff;"></i>
        <span>Switch to Dark 3D Theme (orbitone)</span>
      </a>
    </div>
    <a href="?page=quote" class="btn btn-primary" style="margin-top: 0.5rem; text-align: center;">Get a Quote</a>
  </div>

  <!-- Dynamic Page Content -->
  <main style="flex-grow: 1;">
    <?php
    if (file_exists($pageFile)) {
        include $pageFile;
    } else {
        echo "<div class='container' style='padding-top: 160px; text-align: center;'><h2>Page Not Found</h2></div>";
    }
    ?>
  </main>

  <!-- Global Footer -->
  <footer class="site-footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-about">
          <a href="?page=home" style="display: block; margin-bottom: 1rem;">
            <img src="assets/images/orbitone-horizontal.png" alt="Orbitone Tech Solutions Logo" style="height: 52px; width: auto;">
          </a>
          <p style="margin-top: 1rem;">
            Orbitone Tech Solutions combines technology, artificial intelligence, data and digital marketing to help businesses build better digital products, make smarter decisions and achieve measurable growth.
          </p>
          <div style="margin-top: 1.25rem;">
            <span class="brand-tagline" style="color: #ffffff; opacity: 0.95; font-weight: 700;">INNOVATE • INTEGRATE • ELEVATE</span>
          </div>
        </div>

        <div>
          <h4 class="footer-title">Technology</h4>
          <ul class="footer-links">
            <li><a href="?page=web-development">Web Development</a></li>
            <li><a href="?page=app-development">Application Development</a></li>
            <li><a href="?page=ai-solutions">AI Solutions</a></li>
            <li><a href="?page=data-analytics">Data Analytics</a></li>
          </ul>
        </div>

        <div>
          <h4 class="footer-title">Marketing & Growth</h4>
          <ul class="footer-links">
            <li><a href="?page=marketing-analytics">Marketing Analytics</a></li>
            <li><a href="?page=digital-marketing">Digital Marketing</a></li>
            <li><a href="?page=industries">Industry Solutions</a></li>
            <li><a href="?page=process">Our Process</a></li>
          </ul>
        </div>

        <div>
          <h4 class="footer-title">Company</h4>
          <ul class="footer-links">
            <li><a href="?page=about">About Us</a></li>
            <li><a href="?page=projects">Projects Showcase</a></li>
            <li><a href="?page=blog">Blog & Insights</a></li>
            <li><a href="?page=careers">Careers</a></li>
            <li><a href="?page=contact">Contact Us</a></li>
            <li><a href="admin/">Admin Panel</a></li>
          </ul>
        </div>
      </div>

      <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Orbitone Tech Solutions. All rights reserved. INNOVATE • INTEGRATE • ELEVATE.</p>
      </div>
    </div>
  </footer>

  <!-- Client Script -->
  <script src="assets/js/main.js?v=<?= time() ?>"></script>
</body>
</html>
