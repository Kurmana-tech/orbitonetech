<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$isLoggedIn = !empty($_SESSION['orbitone_admin']);
$adminUser = $_SESSION['admin_username'] ?? 'admin';
$db = getDB();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orbitone Tech Solutions — Enterprise Admin Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <style>
    /* =============================================================
     * ORBITONE ADMIN PANEL SYSTEM - PREMIUM LIGHT THEME DESIGN
     * ============================================================= */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      padding: 0 !important;
      margin: 0 !important;
      background: #f8fafc !important;
      color: #0f172a !important;
      min-height: 100vh !important;
      font-family: 'Plus Jakarta Sans', sans-serif !important;
      overflow-x: hidden;
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    /* Custom Sleek Light Scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }
    ::-webkit-scrollbar-track {
      background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #f79300;
    }

    /* Login Screen */
    .admin-login-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 50%, #fff7ed 100%);
    }

    .admin-login-card {
      max-width: 440px;
      width: 100%;
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 24px;
      padding: 40px;
      box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
      transition: all 0.3s ease;
    }

    .admin-login-header {
      text-align: center;
      margin-bottom: 28px;
    }

    .admin-login-logo {
      height: 42px;
      width: auto;
      margin-bottom: 16px;
    }

    .admin-login-icon {
      width: 72px;
      height: 72px;
      border-radius: 20px;
      background: #fff7ed;
      border: 1px solid rgba(247, 147, 0, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 16px auto;
      color: #f79300;
      font-size: 2.2rem;
      box-shadow: 0 8px 20px rgba(247, 147, 0, 0.15);
    }

    .admin-login-title {
      font-size: 1.75rem;
      font-weight: 800;
      color: #0f172a;
      margin-bottom: 6px;
      letter-spacing: -0.02em;
    }

    .admin-login-subtitle {
      font-size: 0.88rem;
      color: #64748b;
    }

    .admin-input-group {
      margin-bottom: 20px;
    }

    .admin-input-label {
      display: block;
      font-size: 0.82rem;
      font-weight: 700;
      color: #334155;
      margin-bottom: 8px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .admin-input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .admin-input-wrapper i.left-icon {
      position: absolute;
      left: 14px;
      color: #94a3b8;
      font-size: 1.1rem;
    }

    .admin-input-wrapper i.toggle-pwd {
      position: absolute;
      right: 14px;
      color: #64748b;
      font-size: 1.1rem;
      cursor: pointer;
      transition: color 0.2s;
    }

    .admin-input-wrapper i.toggle-pwd:hover {
      color: #f79300;
    }

    .admin-control {
      width: 100%;
      background: #ffffff;
      border: 1px solid #cbd5e1;
      border-radius: 12px;
      padding: 12px 16px;
      padding-left: 44px;
      color: #0f172a;
      font-size: 0.95rem;
      font-family: inherit;
      outline: none;
      transition: all 0.2s ease;
    }

    .admin-control:focus {
      border-color: #f79300;
      background: #ffffff;
      box-shadow: 0 0 0 3px rgba(247, 147, 0, 0.15);
    }

    .admin-btn-primary {
      width: 100%;
      background: linear-gradient(135deg, #f79300 0%, #ff6b00 100%);
      color: #ffffff;
      border: none;
      border-radius: 12px;
      padding: 14px;
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      box-shadow: 0 8px 25px rgba(247, 147, 0, 0.25);
      transition: all 0.3s ease;
    }

    .admin-btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 30px rgba(247, 147, 0, 0.4);
    }

    .admin-btn-primary:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    .admin-btn-secondary {
      background: #ffffff;
      border: 1px solid #cbd5e1;
      color: #334155;
      padding: 10px 18px;
      border-radius: 10px;
      font-size: 0.88rem;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.2s ease;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
    }

    .admin-btn-secondary:hover {
      background: #f8fafc;
      color: #0f172a;
      border-color: #94a3b8;
    }

    .admin-alert-banner {
      padding: 12px 16px;
      border-radius: 10px;
      font-size: 0.85rem;
      font-weight: 600;
      margin-bottom: 20px;
      display: none;
    }

    .admin-alert-error {
      background: #fef2f2;
      border: 1px solid #fca5a5;
      color: #dc2626;
    }

    /* Dashboard Layout */
    .admin-container {
      display: flex;
      min-height: 100vh;
      width: 100vw;
      background: #f8fafc;
    }

    .admin-sidebar {
      width: 280px;
      background: #ffffff;
      border-right: 1px solid #e2e8f0;
      padding: 24px 20px;
      display: flex;
      flex-direction: column;
      flex-shrink: 0;
      z-index: 100;
      box-shadow: 4px 0 24px rgba(15, 23, 42, 0.02);
    }

    .admin-sidebar-logo {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 12px 16px;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 14px;
      margin-bottom: 28px;
    }

    .admin-sidebar-logo img {
      height: 38px;
      width: auto;
      max-width: 100%;
      object-fit: contain;
    }

    .admin-nav {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .admin-nav-item {
      padding: 12px 16px;
      border-radius: 12px;
      font-size: 0.92rem;
      font-weight: 600;
      color: #475569;
      cursor: pointer;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .admin-nav-item:hover {
      background: #f1f5f9;
      color: #0f172a;
    }

    .admin-nav-item.active {
      background: linear-gradient(135deg, rgba(247, 147, 0, 0.12) 0%, rgba(247, 147, 0, 0.04) 100%);
      color: #f79300;
      border: 1px solid rgba(247, 147, 0, 0.3);
    }

    .admin-nav-item i {
      font-size: 1.15rem;
      margin-right: 10px;
    }

    .admin-user-footer {
      margin-top: auto;
      padding-top: 20px;
      border-top: 1px solid #e2e8f0;
    }

    .admin-main {
      flex: 1;
      padding: 32px 40px;
      overflow-y: auto;
      max-width: 100%;
    }

    .admin-header-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 32px;
      flex-wrap: wrap;
      gap: 20px;
    }

    .admin-stat-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
      gap: 20px;
      margin-bottom: 36px;
    }

    .admin-stat-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 18px;
      padding: 24px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
      transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .admin-stat-card:hover {
      transform: translateY(-3px);
      border-color: #f79300;
      box-shadow: 0 10px 25px rgba(247, 147, 0, 0.1);
    }

    .admin-table-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .admin-table-header {
      padding: 20px 24px;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
      background: #ffffff;
    }

    .admin-table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
      font-size: 0.9rem;
    }

    .admin-table th {
      background: #f8fafc;
      padding: 14px 20px;
      font-weight: 700;
      color: #475569;
      font-size: 0.78rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      border-bottom: 1px solid #e2e8f0;
    }

    .admin-table td {
      padding: 16px 20px;
      border-bottom: 1px solid #f1f5f9;
      color: #334155;
      vertical-align: middle;
    }

    .admin-table tr:hover td {
      background: #f8fafc;
    }

    /* Modal Styling for Light Theme */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(15, 23, 42, 0.5);
      backdrop-filter: blur(8px);
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      opacity: 0;
      pointer-events: none;
      transition: all 0.3s ease;
    }

    .modal-overlay.open {
      opacity: 1;
      pointer-events: auto;
    }

    .modal-box {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 20px;
      padding: 32px;
      width: 100%;
      max-width: 600px;
      color: #0f172a;
      position: relative;
      box-shadow: 0 25px 50px rgba(15, 23, 42, 0.15);
      overflow-y: auto;
    }

    .modal-close {
      position: absolute;
      top: 20px;
      right: 20px;
      background: transparent;
      border: none;
      color: #64748b;
      font-size: 1.5rem;
      cursor: pointer;
    }

    .modal-close:hover {
      color: #0f172a;
    }

    @media (max-width: 900px) {
      .admin-container {
        flex-direction: column !important;
      }
      .admin-sidebar {
        width: 100% !important;
        border-right: none !important;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 16px !important;
      }
      .admin-nav {
        flex-direction: row !important;
        overflow-x: auto !important;
        padding-bottom: 8px !important;
      }
      .admin-nav-item {
        white-space: nowrap !important;
      }
      .admin-main {
        padding: 20px 16px !important;
      }
      .modal-box {
        padding: 20px 16px !important;
      }
    }
  </style>
