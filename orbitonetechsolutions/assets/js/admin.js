/* Orbitone Tech Solutions — Modern Admin Panel System JavaScript */

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
        const res = await fetch('../api/admin.php?action=login', { method: 'POST', body: formData });
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
      const res = await fetch('../api/admin.php?action=get_overview');
      const result = await res.json();
      if (result.success && result.counts) {
        if (document.getElementById('cntLeads')) document.getElementById('cntLeads').textContent = result.counts.leads || 0;
        if (document.getElementById('cntQuotes')) document.getElementById('cntQuotes').textContent = result.counts.quotes || 0;
        if (document.getElementById('cntApps')) document.getElementById('cntApps').textContent = result.counts.applications || 0;
        
        // Also fetch active careers count
        fetchCareersCount();

        // Handle Notifications badge count
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
      const res = await fetch('../api/admin.php?action=get_jobs');
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
    tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 24px; color:#94a3b8;"><i class="ri-loader-4-line ri-spin"></i> Loading leads...</td></tr>';
    try {
      const res = await fetch('../api/admin.php?action=get_leads');
      const result = await res.json();
      if (result.success && result.data) {
        if (result.data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 24px; color:#94a3b8;">No contact messages received yet.</td></tr>';
          return;
        }
        tbody.innerHTML = result.data.map(item => `
          <tr>
            <td><strong style="color:#06b6d4;">#${item.id}</strong></td>
            <td><strong style="color:#ffffff;">${escapeHtml(item.name)}</strong></td>
            <td><div>${escapeHtml(item.email)}</div><small style="color:#64748b;">${escapeHtml(item.phone || 'No phone')}</small></td>
            <td>${escapeHtml(item.company || '—')}</td>
            <td><span style="background:rgba(247, 147, 0, 0.15); color:#f79300; border:1px solid rgba(247,147,0,0.3); padding:3px 10px; border-radius:12px; font-size:0.78rem; font-weight:700;">${escapeHtml(item.service)}</span></td>
            <td style="max-width:300px;">${escapeHtml(item.message)}</td>
            <td><small style="color:#64748b;">${item.created_at}</small></td>
          </tr>
        `).join('');
      }
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; color:#ef4444; padding:24px;">Failed to load leads data.</td></tr>';
    }
  }

  // Load Quote Proposals Table
  async function loadQuotes() {
    const tbody = document.getElementById('tbodyQuotes');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 24px; color:#94a3b8;"><i class="ri-loader-4-line ri-spin"></i> Loading quote requests...</td></tr>';
    try {
      const res = await fetch('../api/admin.php?action=get_quotes');
      const result = await res.json();
      if (result.success && result.data) {
        if (result.data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 24px; color:#94a3b8;">No quote proposals submitted yet.</td></tr>';
          return;
        }
        tbody.innerHTML = result.data.map(item => `
          <tr>
            <td><strong style="color:#3b82f6; letter-spacing:0.05em;">${escapeHtml(item.reference_id)}</strong></td>
            <td><strong style="color:#ffffff;">${escapeHtml(item.contact_name)}</strong><br><small style="color:#94a3b8;">${escapeHtml(item.contact_email)}</small></td>
            <td>${escapeHtml(item.company || '—')}</td>
            <td><span style="background:rgba(59, 130, 246, 0.15); color:#60a5fa; border:1px solid rgba(59, 130, 246, 0.3); padding:3px 10px; border-radius:12px; font-size:0.78rem; font-weight:700;">${escapeHtml(item.services)}</span></td>
            <td><strong style="color:#10b981;">${escapeHtml(item.budget)}</strong></td>
            <td style="max-width:280px; white-space:pre-wrap;"><small>${escapeHtml(item.requirements || '—')}</small></td>
            <td><small style="color:#64748b;">${item.created_at}</small></td>
          </tr>
        `).join('');
      }
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; color:#ef4444; padding:24px;">Failed to load quote data.</td></tr>';
    }
  }

  // Load Job Applications Table
  async function loadApplications() {
    const tbody = document.getElementById('tbodyApps');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding: 24px; color:#94a3b8;"><i class="ri-loader-4-line ri-spin"></i> Loading applications...</td></tr>';
    try {
      const res = await fetch('../api/admin.php?action=get_applications');
      const result = await res.json();
      if (result.success && result.data) {
        if (result.data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding: 24px; color:#94a3b8;">No career applications submitted yet.</td></tr>';
          return;
        }
        tbody.innerHTML = result.data.map(item => `
          <tr>
            <td><strong style="color:#c084fc;">#${item.id}</strong></td>
            <td><strong style="color:#ffffff;">${escapeHtml(item.role)}</strong></td>
            <td><strong style="color:#ffffff;">${escapeHtml(item.applicant_name)}</strong><br><small style="color:#94a3b8;">${escapeHtml(item.email)}</small></td>
            <td>${escapeHtml(item.experience || 'N/A')}</td>
            <td style="max-width:260px; white-space:pre-wrap;"><small>${escapeHtml(item.resume_note || '—')}</small></td>
            <td><small style="color:#64748b;">${item.created_at}</small></td>
          </tr>
        `).join('');
      }
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; color:#ef4444; padding:24px;">Failed to load applications.</td></tr>';
    }
  }

  // Load Notifications Log Table
  async function loadNotifications() {
    const tbody = document.getElementById('tbodyNotifs');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding: 24px; color:#94a3b8;"><i class="ri-loader-4-line ri-spin"></i> Loading audit log...</td></tr>';
    try {
      const res = await fetch('../api/admin.php?action=get_notifications');
      const result = await res.json();
      if (result.success && result.data) {
        if (result.data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding: 24px; color:#94a3b8;">No notification events logged yet.</td></tr>';
          return;
        }
        tbody.innerHTML = result.data.map(item => `
          <tr style="${item.is_read == 0 ? 'background: rgba(247, 147, 0, 0.05); font-weight: 600;' : ''}">
            <td>#${item.id}</td>
            <td>
              <span style="background: ${item.type === 'career' ? 'rgba(168, 85, 247, 0.2)' : (item.type === 'quote' ? 'rgba(59, 130, 246, 0.2)' : 'rgba(6, 182, 212, 0.2)')}; color: ${item.type === 'career' ? '#c084fc' : (item.type === 'quote' ? '#60a5fa' : '#22d3ee')}; border: 1px solid rgba(255,255,255,0.1); padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                ${escapeHtml(item.type)}
              </span>
            </td>
            <td><strong style="color:#ffffff;">${escapeHtml(item.message)}</strong></td>
            <td>
              <span style="color: ${item.is_read == 0 ? '#ef4444' : '#64748b'}; font-weight: 700;">
                ${item.is_read == 0 ? '● Unread' : 'Read'}
              </span>
            </td>
            <td><small style="color:#64748b;">${item.created_at}</small></td>
          </tr>
        `).join('');
      }
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; color:#ef4444; padding:24px;">Failed to load audit notifications.</td></tr>';
    }
  }

  // Load Manage Careers Table
  async function loadCareers() {
    const tbody = document.getElementById('tbodyCareers');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding: 24px; color:#94a3b8;"><i class="ri-loader-4-line ri-spin"></i> Loading career openings...</td></tr>';
    try {
      const res = await fetch('../api/admin.php?action=get_jobs');
      const result = await res.json();
      if (result.success && result.data) {
        if (result.data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding: 24px; color:#94a3b8;">No career openings published. Click "Publish New Opening" above.</td></tr>';
          return;
        }
        tbody.innerHTML = result.data.map(item => `
          <tr>
            <td><strong style="color:#10b981;">#${item.id}</strong></td>
            <td><strong style="color:#ffffff;">${escapeHtml(item.title)}</strong></td>
            <td><span style="background:rgba(247, 147, 0, 0.15); color:#f79300; border:1px solid rgba(247,147,0,0.3); padding:3px 10px; border-radius:12px; font-size:0.78rem; font-weight:700;">${escapeHtml(item.department)}</span></td>
            <td><div>${escapeHtml(item.type)}</div><small style="color:#94a3b8;">${escapeHtml(item.location)}</small></td>
            <td><div>${escapeHtml(item.experience)}</div><small style="color:#10b981; font-weight:700;">${escapeHtml(item.stipend || '—')}</small></td>
            <td style="max-width:200px; white-space:pre-wrap;"><small>${escapeHtml(item.requirements || '—')}</small></td>
            <td style="max-width:250px; white-space:pre-wrap;"><small>${escapeHtml(item.description || '—')}</small></td>
            <td>
              <button onclick="deleteJob(${item.id})" class="admin-btn-secondary" style="color: #ef4444; border-color: rgba(239, 68, 68, 0.3); padding: 6px 12px; font-size: 0.8rem;">
                <i class="ri-delete-bin-line"></i> Delete
              </button>
            </td>
          </tr>
        `).join('');
      }
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; color:#ef4444; padding:24px;">Failed to load careers.</td></tr>';
    }
  }

  // Global Actions
  window.markAllNotificationsRead = async function() {
    try {
      const res = await fetch('../api/admin.php?action=mark_notifications_read', { method: 'POST' });
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
    await fetch('../api/admin.php?action=logout');
    window.location.reload();
  };

  window.deleteJob = async function(id) {
    if (!confirm('Are you sure you want to delete this career opening? It will be removed from the website.')) return;
    try {
      const formData = new FormData();
      formData.append('id', id);
      const res = await fetch('../api/admin.php?action=delete_job', { method: 'POST', body: formData });
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
      const res = await fetch('../api/admin.php?action=change_password', {
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
            <select name="department" class="admin-control" style="padding-left:16px; background:#1e293b;" required>
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
            <select name="type" class="admin-control" style="padding-left:16px; background:#1e293b;" required>
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
            <select name="location" class="admin-control" style="padding-left:16px; background:#1e293b;" required>
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
      const res = await fetch('../api/admin.php?action=add_job', {
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
          <h3 id="adminModalTitle" style="font-size: 1.4rem; font-weight: 800; margin-bottom: 20px; color: #ffffff;"></h3>
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
