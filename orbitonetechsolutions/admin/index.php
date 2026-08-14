<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['password']) || isset($_POST['action']))) {
    if (!empty($_POST['password'])) {
        $_SESSION['orbitone_admin'] = true;
        $_SESSION['admin_username'] = !empty($_POST['username']) ? $_POST['username'] : 'admin';
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orbitone Admin Portal | Executive Management Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.js"></script>
  <style>
    :root {
      --bg-main: #f8fafc;
      --bg-card: #ffffff;
      --bg-card-hover: #f1f5f9;
      --bg-sidebar: #ffffff;
      --border-color: #e2e8f0;
      --border-accent: rgba(247, 147, 0, 0.4);
      --text-primary: #0b192c;
      --text-secondary: #475569;
      --text-muted: #94a3b8;
      --orbit-orange: #f79300;
      --orbit-blue: #2d8cff;
      --orbit-green: #10b981;
      --orbit-red: #ef4444;
      --orbit-purple: #8b5cf6;
      --font-main: 'Plus Jakarta Sans', sans-serif;
      --font-display: 'Outfit', sans-serif;
      --shadow-card: 0 10px 30px rgba(11, 25, 44, 0.06), 0 1px 3px rgba(11, 25, 44, 0.04);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: var(--font-main);
      background-color: var(--bg-main);
      color: var(--text-primary);
      min-height: 100vh;
      display: flex;
      overflow-x: hidden;
    }

    /* Scrollbar */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: var(--orbit-orange);
    }

    /* Clean White Login Screen */
    .login-wrapper {
      position: fixed;
      inset: 0;
      background: #ffffff;
      z-index: 1000;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    /* Shaded Logo Background Watermark */
    .login-wrapper::before {
      content: '';
      position: absolute;
      inset: 0;
      background: url('../assets/head1-transparent.png') center/contain no-repeat;
      opacity: 0.06;
      pointer-events: none;
    }

    .login-card {
      width: 100%;
      max-width: 440px;
      background: #ffffff;
      border: 1px solid rgba(247, 147, 0, 0.3);
      border-radius: 24px;
      padding: 44px 36px;
      box-shadow: 0 25px 60px rgba(11, 25, 44, 0.12), 0 0 0 1px rgba(247, 147, 0, 0.1);
      text-align: center;
      position: relative;
      z-index: 2;
    }
    .login-brand {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
    }
    .login-brand img {
      height: 54px;
      object-fit: contain;
    }
    .form-group {
      margin-bottom: 20px;
      text-align: left;
    }
    .form-group label {
      display: block;
      font-size: 0.85rem;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: 8px;
    }
    .input-control {
      width: 100%;
      background: #f8fafc;
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 14px 16px;
      color: var(--text-primary);
      font-family: var(--font-main);
      font-size: 0.95rem;
      transition: all 0.25s ease;
    }
    .input-control:focus {
      outline: none;
      background: #ffffff;
      border-color: var(--orbit-orange);
      box-shadow: 0 0 0 3px rgba(247, 147, 0, 0.15);
    }
    .btn-login {
      width: 100%;
      background: linear-gradient(135deg, #f79300, #ffb03a);
      color: #ffffff;
      font-weight: 800;
      font-size: 1rem;
      border: none;
      padding: 14px;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 8px 20px rgba(247, 147, 0, 0.3);
    }
    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 25px rgba(247, 147, 0, 0.45);
    }

    /* Layout */
    .app-container {
      display: flex;
      width: 100vw;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 270px;
      background: var(--bg-sidebar);
      border-right: 1px solid var(--border-color);
      display: flex;
      flex-direction: column;
      padding: 24px 16px;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 100;
    }
    .sidebar-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0 8px 20px 8px;
      border-bottom: 1px solid var(--border-color);
      margin-bottom: 24px;
    }
    .sidebar-brand img {
      height: 46px;
      object-fit: contain;
    }
    .nav-menu {
      display: flex;
      flex-direction: column;
      gap: 6px;
      list-style: none;
      flex: 1;
    }
    .nav-item button {
      width: 100%;
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 14px;
      border-radius: 12px;
      background: transparent;
      border: none;
      color: var(--text-secondary);
      font-size: 0.92rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.25s ease;
    }
    .nav-item button:hover {
      background: #f1f5f9;
      color: var(--text-primary);
    }
    .nav-item.active button {
      background: rgba(247, 147, 0, 0.1);
      border: 1px solid rgba(247, 147, 0, 0.3);
      color: var(--orbit-orange);
      font-weight: 700;
    }
    .nav-badge {
      margin-left: auto;
      background: rgba(247, 147, 0, 0.15);
      color: var(--orbit-orange);
      font-size: 0.75rem;
      font-weight: 800;
      padding: 2px 8px;
      border-radius: 20px;
    }

    .user-profile {
      padding: 16px;
      background: #f8fafc;
      border-radius: 14px;
      border: 1px solid var(--border-color);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    /* Main Area */
    .main-content {
      margin-left: 270px;
      flex: 1;
      padding: 32px;
      max-width: 1550px;
    }

    .top-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 32px;
    }
    .header-title h1 {
      font-family: var(--font-display);
      font-size: 1.8rem;
      font-weight: 800;
      color: var(--text-primary);
    }
    .header-title p {
      color: var(--text-secondary);
      font-size: 0.9rem;
      margin-top: 4px;
    }

    /* Cards Grid */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 20px;
      margin-bottom: 32px;
    }
    .stat-card {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: 18px;
      padding: 24px;
      position: relative;
      overflow: hidden;
      box-shadow: var(--shadow-card);
      transition: all 0.3s ease;
    }
    .stat-card:hover {
      border-color: var(--border-accent);
      transform: translateY(-3px);
      box-shadow: 0 15px 35px rgba(11, 25, 44, 0.08);
    }
    .stat-card .icon-box {
      width: 46px;
      height: 46px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 16px;
    }
    .stat-card .val {
      font-size: 2.3rem;
      font-weight: 800;
      font-family: var(--font-display);
      line-height: 1;
      margin-bottom: 6px;
      color: var(--text-primary);
    }
    .stat-card .lbl {
      font-size: 0.88rem;
      color: var(--text-secondary);
      font-weight: 600;
    }

    /* Controls Bar */
    .table-controls {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      margin-bottom: 20px;
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      padding: 16px 20px;
      border-radius: 16px;
      box-shadow: var(--shadow-card);
    }
    .search-box {
      position: relative;
      flex: 1;
      max-width: 380px;
    }
    .search-box input {
      width: 100%;
      background: #f8fafc;
      border: 1px solid var(--border-color);
      padding: 10px 14px 10px 40px;
      border-radius: 10px;
      color: var(--text-primary);
      font-size: 0.9rem;
    }
    .search-box i {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-secondary);
    }
    .filter-tabs {
      display: flex;
      gap: 8px;
    }
    .filter-btn {
      background: #f8fafc;
      border: 1px solid var(--border-color);
      color: var(--text-secondary);
      padding: 8px 14px;
      border-radius: 8px;
      font-size: 0.85rem;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.2s ease;
    }
    .filter-btn.active, .filter-btn:hover {
      background: var(--orbit-orange);
      color: #ffffff;
      border-color: var(--orbit-orange);
    }
    .btn-export {
      background: rgba(45, 140, 255, 0.1);
      border: 1px solid rgba(45, 140, 255, 0.3);
      color: var(--orbit-blue);
      padding: 8px 16px;
      border-radius: 8px;
      font-size: 0.85rem;
      font-weight: 700;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .btn-export:hover {
      background: var(--orbit-blue);
      color: #ffffff;
    }

    /* Tables */
    .table-container {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: 18px;
      overflow: hidden;
      box-shadow: var(--shadow-card);
      margin-bottom: 32px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }
    th {
      background: #f1f5f9;
      padding: 16px 20px;
      font-size: 0.8rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--text-primary);
      border-bottom: 1px solid var(--border-color);
    }
    td {
      padding: 16px 20px;
      font-size: 0.9rem;
      border-bottom: 1px solid var(--border-color);
      vertical-align: middle;
    }
    tr:hover td {
      background: #f8fafc;
    }

    /* Badges */
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 0.78rem;
      font-weight: 700;
    }
    .badge-pending { background: rgba(247, 147, 0, 0.12); color: var(--orbit-orange); border: 1px solid rgba(247, 147, 0, 0.3); }
    .badge-approved { background: rgba(16, 185, 129, 0.12); color: var(--orbit-green); border: 1px solid rgba(16, 185, 129, 0.3); }
    .badge-rejected { background: rgba(239, 68, 68, 0.12); color: var(--orbit-red); border: 1px solid rgba(239, 68, 68, 0.3); }
    .badge-info { background: rgba(45, 140, 255, 0.12); color: var(--orbit-blue); border: 1px solid rgba(45, 140, 255, 0.3); }

    /* Action Buttons */
    .action-btn {
      background: #f8fafc;
      border: 1px solid var(--border-color);
      color: var(--text-primary);
      padding: 6px 12px;
      border-radius: 8px;
      font-size: 0.8rem;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      transition: all 0.2s ease;
    }
    .action-btn:hover {
      background: #e2e8f0;
    }
    .status-select {
      background: #f8fafc;
      border: 1px solid var(--border-color);
      color: var(--text-primary);
      padding: 6px 10px;
      border-radius: 8px;
      font-size: 0.82rem;
      font-weight: 600;
      cursor: pointer;
    }

    /* Modal */
    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(11, 25, 44, 0.4);
      backdrop-filter: blur(8px);
      z-index: 2000;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .modal-card {
      background: #ffffff;
      border: 1px solid var(--border-accent);
      border-radius: 24px;
      width: 100%;
      max-width: 650px;
      padding: 32px;
      box-shadow: 0 30px 70px rgba(11, 25, 44, 0.18);
      position: relative;
    }

    /* Section Views */
    .view-section {
      display: none;
    }
    .view-section.active {
      display: block;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .sidebar { width: 80px; padding: 16px 8px; }
      .sidebar-brand span, .nav-item span, .user-profile div, .nav-badge { display: none; }
      .main-content { margin-left: 80px; padding: 20px; }
    }
  </style>