</head>
<body>

<?php if (!$isLoggedIn): ?>
  <!-- High Security Admin Login Screen (Light Theme) -->
  <div class="admin-login-wrapper">
    <div class="admin-login-card">
      
      <div class="admin-login-header">
        <img src="/assets/head1-transparent.png" alt="Orbitone Tech Solutions Logo" class="admin-login-logo" onerror="this.src='../assets/images/head1-transparent.png'">
        <h1 class="admin-login-title">Admin Portal</h1>
        <p class="admin-login-subtitle">Orbitone Tech Solutions — Management Authentication</p>
      </div>

      <div id="loginAlertBanner" class="admin-alert-banner admin-alert-error"></div>

      <form id="adminLoginForm">
        <div class="admin-input-group">
          <label class="admin-input-label">Username</label>
          <div class="admin-input-wrapper">
            <i class="ri-user-3-line left-icon"></i>
            <input type="text" name="username" class="admin-control" value="admin" placeholder="Enter admin username" required autofocus>
          </div>
        </div>

        <div class="admin-input-group">
          <label class="admin-input-label">Password</label>
          <div class="admin-input-wrapper">
            <i class="ri-lock-2-line left-icon"></i>
            <input type="password" id="adminPasswordInput" name="password" class="admin-control" placeholder="Enter password..." required>
            <i class="ri-eye-line toggle-pwd" onclick="togglePasswordVisibility('adminPasswordInput', this)"></i>
          </div>
          <small style="color: #64748b; font-size: 0.78rem; display: block; margin-top: 8px;">
            Default Credentials: <code>admin</code> / <code>orbitone123</code>
          </small>
        </div>

        <button type="submit" id="btnLoginSubmit" class="admin-btn-primary">
          <span>Authenticate &amp; Access</span>
          <i class="ri-arrow-right-line"></i>
        </button>
      </form>
    </div>
  </div>

