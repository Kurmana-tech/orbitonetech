<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$isLoggedIn = !empty($_SESSION['orbitone_admin']);
$db = getDB();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orbitone Admin Panel — Dashboard</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body style="background: var(--bg-dark); color: var(--text-main);">

<?php if (!$isLoggedIn): ?>
  <!-- Admin Login Screen -->
  <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem;">
    <div class="glass-card" style="max-width: 420px; width: 100%;">
      <div style="text-align: center; margin-bottom: 2rem;">
        <i class="ri-shield-keyhole-line" style="font-size: 3.5rem; color: var(--cyan);"></i>
        <h2 style="font-size: 1.6rem; margin-top: 0.5rem;">Orbitone Admin Login</h2>
        <p style="font-size: 0.85rem; color: var(--text-muted);">Enter administrative password to manage leads & content</p>
      </div>

      <form id="adminLoginForm">
        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" placeholder="Enter admin password..." required autofocus>
          <small style="color: var(--text-dim); display: block; margin-top: 0.5rem;">Default Demo Password: <code>orbitone123</code></small>
        </div>

        <button type="submit" class="btn btn-primary btn-full">
          <span>Authenticate</span>
          <i class="ri-lock-unlock-line"></i>
        </button>
      </form>
    </div>
  </div>
<?php else: ?>

  <!-- Logged In Admin Dashboard Layout -->
  <div class="admin-container">
    
    <!-- Sidebar -->
    <aside class="admin-sidebar">
      <div>
        <a href="../" style="display: flex; align-items: center; gap: 0.5rem; background: #ffffff; padding: 6px 12px; border-radius: 8px;">
          <img src="../assets/images/orbitone-horizontal.png" alt="Orbitone Tech Solutions Logo" style="height: 36px; width: auto;">
        </a>
      </div>

      <ul class="admin-nav">
        <li class="admin-nav-item active" data-target="secOverview"><i class="ri-dashboard-line"></i> Dashboard Overview</li>
        <li class="admin-nav-item" data-target="secLeads"><i class="ri-mail-line"></i> Contact Leads</li>
        <li class="admin-nav-item" data-target="secQuotes"><i class="ri-file-text-line"></i> Quote Requests</li>
        <li class="admin-nav-item" data-target="secApps"><i class="ri-user-search-line"></i> Job Applications</li>
        <li class="admin-nav-item" data-target="secCareers"><i class="ri-briefcase-line"></i> Manage Careers</li>
        <li class="admin-nav-item" data-target="secNotifs" style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
          <span><i class="ri-notification-3-line"></i> Notifications</span>
          <span id="badgeNotifs" style="background: #ef4444; color: white; border-radius: 9999px; padding: 2px 7px; font-size: 0.72rem; font-weight: bold; display: none;">0</span>
        </li>
      </ul>

      <div style="margin-top: auto;">
        <button class="btn btn-secondary btn-sm btn-full" onclick="logoutAdmin()"><i class="ri-logout-box-r-line"></i> Logout</button>
      </div>
    </aside>

    <!-- Main Content Body -->
    <main class="admin-main">
      
      <!-- Overview Section -->
      <section id="secOverview" class="admin-section">
        <h2 style="font-size: 2rem; margin-bottom: 1.5rem;">Dashboard Overview</h2>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 3rem;">
          <div class="glass-card">
            <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Total Contact Leads</div>
            <div style="font-size: 2.25rem; font-weight: 800; color: var(--cyan); margin: 0.5rem 0;" id="cntLeads">0</div>
            <div style="font-size: 0.8rem; color: var(--text-dim);">Inbound Contact Messages</div>
          </div>

          <div class="glass-card">
            <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Quote Requests</div>
            <div style="font-size: 2.25rem; font-weight: 800; color: var(--primary); margin: 0.5rem 0;" id="cntQuotes">0</div>
            <div style="font-size: 0.8rem; color: var(--text-dim);">Multi-step Quote Proposals</div>
          </div>

          <div class="glass-card">
            <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Job Applications</div>
            <div style="font-size: 2.25rem; font-weight: 800; color: var(--purple); margin: 0.5rem 0;" id="cntApps">0</div>
            <div style="font-size: 0.8rem; color: var(--text-dim);">Career Resumes Submitted</div>
          </div>

          <div class="glass-card">
            <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Live Portfolio Items</div>
            <div style="font-size: 2.25rem; font-weight: 800; color: var(--emerald); margin: 0.5rem 0;" id="cntProjects">0</div>
            <div style="font-size: 0.8rem; color: var(--text-dim);">Published Case Studies</div>
          </div>
        </div>
      </section>

      <!-- Contact Leads Section -->
      <section id="secLeads" class="admin-section" style="display: none;">
        <h2 style="font-size: 2rem; margin-bottom: 1.5rem;">Contact Messages & Leads</h2>
        <div class="admin-table-container">
          <table class="admin-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email / Phone</th>
                <th>Company</th>
                <th>Service</th>
                <th>Message Details</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody id="tbodyLeads">
              <!-- Loaded via JS -->
            </tbody>
          </table>
        </div>
      </section>

      <!-- Quote Requests Section -->
      <section id="secQuotes" class="admin-section" style="display: none;">
        <h2 style="font-size: 2rem; margin-bottom: 1.5rem;">Quote Proposals Requested</h2>
        <div class="admin-table-container">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Reference ID</th>
                <th>Contact Name</th>
                <th>Company</th>
                <th>Services Required</th>
                <th>Budget Tier</th>
                <th>Requirements</th>
                <th>Submitted</th>
              </tr>
            </thead>
            <tbody id="tbodyQuotes">
              <!-- Loaded via JS -->
            </tbody>
          </table>
        </div>
      </section>

      <!-- Job Applications Section -->
      <section id="secApps" class="admin-section" style="display: none;">
        <h2 style="font-size: 2rem; margin-bottom: 1.5rem;">Career Applications</h2>
        <div class="admin-table-container">
          <table class="admin-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Role Applied</th>
                <th>Applicant</th>
                <th>Experience</th>
                <th>Cover Note / Links</th>
                <th>Applied Date</th>
              </tr>
            </thead>
            <tbody id="tbodyApps">
              <!-- Loaded via JS -->
            </tbody>
          </table>
        </div>
      </section>

      <!-- Manage Careers Section -->
      <section id="secCareers" class="admin-section" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
          <h2 style="font-size: 2rem;">Manage Career Openings</h2>
          <button onclick="openAddJobModal()" class="btn btn-primary">
            <i class="ri-add-line"></i> Add New Role
          </button>
        </div>

        <div class="admin-table-container">
          <table class="admin-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Title (Role)</th>
                <th>Department</th>
                <th>Type / Location</th>
                <th>Experience / Stipend</th>
                <th>Requirements</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="tbodyCareers">
              <!-- Loaded via JS -->
            </tbody>
          </table>
        </div>
      </section>

      <!-- Notifications Section -->
      <section id="secNotifs" class="admin-section" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
          <h2 style="font-size: 2rem;">Real-time Notifications</h2>
          <button onclick="markAllNotificationsRead()" style="background: var(--cyan); border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; color: #ffffff; font-weight: bold; display: flex; align-items: center; gap: 8px;">
            <i class="ri-check-double-line"></i> Mark All as Read
          </button>
        </div>
        <div class="admin-table-container">
          <table class="admin-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Notification Details</th>
                <th>Status</th>
                <th>Date Received</th>
              </tr>
            </thead>
            <tbody id="tbodyNotifs">
              <!-- Loaded via JS -->
            </tbody>
          </table>
        </div>
      </section>

    </main>
  </div>

<?php endif; ?>

<script src="../assets/js/admin.js"></script>
</body>
</html>