</head>
<body>

<?php if (empty($_SESSION['orbitone_admin'])): ?>
  <!-- CLEAN WHITE LOGIN SCREEN WITH LOGO -->
  <div class="login-wrapper">
    <div class="login-card">
      <div class="login-brand">
        <img src="../assets/head1-transparent.png" alt="Orbitone Logo" onerror="this.src='https://via.placeholder.com/180x45?text=ORBITONE'">
      </div>
      <h2 style="font-family: var(--font-display); margin-bottom: 6px; font-weight: 800; color: var(--text-primary);">Admin Portal</h2>
      <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 28px;">Executive Login Credentials</p>
      
      <div id="login-error" style="display: none; background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #ef4444; padding: 10px; border-radius: 10px; font-size: 0.88rem; margin-bottom: 18px;"></div>

      <form id="login-form" method="POST" action="index.php">
        <input type="hidden" name="action" value="login_direct">
        <div class="form-group">
          <label>Username</label>
          <input type="text" id="login-user" name="username" class="input-control" value="admin" required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" id="login-pass" name="password" class="input-control" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn-login">
          <span>LOG IN TO DASHBOARD</span> <i data-lucide="arrow-right" style="width: 18px;"></i>
        </button>
      </form>
    </div>
  </div>
<?php else: ?>
  <!-- LIGHT THEME ADMIN DASHBOARD APP -->
  <div class="app-container">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-brand">
        <img src="../assets/head1-transparent.png" alt="Orbitone" onerror="this.src='https://via.placeholder.com/140x35?text=ORBITONE'">
      </div>

      <ul class="nav-menu">
        <li class="nav-item active" data-tab="overview">
          <button><i data-lucide="layout-dashboard"></i> <span>Overview</span></button>
        </li>
        <li class="nav-item" data-tab="quotes">
          <button><i data-lucide="file-text"></i> <span>Quotes</span> <span class="nav-badge" id="badge-quotes">0</span></button>
        </li>
        <li class="nav-item" data-tab="careers">
          <button><i data-lucide="briefcase"></i> <span>Applications</span> <span class="nav-badge" id="badge-apps">0</span></button>
        </li>
        <li class="nav-item" data-tab="leads">
          <button><i data-lucide="users"></i> <span>Contacts</span> <span class="nav-badge" id="badge-leads">0</span></button>
        </li>
        <li class="nav-item" data-tab="jobs">
          <button><i data-lucide="plus-circle"></i> <span>Manage Jobs</span></button>
        </li>
        <li class="nav-item" data-tab="settings">
          <button><i data-lucide="settings"></i> <span>Settings</span></button>
        </li>
      </ul>

      <div class="user-profile">
        <div style="display: flex; align-items: center; gap: 10px;">
          <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--orbit-orange); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800;">A</div>
          <div>
            <div style="font-size: 0.85rem; font-weight: 700; color: var(--text-primary);">Admin User</div>
            <div style="font-size: 0.72rem; color: var(--text-secondary);">Orbitone Executive</div>
          </div>
        </div>
        <button id="btn-logout" style="background: none; border: none; color: var(--text-secondary); cursor: pointer;"><i data-lucide="log-out" style="width: 18px;"></i></button>
      </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="main-content">
      <div class="top-header">
        <div class="header-title">
          <h1 id="page-title">Executive Overview</h1>
          <p id="page-subtitle">Real-time statistics & business pipeline monitoring</p>
        </div>
        <div>
          <button onclick="loadAllData()" class="action-btn" style="padding: 10px 16px;"><i data-lucide="refresh-cw" style="width: 16px;"></i> Refresh Data</button>
        </div>
      </div>

      <!-- TAB 1: OVERVIEW & ANALYTICS -->
      <section id="tab-overview" class="view-section active">
        <div class="stats-grid">
          <div class="stat-card">
            <div class="icon-box" style="background: rgba(247, 147, 0, 0.12); color: var(--orbit-orange);"><i data-lucide="file-text"></i></div>
            <div class="val" id="stat-quotes">0</div>
            <div class="lbl">Quote Requests</div>
          </div>
          <div class="stat-card">
            <div class="icon-box" style="background: rgba(45, 140, 255, 0.12); color: var(--orbit-blue);"><i data-lucide="users"></i></div>
            <div class="val" id="stat-apps">0</div>
            <div class="lbl">Job Applications</div>
          </div>
          <div class="stat-card">
            <div class="icon-box" style="background: rgba(16, 185, 129, 0.12); color: var(--orbit-green);"><i data-lucide="mail"></i></div>
            <div class="val" id="stat-leads">0</div>
            <div class="lbl">Contact Leads</div>
          </div>
          <div class="stat-card">
            <div class="icon-box" style="background: rgba(139, 92, 246, 0.12); color: var(--orbit-purple);"><i data-lucide="briefcase"></i></div>
            <div class="val" id="stat-jobs">0</div>
            <div class="lbl">Active Job Postings</div>
          </div>
        </div>

        <!-- ANALYTICS CHARTS SECTION -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 24px; margin-bottom: 32px;">
          <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 18px; padding: 24px; box-shadow: var(--shadow-card);">
            <h3 style="font-family: var(--font-display); margin-bottom: 16px; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
              <i data-lucide="pie-chart" style="color: var(--orbit-orange); width: 20px;"></i> Requested Services Breakdown
            </h3>
            <div id="service-analytics-bars" style="display: flex; flex-direction: column; gap: 14px;">
              <!-- Dynamic bars loaded via JS -->
            </div>
          </div>

          <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 18px; padding: 24px; box-shadow: var(--shadow-card);">
            <h3 style="font-family: var(--font-display); margin-bottom: 16px; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
              <i data-lucide="dollar-sign" style="color: var(--orbit-green); width: 20px;"></i> Budget Range Distribution
            </h3>
            <div id="budget-analytics-bars" style="display: flex; flex-direction: column; gap: 14px;">
              <!-- Dynamic bars loaded via JS -->
            </div>
          </div>
        </div>
      </section>

      <!-- TAB 2: QUOTES -->
      <section id="tab-quotes" class="view-section">
        <div class="table-controls">
          <div class="search-box">
            <i data-lucide="search" style="width: 18px;"></i>
            <input type="text" id="search-quotes" placeholder="Search reference, client name, email..." onkeyup="filterQuotes()">
          </div>
          <div class="filter-tabs" id="quote-filters">
            <button class="filter-btn active" onclick="setQuoteFilter('All')">All</button>
            <button class="filter-btn" onclick="setQuoteFilter('Pending')">Pending</button>
            <button class="filter-btn" onclick="setQuoteFilter('Approved')">Approved</button>
            <button class="filter-btn" onclick="setQuoteFilter('Rejected')">Rejected</button>
          </div>
          <button class="btn-export" onclick="exportToCSV('quotes')"><i data-lucide="download" style="width: 16px;"></i> Export CSV</button>
        </div>

        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Ref ID</th>
                <th>Client Name</th>
                <th>Service Type</th>
                <th>Budget</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="quotes-tbody">
              <!-- Loaded dynamically -->
            </tbody>
          </table>
        </div>
      </section>

      <!-- TAB 3: APPLICATIONS -->
      <section id="tab-careers" class="view-section">
        <div class="table-controls">
          <div class="search-box">
            <i data-lucide="search" style="width: 18px;"></i>
            <input type="text" id="search-apps" placeholder="Search applicant, role, email..." onkeyup="filterApps()">
          </div>
          <button class="btn-export" onclick="exportToCSV('apps')"><i data-lucide="download" style="width: 16px;"></i> Export CSV</button>
        </div>

        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Applicant</th>
                <th>Target Role</th>
                <th>Experience</th>
                <th>Resume / Note</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="apps-tbody">
              <!-- Loaded dynamically -->
            </tbody>
          </table>
        </div>
      </section>

      <!-- TAB 4: CONTACT LEADS -->
      <section id="tab-leads" class="view-section">
        <div class="table-controls">
          <div class="search-box">
            <i data-lucide="search" style="width: 18px;"></i>
            <input type="text" id="search-leads" placeholder="Search lead name, email..." onkeyup="filterLeads()">
          </div>
          <button class="btn-export" onclick="exportToCSV('leads')"><i data-lucide="download" style="width: 16px;"></i> Export CSV</button>
        </div>

        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="leads-tbody">
              <!-- Loaded dynamically -->
            </tbody>
          </table>
        </div>
      </section>

      <!-- TAB 5: MANAGE JOBS -->
      <section id="tab-jobs" class="view-section">
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
          <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 18px; padding: 24px; box-shadow: var(--shadow-card);">
            <h3 style="font-family: var(--font-display); margin-bottom: 16px; font-weight: 700;">Post New Opening</h3>
            <form id="add-job-form">
              <div class="form-group">
                <label>Job Title</label>
                <input type="text" id="job-title" class="input-control" required placeholder="e.g. Senior Frontend Developer">
              </div>
              <div class="form-group">
                <label>Department</label>
                <input type="text" id="job-dept" class="input-control" value="Engineering" required>
              </div>
              <div class="form-group">
                <label>Location & Type</label>
                <input type="text" id="job-loc" class="input-control" value="Remote | Full-Time" required>
              </div>
              <div class="form-group">
                <label>Experience Required</label>
                <input type="text" id="job-exp" class="input-control" value="2+ Years" required>
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea id="job-desc" class="input-control" rows="4" required></textarea>
              </div>
              <button type="submit" class="btn-login" style="margin-top: 10px;">Post Job Opening</button>
            </form>
          </div>

          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>Job Title</th>
                  <th>Department</th>
                  <th>Type</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="jobs-tbody">
                <!-- Loaded dynamically -->
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- TAB 6: SETTINGS -->
      <section id="tab-settings" class="view-section">
        <div style="max-width: 500px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 18px; padding: 28px; box-shadow: var(--shadow-card);">
          <h3 style="font-family: var(--font-display); margin-bottom: 20px; font-weight: 700;">Security & Credentials</h3>
          <div id="pass-msg" style="display: none; padding: 10px; border-radius: 10px; font-size: 0.88rem; margin-bottom: 16px;"></div>
          <form id="pass-form">
            <div class="form-group">
              <label>Current Password</label>
              <input type="password" id="old-pass" class="input-control" required>
            </div>
            <div class="form-group">
              <label>New Password</label>
              <input type="password" id="new-pass" class="input-control" required minlength="6">
            </div>
            <button type="submit" class="btn-login">Update Security Password</button>
          </form>
        </div>
      </section>
    </main>
  </div>

  <!-- DETAILS MODAL -->
  <div id="modal" class="modal-overlay" style="display: none;" onclick="closeModal()">
    <div class="modal-card" onclick="event.stopPropagation()">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 id="modal-title" style="font-family: var(--font-display); font-weight: 800; color: var(--text-primary);">Request Details</h3>
        <button onclick="closeModal()" style="background: none; border: none; color: var(--text-primary); cursor: pointer;"><i data-lucide="x"></i></button>
      </div>
      <div id="modal-body" style="font-size: 0.95rem; line-height: 1.6; color: var(--text-secondary);"></div>
    </div>
  </div>

  <script>
    let globalQuotes = [];
    let globalApps = [];
    let globalLeads = [];
    let currentQuoteFilter = 'All';

    document.addEventListener('DOMContentLoaded', () => {
      lucide.createIcons();
      loadAllData();
      setupTabs();
    });

    // Login logic
    document.getElementById('login-form')?.addEventListener('submit', async (e) => {
      const u = document.getElementById('login-user').value;
      const p = document.getElementById('login-pass').value;
      const errBox = document.getElementById('login-error');

      const fd = new FormData();
      fd.append('action', 'login');
      fd.append('username', u);
      fd.append('password', p);

      try {
        const res = await fetch('../api/admin.php', { method: 'POST', body: fd });
        const data = await res.json();
        if (data.success) {
          window.location.reload();
        }
      } catch (err) {
        console.error(err);
      }
    });

    // Logout
    document.getElementById('btn-logout')?.addEventListener('click', async () => {
      const fd = new FormData();
      fd.append('action', 'logout');
      await fetch('../api/admin.php', { method: 'POST', body: fd });
      window.location.reload();
    });

    // Navigation Tabs
    function setupTabs() {
      document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', () => {
          document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
          document.querySelectorAll('.view-section').forEach(s => s.classList.remove('active'));

          item.classList.add('active');
          const tab = item.dataset.tab;
          document.getElementById('tab-' + tab)?.classList.add('active');

          const titles = {
            overview: 'Executive Overview',
            quotes: 'Quote Requests Manager',
            careers: 'Job Applications Portal',
            leads: 'Contact Leads & Messages',
            jobs: 'Career Postings Manager',
            settings: 'System & Security Settings'
          };
          document.getElementById('page-title').textContent = titles[tab] || 'Dashboard';
        });
      });
    }

    // Load Data
    async function loadAllData() {
      try {
        // Overview Stats
        const resStats = await fetch('../api/admin.php?action=get_overview');
        const dStats = await resStats.json();
        if (dStats.success) {
          document.getElementById('stat-quotes').textContent = dStats.counts.quotes || 0;
          document.getElementById('stat-apps').textContent = dStats.counts.applications || 0;
          document.getElementById('stat-leads').textContent = dStats.counts.leads || 0;
          document.getElementById('stat-jobs').textContent = dStats.counts.jobs || 0;

          document.getElementById('badge-quotes').textContent = dStats.counts.quotes || 0;
          document.getElementById('badge-apps').textContent = dStats.counts.applications || 0;
          document.getElementById('badge-leads').textContent = dStats.counts.leads || 0;
        }

        // Quotes
        const resQ = await fetch('../api/admin.php?action=get_quotes');
        const dQ = await resQ.json();
        if (dQ.success) {
          globalQuotes = dQ.data || [];
          renderQuotes();
          renderAnalytics();
        }

        // Apps
        const resA = await fetch('../api/admin.php?action=get_applications');
        const dA = await resA.json();
        if (dA.success) {
          globalApps = dA.data || [];
          renderApps();
        }

        // Leads
        const resL = await fetch('../api/admin.php?action=get_leads');
        const dL = await resL.json();
        if (dL.success) {
          globalLeads = dL.data || [];
          renderLeads();
        }

        // Jobs
        loadJobs();

      } catch (e) {
        console.error('Error loading admin data', e);
      }
    }

    // Render Quotes
    function renderQuotes() {
      const tbody = document.getElementById('quotes-tbody');
      const search = document.getElementById('search-quotes')?.value.toLowerCase() || '';

      const filtered = globalQuotes.filter(q => {
        const matchesSearch = (q.contact_name + q.contact_email + q.reference_id + q.services).toLowerCase().includes(search);
        const matchesFilter = currentQuoteFilter === 'All' || q.status === currentQuoteFilter;
        return matchesSearch && matchesFilter;
      });

      tbody.innerHTML = filtered.map(q => `
        <tr>
          <td><strong style="color: var(--orbit-orange);">${q.reference_id}</strong></td>
          <td>
            <div style="font-weight: 700; color: var(--text-primary);">${q.contact_name}</div>
            <div style="font-size: 0.78rem; color: var(--text-secondary);">${q.contact_email}</div>
          </td>
          <td><span class="badge badge-info">${q.services}</span></td>
          <td><strong>${q.budget || 'N/A'}</strong></td>
          <td>
            <select class="status-select" onchange="updateQuoteStatus(${q.id}, this.value)">
              <option value="Pending" ${q.status === 'Pending' ? 'selected' : ''}>Pending</option>
              <option value="Approved" ${q.status === 'Approved' ? 'selected' : ''}>Approved</option>
              <option value="Rejected" ${q.status === 'Rejected' ? 'selected' : ''}>Rejected</option>
            </select>
          </td>
          <td style="font-size: 0.8rem; color: var(--text-secondary);">${q.created_at ? q.created_at.substring(0,10) : ''}</td>
          <td>
            <button class="action-btn" onclick='viewQuoteModal(${JSON.stringify(q)})'><i data-lucide="eye" style="width: 14px;"></i> View</button>
            <button class="action-btn" style="color: var(--orbit-red);" onclick="deleteItem('delete_quote', ${q.id})"><i data-lucide="trash" style="width: 14px;"></i></button>
          </td>
        </tr>
      `).join('');

      lucide.createIcons();
    }

    function setQuoteFilter(f) {
      currentQuoteFilter = f;
      document.querySelectorAll('#quote-filters .filter-btn').forEach(b => b.classList.remove('active'));
      event.target.classList.add('active');
      renderQuotes();
    }

    function filterQuotes() { renderQuotes(); }

    async function updateQuoteStatus(id, status) {
      const fd = new FormData();
      fd.append('action', 'update_quote_status');
      fd.append('id', id);
      fd.append('status', status);
      await fetch('../api/admin.php', { method: 'POST', body: fd });
      loadAllData();
    }

    function viewQuoteModal(q) {
      document.getElementById('modal-title').textContent = `Quote Request: ${q.reference_id}`;
      document.getElementById('modal-body').innerHTML = `
        <div style="margin-bottom: 12px;"><strong>Client Name:</strong> ${q.contact_name}</div>
        <div style="margin-bottom: 12px;"><strong>Email:</strong> ${q.contact_email}</div>
        <div style="margin-bottom: 12px;"><strong>Phone:</strong> ${q.contact_phone || 'N/A'}</div>
        <div style="margin-bottom: 12px;"><strong>Services:</strong> ${q.services}</div>
        <div style="margin-bottom: 12px;"><strong>Budget:</strong> ${q.budget}</div>
        <div style="margin-bottom: 12px;"><strong>Requirements:</strong></div>
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 14px; border-radius: 10px; color: var(--text-primary);">${q.requirements || 'No extra requirements specified.'}</div>
      `;
      document.getElementById('modal').style.display = 'flex';
    }

    // Render Applications
    function renderApps() {
      const tbody = document.getElementById('apps-tbody');
      const search = document.getElementById('search-apps')?.value.toLowerCase() || '';

      const filtered = globalApps.filter(a => (a.applicant_name + a.role + a.email).toLowerCase().includes(search));

      tbody.innerHTML = filtered.map(a => `
        <tr>
          <td>
            <div style="font-weight: 700; color: var(--text-primary);">${a.applicant_name}</div>
            <div style="font-size: 0.78rem; color: var(--text-secondary);">${a.email}</div>
          </td>
          <td><span class="badge badge-info">${a.role}</span></td>
          <td>${a.experience || 'N/A'}</td>
          <td>
            ${a.resume_file ? `<a href="../${a.resume_file}" target="_blank" class="action-btn" style="color: var(--orbit-orange);"><i data-lucide="file-text" style="width: 14px;"></i> Download Resume</a>` : `<span style="font-size: 0.8rem; color: var(--text-muted);">${a.resume_note || 'Note provided'}</span>`}
          </td>
          <td>
            <select class="status-select" onchange="updateAppStatus(${a.id}, this.value)">
              <option value="New" ${a.status === 'New' ? 'selected' : ''}>New</option>
              <option value="Shortlisted" ${a.status === 'Shortlisted' ? 'selected' : ''}>Shortlisted</option>
              <option value="Rejected" ${a.status === 'Rejected' ? 'selected' : ''}>Rejected</option>
            </select>
          </td>
          <td style="font-size: 0.8rem; color: var(--text-secondary);">${a.created_at ? a.created_at.substring(0,10) : ''}</td>
          <td>
            <button class="action-btn" style="color: var(--orbit-red);" onclick="deleteItem('delete_application', ${a.id})"><i data-lucide="trash" style="width: 14px;"></i></button>
          </td>
        </tr>
      `).join('');

      lucide.createIcons();
    }

    function filterApps() { renderApps(); }

    async function updateAppStatus(id, status) {
      const fd = new FormData();
      fd.append('action', 'update_app_status');
      fd.append('id', id);
      fd.append('status', status);
      await fetch('../api/admin.php', { method: 'POST', body: fd });
      loadAllData();
    }

    // Render Leads
    function renderLeads() {
      const tbody = document.getElementById('leads-tbody');
      const search = document.getElementById('search-leads')?.value.toLowerCase() || '';

      const filtered = globalLeads.filter(l => (l.name + l.email + l.message).toLowerCase().includes(search));

      tbody.innerHTML = filtered.map(l => `
        <tr>
          <td><strong style="color: var(--text-primary);">${l.name}</strong></td>
          <td>${l.email}</td>
          <td>${l.phone || 'N/A'}</td>
          <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${l.message}</td>
          <td style="font-size: 0.8rem; color: var(--text-secondary);">${l.created_at ? l.created_at.substring(0,10) : ''}</td>
          <td>
            <button class="action-btn" onclick='viewLeadModal(${JSON.stringify(l)})'><i data-lucide="eye" style="width: 14px;"></i> View</button>
            <button class="action-btn" style="color: var(--orbit-red);" onclick="deleteItem('delete_lead', ${l.id})"><i data-lucide="trash" style="width: 14px;"></i></button>
          </td>
        </tr>
      `).join('');

      lucide.createIcons();
    }

    function filterLeads() { renderLeads(); }

    function viewLeadModal(l) {
      document.getElementById('modal-title').textContent = `Contact Lead: ${l.name}`;
      document.getElementById('modal-body').innerHTML = `
        <div style="margin-bottom: 12px;"><strong>Email:</strong> ${l.email}</div>
        <div style="margin-bottom: 12px;"><strong>Phone:</strong> ${l.phone || 'N/A'}</div>
        <div style="margin-bottom: 12px;"><strong>Company:</strong> ${l.company || 'N/A'}</div>
        <div style="margin-bottom: 12px;"><strong>Message:</strong></div>
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 14px; border-radius: 10px; color: var(--text-primary);">${l.message}</div>
      `;
      document.getElementById('modal').style.display = 'flex';
    }

    // Render Jobs
    async function loadJobs() {
      const res = await fetch('../api/admin.php?action=get_jobs');
      const data = await res.json();
      if (data.success) {
        const tbody = document.getElementById('jobs-tbody');
        tbody.innerHTML = data.data.map(j => `
          <tr>
            <td><strong style="color: var(--text-primary);">${j.title}</strong></td>
            <td>${j.department}</td>
            <td>${j.location || j.type}</td>
            <td><span class="badge badge-approved">${j.status || 'Active'}</span></td>
            <td>
              <button class="action-btn" style="color: var(--orbit-red);" onclick="deleteItem('delete_job', ${j.id})"><i data-lucide="trash" style="width: 14px;"></i></button>
            </td>
          </tr>
        `).join('');
        lucide.createIcons();
      }
    }

    // Post Job Form
    document.getElementById('add-job-form')?.addEventListener('submit', async (e) => {
      e.preventDefault();
      const fd = new FormData();
      fd.append('action', 'add_job');
      fd.append('title', document.getElementById('job-title').value);
      fd.append('department', document.getElementById('job-dept').value);
      fd.append('location', document.getElementById('job-loc').value);
      fd.append('type', 'Full-time');
      fd.append('experience', document.getElementById('job-exp').value);
      fd.append('description', document.getElementById('job-desc').value);

      const res = await fetch('../api/admin.php', { method: 'POST', body: fd });
      const data = await res.json();
      if (data.success) {
        alert('Job posting published successfully!');
        loadJobs();
        document.getElementById('add-job-form').reset();
      }
    });

    // Render Analytics Bars
    function renderAnalytics() {
      const serviceCounts = {};
      const budgetCounts = {};

      globalQuotes.forEach(q => {
        serviceCounts[q.services] = (serviceCounts[q.services] || 0) + 1;
        budgetCounts[q.budget] = (budgetCounts[q.budget] || 0) + 1;
      });

      const sContainer = document.getElementById('service-analytics-bars');
      const totalQ = globalQuotes.length || 1;
      sContainer.innerHTML = Object.entries(serviceCounts).map(([srv, count]) => {
        const pct = Math.round((count / totalQ) * 100);
        return `
          <div>
            <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 6px;">
              <span>${srv}</span> <strong>${count} (${pct}%)</strong>
            </div>
            <div style="background: #e2e8f0; height: 8px; border-radius: 4px; overflow: hidden;">
              <div style="width: ${pct}%; background: var(--orbit-orange); height: 100%;"></div>
            </div>
          </div>
        `;
      }).join('') || '<div style="color: var(--text-secondary);">No quotes data available.</div>';

      const bContainer = document.getElementById('budget-analytics-bars');
      bContainer.innerHTML = Object.entries(budgetCounts).map(([bg, count]) => {
        const pct = Math.round((count / totalQ) * 100);
        return `
          <div>
            <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 6px;">
              <span>${bg}</span> <strong>${count} (${pct}%)</strong>
            </div>
            <div style="background: #e2e8f0; height: 8px; border-radius: 4px; overflow: hidden;">
              <div style="width: ${pct}%; background: var(--orbit-green); height: 100%;"></div>
            </div>
          </div>
        `;
      }).join('') || '<div style="color: var(--text-secondary);">No budget data available.</div>';
    }

    // Delete Item
    async function deleteItem(action, id) {
      if (!confirm('Are you sure you want to delete this record?')) return;
      const fd = new FormData();
      fd.append('action', action);
      fd.append('id', id);
      await fetch('../api/admin.php', { method: 'POST', body: fd });
      loadAllData();
    }

    // Password Form
    document.getElementById('pass-form')?.addEventListener('submit', async (e) => {
      e.preventDefault();
      const oldPass = document.getElementById('old-pass').value;
      const newPass = document.getElementById('new-pass').value;
      const msg = document.getElementById('pass-msg');

      const fd = new FormData();
      fd.append('action', 'change_password');
      fd.append('old_password', oldPass);
      fd.append('new_password', newPass);

      const res = await fetch('../api/admin.php', { method: 'POST', body: fd });
      const data = await res.json();

      msg.style.display = 'block';
      msg.textContent = data.message;
      msg.style.background = data.success ? 'rgba(16,185,129,0.15)' : 'rgba(239,68,68,0.15)';
      msg.style.color = data.success ? '#10b981' : '#ef4444';

      if (data.success) document.getElementById('pass-form').reset();
    });

    // Modal helpers
    function closeModal() {
      document.getElementById('modal').style.display = 'none';
    }

    // Export CSV
    function exportToCSV(type) {
      let data = [];
      let filename = 'export.csv';

      if (type === 'quotes') {
        data = globalQuotes;
        filename = 'orbitone_quotes.csv';
      } else if (type === 'apps') {
        data = globalApps;
        filename = 'orbitone_applications.csv';
      } else if (type === 'leads') {
        data = globalLeads;
        filename = 'orbitone_leads.csv';
      }

      if (!data.length) return alert('No data available to export.');

      const headers = Object.keys(data[0]).join(',');
      const rows = data.map(obj => Object.values(obj).map(v => `"${String(v || '').replace(/"/g, '""')}"`).join(','));
      const csvContent = 'data:text/csv;charset=utf-8,' + [headers, ...rows].join('\n');

      const encodedUri = encodeURI(csvContent);
      const link = document.createElement('a');
      link.setAttribute('href', encodedUri);
      link.setAttribute('download', filename);
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  </script>
<?php endif; ?>
</body>
</html>