<?php else: ?>

  <!-- Logged In Enterprise Dashboard Layout (Light Theme) -->
  <div class="admin-container">
    
    <!-- Sidebar Navigation -->
    <aside class="admin-sidebar">
      <div>
        <div class="admin-sidebar-logo">
          <img src="/assets/head1-transparent.png" alt="Orbitone Tech Solutions Logo" onerror="this.src='../assets/images/head1-transparent.png'">
        </div>
      </div>

      <ul class="admin-nav">
        <li class="admin-nav-item active" data-target="secOverview">
          <span><i class="ri-dashboard-3-line"></i> Overview</span>
        </li>
        <li class="admin-nav-item" data-target="secLeads">
          <span><i class="ri-mail-unread-line"></i> Contact Leads</span>
        </li>
        <li class="admin-nav-item" data-target="secQuotes">
          <span><i class="ri-file-list-3-line"></i> Quote Requests</span>
        </li>
        <li class="admin-nav-item" data-target="secApps">
          <span><i class="ri-user-search-line"></i> Applications</span>
        </li>
        <li class="admin-nav-item" data-target="secCareers">
          <span><i class="ri-briefcase-line"></i> Manage Careers</span>
        </li>
        <li class="admin-nav-item" data-target="secNotifs">
          <span><i class="ri-notification-3-line"></i> Notifications</span>
          <span id="badgeNotifs" style="background: #ef4444; color: #ffffff; border-radius: 9999px; padding: 2px 8px; font-size: 0.72rem; font-weight: 800; display: none;">0</span>
        </li>
      </ul>

      <div class="admin-user-footer">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
          <div style="width: 38px; height: 38px; border-radius: 10px; background: #fff7ed; border: 1px solid rgba(247, 147, 0, 0.3); color: #f79300; display: flex; align-items: center; justify-content: center; font-weight: bold;">
            <i class="ri-admin-line"></i>
          </div>
          <div>
            <div style="font-weight: 700; font-size: 0.9rem; color: #0f172a;"><?= htmlspecialchars($adminUser) ?></div>
            <div style="font-size: 0.75rem; color: #16a34a; font-weight: 600;">● Session Authenticated</div>
          </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 8px;">
          <button class="admin-btn-secondary" onclick="openChangePasswordModal()" style="width: 100%; justify-content: center;">
            <i class="ri-key-2-line"></i> Change Password
          </button>
          <button class="admin-btn-secondary" onclick="logoutAdmin()" style="width: 100%; justify-content: center; color: #dc2626; background: #fef2f2; border-color: #fca5a5;">
            <i class="ri-logout-box-r-line"></i> Sign Out
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content Area -->
    <main class="admin-main">
      
      <!-- Top Bar -->
      <div class="admin-header-bar">
        <div>
          <h1 id="pageHeading" style="font-size: 1.8rem; font-weight: 800; color: #0f172a; margin: 0;">Dashboard Overview</h1>
          <p style="font-size: 0.88rem; color: #64748b; margin-top: 4px;">Monitor inbound leads, proposals, career applications, and system logs.</p>
        </div>

        <div style="display: flex; gap: 12px; align-items: center;">
          <a href="/" target="_blank" class="admin-btn-secondary">
            <i class="ri-external-link-line"></i> Open Live Site
          </a>
        </div>
      </div>

      <!-- Overview Section -->
      <section id="secOverview" class="admin-section">
        <div class="admin-stat-grid">
          
          <div class="admin-stat-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
              <span style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Contact Leads</span>
              <div style="width: 36px; height: 36px; border-radius: 10px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center;">
                <i class="ri-mail-line"></i>
              </div>
            </div>
            <div style="font-size: 2.2rem; font-weight: 800; color: #0284c7;" id="cntLeads">0</div>
            <div style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">Inbound contact inquiries</div>
          </div>

          <div class="admin-stat-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
              <span style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Quote Requests</span>
              <div style="width: 36px; height: 36px; border-radius: 10px; background: #dbeafe; color: #2563eb; display: flex; align-items: center; justify-content: center;">
                <i class="ri-file-text-line"></i>
              </div>
            </div>
            <div style="font-size: 2.2rem; font-weight: 800; color: #2563eb;" id="cntQuotes">0</div>
            <div style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">Scoping proposals submitted</div>
          </div>

          <div class="admin-stat-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
              <span style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Job Applications</span>
              <div style="width: 36px; height: 36px; border-radius: 10px; background: #f3e8ff; color: #9333ea; display: flex; align-items: center; justify-content: center;">
                <i class="ri-user-search-line"></i>
              </div>
            </div>
            <div style="font-size: 2.2rem; font-weight: 800; color: #9333ea;" id="cntApps">0</div>
            <div style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">Resumes &amp; applications</div>
          </div>

          <div class="admin-stat-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
              <span style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Active Roles</span>
              <div style="width: 36px; height: 36px; border-radius: 10px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center;">
                <i class="ri-briefcase-line"></i>
              </div>
            </div>
            <div style="font-size: 2.2rem; font-weight: 800; color: #16a34a;" id="cntCareers">0</div>
            <div style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">Published career openings</div>
          </div>

        </div>
      </section>

      <!-- Contact Leads Section -->
      <section id="secLeads" class="admin-section" style="display: none;">
        <div class="admin-table-card">
          <div class="admin-table-header">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0;">Inbound Contact Messages</h3>
          </div>
          <div style="overflow-x: auto;">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Contact Info</th>
                  <th>Company</th>
                  <th>Service Requested</th>
                  <th>Message Details</th>
                  <th>Received Date</th>
                </tr>
              </thead>
              <tbody id="tbodyLeads">
                <!-- Loaded via JS -->
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Quote Requests Section -->
      <section id="secQuotes" class="admin-section" style="display: none;">
        <div class="admin-table-card">
          <div class="admin-table-header">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0;">Project Quote Proposals</h3>
          </div>
          <div style="overflow-x: auto;">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Reference ID</th>
                  <th>Client Contact</th>
                  <th>Company</th>
                  <th>Services Needed</th>
                  <th>Budget Tier</th>
                  <th>Requirements Scope</th>
                  <th>Submitted Date</th>
                </tr>
              </thead>
              <tbody id="tbodyQuotes">
                <!-- Loaded via JS -->
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Job Applications Section -->
      <section id="secApps" class="admin-section" style="display: none;">
        <div class="admin-table-card">
          <div class="admin-table-header">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0;">Career Resumes &amp; Applicants</h3>
          </div>
          <div style="overflow-x: auto;">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Target Role</th>
                  <th>Applicant Name &amp; Email</th>
                  <th>Experience / Link</th>
                  <th>Resume File</th>
                  <th>Applicant Note</th>
                  <th>Applied Date</th>
                </tr>
              </thead>
              <tbody id="tbodyApps">
                <!-- Loaded via JS -->
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Manage Careers Section -->
      <section id="secCareers" class="admin-section" style="display: none;">
        <div class="admin-table-card">
          <div class="admin-table-header">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0;">Manage Career Openings</h3>
            <button onclick="openAddJobModal()" class="admin-btn-secondary" style="background: #fff7ed; border-color: rgba(247, 147, 0, 0.4); color: #d97706;">
              <i class="ri-add-line"></i> Publish New Opening
            </button>
          </div>
          <div style="overflow-x: auto;">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Role Title</th>
                  <th>Department</th>
                  <th>Type &amp; Location</th>
                  <th>Exp &amp; Compensation</th>
                  <th>Key Skills / Requirements</th>
                  <th>Description</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="tbodyCareers">
                <!-- Loaded via JS -->
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Notifications Section -->
      <section id="secNotifs" class="admin-section" style="display: none;">
        <div class="admin-table-card">
          <div class="admin-table-header">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0;">Audit Log &amp; Notifications</h3>
            <button onclick="markAllNotificationsRead()" class="admin-btn-secondary" style="background: #e0f2fe; border-color: #bae6fd; color: #0284c7;">
              <i class="ri-check-double-line"></i> Mark All as Read
            </button>
          </div>
          <div style="overflow-x: auto;">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Event Category</th>
                  <th>Log Details</th>
                  <th>Status</th>
                  <th>Timestamp</th>
                </tr>
              </thead>
              <tbody id="tbodyNotifs">
                <!-- Loaded via JS -->
              </tbody>
            </table>
          </div>
        </div>
      </section>

    </main>
  </div>

<?php endif; ?>

<script>
/* Orbitone Tech Solutions — Light Theme Admin Panel Script */
document.addEventListener('DOMContentLoaded', () => {
  
  // Password Visibility Toggle
  window.togglePasswordVisibility = function(inputId, iconEl) {
    const input = document.getElementById(inputId);
    if (!input) return;
    if (input.type === 'password') {
      input.type = 'text';
      iconEl.className = 'ri-eye-off-line toggle-pwd';
    } else {
      input.type = 'password';
      iconEl.className = 'ri-eye-line toggle-pwd';
    }
  };

  // Login Form Authentication
  const loginForm = document.getElementById('adminLoginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const banner = document.getElementById('loginAlertBanner');
      const submitBtn = document.getElementById('btnLoginSubmit');
      
      if (banner) {
        banner.style.display = 'none';
        banner.textContent = '';
      }

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Authenticating...</span><i class="ri-loader-4-line ri-spin"></i>';
      }

      const formData = new FormData(loginForm);
      try {
        const res = await fetch('/api/admin.php?action=login', { method: 'POST', body: formData });
        const result = await res.json();
        
        if (result.success) {
          window.location.reload();
        } else {
          if (banner) {
            banner.className = 'admin-alert-banner admin-alert-error';
            banner.textContent = result.message || 'Invalid admin credentials.';
            banner.style.display = 'block';
          }
        }
      } catch (err) {
        if (banner) {
          banner.className = 'admin-alert-banner admin-alert-error';
          banner.textContent = 'Server communication error. Please try again.';
          banner.style.display = 'block';
        }
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<span>Authenticate &amp; Access</span><i class="ri-arrow-right-line"></i>';
        }
      }
    });
  }

  // Admin Tab Navigation
  const navItems = document.querySelectorAll('.admin-nav-item');
  const sections = document.querySelectorAll('.admin-section');
  const headingEl = document.getElementById('pageHeading');

  const pageHeadings = {
    'secOverview': 'Dashboard Overview',
    'secLeads': 'Contact Leads & Messages',
    'secQuotes': 'Project Quote Requests',
    'secApps': 'Career Applications',
    'secCareers': 'Manage Career Openings',
    'secNotifs': 'Audit Log & Notifications'
  };

  navItems.forEach(item => {
    item.addEventListener('click', () => {
      navItems.forEach(n => n.classList.remove('active'));
      item.classList.add('active');

      const target = item.dataset.target;
      sections.forEach(s => {
        s.style.display = s.id === target ? 'block' : 'none';
      });

      if (headingEl && pageHeadings[target]) {
        headingEl.textContent = pageHeadings[target];
      }

      if (target === 'secOverview') loadOverview();
      if (target === 'secLeads') loadLeads();
      if (target === 'secQuotes') loadQuotes();
      if (target === 'secApps') loadApplications();
      if (target === 'secCareers') loadCareers();
      if (target === 'secNotifs') loadNotifications();
    });
  });

  // Fetch Overview Stats
  window.loadOverview = async function() {
    try {
      const res = await fetch('/api/admin.php?action=get_overview');
      const result = await res.json();
      if (result.success && result.counts) {
        if (document.getElementById('cntLeads')) document.getElementById('cntLeads').textContent = result.counts.leads || 0;
        if (document.getElementById('cntQuotes')) document.getElementById('cntQuotes').textContent = result.counts.quotes || 0;
        if (document.getElementById('cntApps')) document.getElementById('cntApps').textContent = result.counts.applications || 0;
        
        fetchCareersCount();

        const badge = document.getElementById('badgeNotifs');
        if (badge) {
          const count = parseInt(result.counts.notifications || 0);
          if (count > 0) {
            badge.textContent = count;
            badge.style.display = 'inline-block';
          } else {
            badge.style.display = 'none';
          }
        }
      }
    } catch (e) {}
  };

  async function fetchCareersCount() {
    try {
      const res = await fetch('/api/admin.php?action=get_jobs');
      const result = await res.json();
      if (result.success && result.data) {
        if (document.getElementById('cntCareers')) {
          document.getElementById('cntCareers').textContent = result.data.length;
        }
      }
    } catch (e) {}
  }

  // Load Contact Leads Table
  async function loadLeads() {
    const tbody = document.getElementById('tbodyLeads');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 24px; color:#64748b;"><i class="ri-loader-4-line ri-spin"></i> Loading leads...</td></tr>';
    try {
      const res = await fetch('/api/admin.php?action=get_leads');
      const result = await res.json();
      if (result.success && result.data) {
        if (result.data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 24px; color:#64748b;">No contact messages received yet.</td></tr>';
          return;
        }
        tbody.innerHTML = result.data.map(item => `
          <tr>
            <td><strong style="color:#0284c7;">#${item.id}</strong></td>
            <td><strong style="color:#0f172a;">${escapeHtml(item.name)}</strong></td>
            <td><div>${escapeHtml(item.email)}</div><small style="color:#64748b;">${escapeHtml(item.phone || 'No phone')}</small></td>
            <td>${escapeHtml(item.company || '—')}</td>
            <td><span style="background:#fff7ed; color:#d97706; border:1px solid rgba(247,147,0,0.3); padding:3px 10px; border-radius:12px; font-size:0.78rem; font-weight:700;">${escapeHtml(item.service)}</span></td>
            <td style="max-width:300px;">${escapeHtml(item.message)}</td>
            <td><small style="color:#64748b;">${item.created_at}</small></td>
          </tr>
        `).join('');
      }
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; color:#dc2626; padding:24px;">Failed to load leads data.</td></tr>';
    }
  }

  // Load Quote Proposals Table
  async function loadQuotes() {
    const tbody = document.getElementById('tbodyQuotes');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 24px; color:#64748b;"><i class="ri-loader-4-line ri-spin"></i> Loading quote requests...</td></tr>';
    try {
      const res = await fetch('/api/admin.php?action=get_quotes');
      const result = await res.json();
      if (result.success && result.data) {
        if (result.data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 24px; color:#64748b;">No quote proposals submitted yet.</td></tr>';
          return;
        }
        tbody.innerHTML = result.data.map(item => `
          <tr>
            <td><strong style="color:#2563eb; letter-spacing:0.05em;">${escapeHtml(item.reference_id)}</strong></td>
            <td><strong style="color:#0f172a;">${escapeHtml(item.contact_name)}</strong><br><small style="color:#64748b;">${escapeHtml(item.contact_email)}</small></td>
            <td>${escapeHtml(item.company || '—')}</td>
            <td><span style="background:#dbeafe; color:#1d4ed8; border:1px solid #bfdbfe; padding:3px 10px; border-radius:12px; font-size:0.78rem; font-weight:700;">${escapeHtml(item.services)}</span></td>
            <td><strong style="color:#16a34a;">${escapeHtml(item.budget)}</strong></td>
            <td style="max-width:280px; white-space:pre-wrap;"><small>${escapeHtml(item.requirements || '—')}</small></td>
            <td><small style="color:#64748b;">${item.created_at}</small></td>
          </tr>
        `).join('');
      }
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; color:#dc2626; padding:24px;">Failed to load quote data.</td></tr>';
    }
  }

  // Load Job Applications Table
  async function loadApplications() {
    const tbody = document.getElementById('tbodyApps');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 24px; color:#64748b;"><i class="ri-loader-4-line ri-spin"></i> Loading applications...</td></tr>';
    try {
      const res = await fetch('/api/admin.php?action=get_applications');
      const result = await res.json();
      if (result.success && result.data) {
        if (result.data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 24px; color:#64748b;">No career applications submitted yet.</td></tr>';
          return;
        }
        tbody.innerHTML = result.data.map(item => `
          <tr>
            <td><strong style="color:#9333ea;">#${item.id}</strong></td>
            <td><strong style="color:#0f172a;">${escapeHtml(item.role)}</strong></td>
            <td><strong style="color:#0f172a;">${escapeHtml(item.applicant_name)}</strong><br><small style="color:#64748b;">${escapeHtml(item.email)}</small></td>
            <td>${escapeHtml(item.experience || 'N/A')}</td>
            <td>
              ${item.resume_file ? `
                <a href="/data/uploads/resumes/${escapeHtml(item.resume_file)}" target="_blank" download class="admin-btn-secondary" style="padding:4px 10px; font-size:0.78rem; background:#eff6ff; color:#2563eb; border-color:#bfdbfe;">
                  <i class="ri-file-download-line"></i> Download Resume
                </a>
              ` : '<span style="color:#94a3b8; font-size:0.8rem;">No file uploaded</span>'}
            </td>
            <td style="max-width:260px; white-space:pre-wrap;"><small>${escapeHtml(item.resume_note || '—')}</small></td>
            <td><small style="color:#64748b;">${item.created_at}</small></td>
          </tr>
        `).join('');
      }
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; color:#dc2626; padding:24px;">Failed to load applications.</td></tr>';
    }
  }

  // Load Notifications Log Table
  async function loadNotifications() {
    const tbody = document.getElementById('tbodyNotifs');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding: 24px; color:#64748b;"><i class="ri-loader-4-line ri-spin"></i> Loading audit log...</td></tr>';
    try {
      const res = await fetch('/api/admin.php?action=get_notifications');
      const result = await res.json();
      if (result.success && result.data) {
        if (result.data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding: 24px; color:#64748b;">No notification events logged yet.</td></tr>';
          return;
        }
        tbody.innerHTML = result.data.map(item => `
          <tr style="${item.is_read == 0 ? 'background: #fff7ed; font-weight: 600;' : ''}">
            <td>#${item.id}</td>
            <td>
              <span style="background: ${item.type === 'career' ? '#f3e8ff' : (item.type === 'quote' ? '#dbeafe' : '#e0f2fe')}; color: ${item.type === 'career' ? '#9333ea' : (item.type === 'quote' ? '#1d4ed8' : '#0284c7')}; border: 1px solid #cbd5e1; padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                ${escapeHtml(item.type)}
              </span>
            </td>
            <td><strong style="color:#0f172a;">${escapeHtml(item.message)}</strong></td>
            <td>
              <span style="color: ${item.is_read == 0 ? '#dc2626' : '#64748b'}; font-weight: 700;">
                ${item.is_read == 0 ? '● Unread' : 'Read'}
              </span>
            </td>
            <td><small style="color:#64748b;">${item.created_at}</small></td>
          </tr>
        `).join('');
      }
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; color:#dc2626; padding:24px;">Failed to load audit notifications.</td></tr>';
    }
  }

  // Load Manage Careers Table
  async function loadCareers() {
    const tbody = document.getElementById('tbodyCareers');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding: 24px; color:#64748b;"><i class="ri-loader-4-line ri-spin"></i> Loading career openings...</td></tr>';
    try {
      const res = await fetch('/api/admin.php?action=get_jobs');
      const result = await res.json();
      if (result.success && result.data) {
        if (result.data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding: 24px; color:#64748b;">No career openings published. Click "Publish New Opening" above.</td></tr>';
          return;
        }
        tbody.innerHTML = result.data.map(item => `
          <tr>
            <td><strong style="color:#16a34a;">#${item.id}</strong></td>
            <td><strong style="color:#0f172a;">${escapeHtml(item.title)}</strong></td>
            <td><span style="background:#fff7ed; color:#d97706; border:1px solid rgba(247,147,0,0.3); padding:3px 10px; border-radius:12px; font-size:0.78rem; font-weight:700;">${escapeHtml(item.department)}</span></td>
            <td><div>${escapeHtml(item.type)}</div><small style="color:#64748b;">${escapeHtml(item.location)}</small></td>
            <td><div>${escapeHtml(item.experience)}</div><small style="color:#16a34a; font-weight:700;">${escapeHtml(item.stipend || '—')}</small></td>
            <td style="max-width:200px; white-space:pre-wrap;"><small>${escapeHtml(item.requirements || '—')}</small></td>
            <td style="max-width:250px; white-space:pre-wrap;"><small>${escapeHtml(item.description || '—')}</small></td>
            <td>
              <button onclick="deleteJob(${item.id})" class="admin-btn-secondary" style="color: #dc2626; background:#fef2f2; border-color: #fca5a5; padding: 6px 12px; font-size: 0.8rem;">
                <i class="ri-delete-bin-line"></i> Delete
              </button>
            </td>
          </tr>
        `).join('');
      }
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; color:#dc2626; padding:24px;">Failed to load careers.</td></tr>';
    }
  }

  // Global Actions
  window.markAllNotificationsRead = async function() {
    try {
      const res = await fetch('/api/admin.php?action=mark_notifications_read', { method: 'POST' });
      const result = await res.json();
      if (result.success) {
        loadNotifications();
        loadOverview();
      }
    } catch (e) {
      alert('Error marking notifications as read.');
    }
  };

  window.logoutAdmin = async function() {
    await fetch('/api/admin.php?action=logout');
    window.location.reload();
  };

  window.deleteJob = async function(id) {
    if (!confirm('Are you sure you want to delete this career opening? It will be removed from the website.')) return;
    try {
      const formData = new FormData();
      formData.append('id', id);
      const res = await fetch('/api/admin.php?action=delete_job', { method: 'POST', body: formData });
      const result = await res.json();
      if (result.success) {
        loadCareers();
        loadOverview();
      } else {
        alert(result.message || 'Failed to delete career opening.');
      }
    } catch (e) {
      alert('Network error while deleting career opening.');
    }
  };

  // Change Password Modal
  window.openChangePasswordModal = function() {
    showAdminModal('Security — Change Admin Password', `
      <form id="changePasswordForm" onsubmit="submitChangePasswordForm(event)">
        <div id="pwdAlertBanner" class="admin-alert-banner admin-alert-error"></div>

        <div class="admin-input-group">
          <label class="admin-input-label">Current Password *</label>
          <div class="admin-input-wrapper">
            <i class="ri-lock-line left-icon"></i>
            <input type="password" id="pwdOld" name="old_password" class="admin-control" placeholder="Enter current password" required>
            <i class="ri-eye-line toggle-pwd" onclick="togglePasswordVisibility('pwdOld', this)"></i>
          </div>
        </div>

        <div class="admin-input-group">
          <label class="admin-input-label">New Password * (Min 6 chars)</label>
          <div class="admin-input-wrapper">
            <i class="ri-key-2-line left-icon"></i>
            <input type="password" id="pwdNew" name="new_password" class="admin-control" placeholder="Enter new strong password" required minlength="6">
            <i class="ri-eye-line toggle-pwd" onclick="togglePasswordVisibility('pwdNew', this)"></i>
          </div>
        </div>

        <button type="submit" class="admin-btn-primary" style="margin-top: 24px;">
          <span>Update Security Password</span>
          <i class="ri-check-line"></i>
        </button>
      </form>
    `);
  };

  window.submitChangePasswordForm = async function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const banner = document.getElementById('pwdAlertBanner');
    const submitBtn = form.querySelector('button[type="submit"]');

    if (banner) banner.style.display = 'none';
    if (submitBtn) submitBtn.disabled = true;

    try {
      const res = await fetch('/api/admin.php?action=change_password', {
        method: 'POST',
        body: formData
      });
      const result = await res.json();
      if (result.success) {
        alert('Password updated successfully! Please use your new password for future logins.');
        closeAdminModal();
      } else {
        if (banner) {
          banner.className = 'admin-alert-banner admin-alert-error';
          banner.textContent = result.message || 'Failed to update password.';
          banner.style.display = 'block';
        }
      }
    } catch (err) {
      if (banner) {
        banner.className = 'admin-alert-banner admin-alert-error';
        banner.textContent = 'Server communication error.';
        banner.style.display = 'block';
      }
    } finally {
      if (submitBtn) submitBtn.disabled = false;
    }
  };

  // Add Job Opening Modal
  window.openAddJobModal = function() {
    showAdminModal('Publish New Career Opening', `
      <form id="addJobForm" onsubmit="submitAddJobForm(event)">
        <div class="admin-input-group">
          <label class="admin-input-label">Job Title / Role Name *</label>
          <input type="text" name="title" class="admin-control" style="padding-left:16px;" placeholder="e.g. Senior Frontend Engineer" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
          <div class="admin-input-group">
            <label class="admin-input-label">Department *</label>
            <select name="department" class="admin-control" style="padding-left:16px; background:#ffffff;" required>
              <option value="Engineering">Engineering</option>
              <option value="AI & Data">AI & Data</option>
              <option value="Marketing">Marketing</option>
              <option value="Design">Design</option>
              <option value="Sales">Sales</option>
              <option value="Operations">Operations</option>
            </select>
          </div>

          <div class="admin-input-group">
            <label class="admin-input-label">Job Type *</label>
            <select name="type" class="admin-control" style="padding-left:16px; background:#ffffff;" required>
              <option value="Full-time">Full-time</option>
              <option value="Internship">Internship</option>
              <option value="Part-time">Part-time</option>
              <option value="Contract">Contract</option>
            </select>
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
          <div class="admin-input-group">
            <label class="admin-input-label">Location *</label>
            <select name="location" class="admin-control" style="padding-left:16px; background:#ffffff;" required>
              <option value="Remote">Remote</option>
              <option value="Hybrid">Hybrid</option>
              <option value="On-site">On-site</option>
            </select>
          </div>

          <div class="admin-input-group">
            <label class="admin-input-label">Experience Required *</label>
            <input type="text" name="experience" class="admin-control" style="padding-left:16px;" placeholder="e.g. 2+ Years, Fresher" required>
          </div>
        </div>

        <div class="admin-input-group">
          <label class="admin-input-label">Stipend / Salary Compensation</label>
          <input type="text" name="stipend" class="admin-control" style="padding-left:16px;" placeholder="e.g. $5k/mo or 8 LPA">
        </div>

        <div class="admin-input-group">
          <label class="admin-input-label">Key Requirements / Skills</label>
          <textarea name="requirements" class="admin-control" style="padding-left:16px;" rows="3" placeholder="React, Node.js, TypeScript..."></textarea>
        </div>

        <div class="admin-input-group">
          <label class="admin-input-label">Role Description *</label>
          <textarea name="description" class="admin-control" style="padding-left:16px;" rows="3" placeholder="Brief summary of the role..." required></textarea>
        </div>

        <button type="submit" class="admin-btn-primary" style="margin-top: 16px;">
          <span>Publish Role to Live Site</span>
          <i class="ri-send-plane-fill"></i>
        </button>
      </form>
    `);
  };

  window.submitAddJobForm = async function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) submitBtn.disabled = true;

    try {
      const res = await fetch('/api/admin.php?action=add_job', {
        method: 'POST',
        body: formData
      });
      const result = await res.json();
      if (result.success) {
        closeAdminModal();
        loadCareers();
        loadOverview();
      } else {
        alert(result.message || 'Failed to add job opening.');
      }
    } catch (err) {
      alert('Server communication error.');
    } finally {
      if (submitBtn) submitBtn.disabled = false;
    }
  };

  // Modal Overlay Helpers
  window.showAdminModal = function (title, htmlBody) {
    let overlay = document.getElementById('adminModalOverlay');
    if (!overlay) {
      overlay = document.createElement('div');
      overlay.id = 'adminModalOverlay';
      overlay.className = 'modal-overlay';
      overlay.innerHTML = `
        <div class="modal-box">
          <button class="modal-close" onclick="closeAdminModal()">&times;</button>
          <h3 id="adminModalTitle" style="font-size: 1.4rem; font-weight: 800; margin-bottom: 20px; color: #0f172a;"></h3>
          <div id="adminModalBody"></div>
        </div>
      `;
      overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeAdminModal();
      });
      document.body.appendChild(overlay);
    }

    document.getElementById('adminModalTitle').textContent = title;
    document.getElementById('adminModalBody').innerHTML = htmlBody;
    overlay.classList.add('open');
  };

  window.closeAdminModal = function () {
    const overlay = document.getElementById('adminModalOverlay');
    if (overlay) overlay.classList.remove('open');
  };

  function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  }

  loadOverview();
});
</script>
</body>
</html>
