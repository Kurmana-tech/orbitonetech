/* Orbitone Tech Solutions - Admin Panel JavaScript */

document.addEventListener('DOMContentLoaded', () => {
  const loginForm = document.getElementById('adminLoginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(loginForm);
      try {
        const res = await fetch('../api/admin.php?action=login', { method: 'POST', body: formData });
        const result = await res.json();
        if (result.success) {
          window.location.reload();
        } else {
          alert(result.message || 'Login failed');
        }
      } catch (err) {
        alert('Server communication error.');
      }
    });
  }

  // Admin Tab Switcher
  const navItems = document.querySelectorAll('.admin-nav-item');
  const sections = document.querySelectorAll('.admin-section');

  navItems.forEach(item => {
    item.addEventListener('click', () => {
      navItems.forEach(n => n.classList.remove('active'));
      item.classList.add('active');

      const target = item.dataset.target;
      sections.forEach(s => {
        s.style.display = s.id === target ? 'block' : 'none';
      });

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
        if (document.getElementById('cntLeads')) document.getElementById('cntLeads').textContent = result.counts.leads;
        if (document.getElementById('cntQuotes')) document.getElementById('cntQuotes').textContent = result.counts.quotes;
        if (document.getElementById('cntApps')) document.getElementById('cntApps').textContent = result.counts.applications;
        if (document.getElementById('cntProjects')) document.getElementById('cntProjects').textContent = result.counts.projects;
        
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

  async function loadLeads() {
    const tbody = document.getElementById('tbodyLeads');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="7">Loading leads...</td></tr>';
    try {
      const res = await fetch('../api/admin.php?action=get_leads');
      const result = await res.json();
      if (result.success && result.data) {
        if (result.data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="7">No contact leads received yet.</td></tr>';
          return;
        }
        tbody.innerHTML = result.data.map(item => `
          <tr>
            <td>#${item.id}</td>
            <td><strong>${escapeHtml(item.name)}</strong></td>
            <td>${escapeHtml(item.email)}<br><small>${escapeHtml(item.phone || '')}</small></td>
            <td>${escapeHtml(item.company || '—')}</td>
            <td><span class="badge">${escapeHtml(item.service)}</span></td>
            <td>${escapeHtml(item.message)}</td>
            <td><small>${item.created_at}</small></td>
          </tr>
        `).join('');
      }
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="7">Error loading data.</td></tr>';
    }
  }

  async function loadQuotes() {
    const tbody = document.getElementById('tbodyQuotes');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="7">Loading quotes...</td></tr>';
    try {
      const res = await fetch('../api/admin.php?action=get_quotes');
      const result = await res.json();
      if (result.success && result.data) {
        if (result.data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="7">No quote requests submitted yet.</td></tr>';
          return;
        }
        tbody.innerHTML = result.data.map(item => `
          <tr>
            <td><strong style="color:var(--cyan);">${escapeHtml(item.reference_id)}</strong></td>
            <td><strong>${escapeHtml(item.contact_name)}</strong><br><small>${escapeHtml(item.contact_email)}</small></td>
            <td>${escapeHtml(item.company || '—')}</td>
            <td>${escapeHtml(item.services)}</td>
            <td><strong style="color:var(--emerald);">${escapeHtml(item.budget)}</strong></td>
            <td>${escapeHtml(item.requirements || '—')}</td>
            <td><small>${item.created_at}</small></td>
          </tr>
        `).join('');
      }
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="7">Error loading data.</td></tr>';
    }
  }

  async function loadApplications() {
    const tbody = document.getElementById('tbodyApps');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="6">Loading applications...</td></tr>';
    try {
      const res = await fetch('../api/admin.php?action=get_applications');
      const result = await res.json();
      if (result.success && result.data) {
        if (result.data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="6">No job applications submitted yet.</td></tr>';
          return;
        }
        tbody.innerHTML = result.data.map(item => `
          <tr>
            <td>#${item.id}</td>
            <td><strong style="color:var(--primary);">${escapeHtml(item.role)}</strong></td>
            <td><strong>${escapeHtml(item.applicant_name)}</strong><br><small>${escapeHtml(item.email)}</small></td>
            <td>${escapeHtml(item.experience || 'N/A')}</td>
            <td>${escapeHtml(item.resume_note || '—')}</td>
            <td><small>${item.created_at}</small></td>
          </tr>
        `).join('');
      }
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="6">Error loading applications.</td></tr>';
    }
  }

  async function loadNotifications() {
    const tbody = document.getElementById('tbodyNotifs');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="5">Loading notifications...</td></tr>';
    try {
      const res = await fetch('../api/admin.php?action=get_notifications');
      const result = await res.json();
      if (result.success && result.data) {
        if (result.data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="5">No notifications received yet.</td></tr>';
          return;
        }
        tbody.innerHTML = result.data.map(item => `
          <tr style="${item.is_read == 0 ? 'background: rgba(45, 140, 255, 0.04); font-weight: 500;' : ''}">
            <td>#${item.id}</td>
            <td>
              <span class="badge" style="background: ${item.type === 'career' ? 'var(--purple, #a855f7)' : (item.type === 'quote' ? 'var(--primary, #3b82f6)' : 'var(--cyan, #06b6d4)')}; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: bold; text-transform: uppercase;">
                ${escapeHtml(item.type)}
              </span>
            </td>
            <td><strong>${escapeHtml(item.message)}</strong></td>
            <td>
              <span style="color: ${item.is_read == 0 ? '#ef4444' : 'var(--text-muted, #64748b)'}; font-weight: bold;">
                ${item.is_read == 0 ? 'Unread' : 'Read'}
              </span>
            </td>
            <td><small>${item.created_at}</small></td>
          </tr>
        `).join('');
      }
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="5">Error loading notifications.</td></tr>';
    }
  }

  window.markAllNotificationsRead = async function() {
    try {
      const res = await fetch('../api/admin.php?action=mark_notifications_read', { method: 'POST' });
      const result = await res.json();
      if (result.success) {
        loadNotifications();
        loadOverview();
      }
    } catch (e) {
      alert('Error clearing notifications.');
    }
  };

  window.logoutAdmin = async function() {
    await fetch('../api/admin.php?action=logout');
    window.location.reload();
  };

  // Careers management functions
  async function loadCareers() {
    const tbody = document.getElementById('tbodyCareers');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="8">Loading careers...</td></tr>';
    try {
      const res = await fetch('../api/admin.php?action=get_jobs');
      const result = await res.json();
      if (result.success && result.data) {
        if (result.data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="8">No careers added yet.</td></tr>';
          return;
        }
        tbody.innerHTML = result.data.map(item => `
          <tr>
            <td>#${item.id}</td>
            <td><strong>${escapeHtml(item.title)}</strong></td>
            <td><span class="badge" style="background:var(--primary); color:white; padding:3px 8px; border-radius:4px; font-weight:bold;">${escapeHtml(item.department)}</span></td>
            <td>${escapeHtml(item.type)}<br><small>${escapeHtml(item.location)}</small></td>
            <td>${escapeHtml(item.experience)}<br><small style="color:var(--emerald); font-weight:bold;">${escapeHtml(item.stipend || '—')}</small></td>
            <td style="max-width: 200px; white-space: pre-wrap;"><small>${escapeHtml(item.requirements || '—')}</small></td>
            <td style="max-width: 250px; white-space: pre-wrap;"><small>${escapeHtml(item.description || '—')}</small></td>
            <td>
              <button onclick="deleteJob(${item.id})" class="btn btn-secondary btn-sm" style="color: #ef4444; border-color: #fca5a5; padding: 4px 8px; font-size: 0.8rem;">
                <i class="ri-delete-bin-line"></i> Delete
              </button>
            </td>
          </tr>
        `).join('');
      }
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="8">Error loading careers.</td></tr>';
    }
  }

  window.deleteJob = async function(id) {
    if (!confirm('Are you sure you want to delete this career opening?')) return;
    try {
      const formData = new FormData();
      formData.append('id', id);
      const res = await fetch('../api/admin.php?action=delete_job', {
        method: 'POST',
        body: formData
      });
      const result = await res.json();
      if (result.success) {
        loadCareers();
        loadOverview();
      } else {
        alert(result.message || 'Failed to delete career opening');
      }
    } catch (e) {
      alert('Network error.');
    }
  };

  window.openAddJobModal = function() {
    showAdminModal('Add New Career Opening', `
      <form id="addJobForm" onsubmit="submitAddJobForm(event)">
        <div class="form-group">
          <label class="form-label">Job Title / Role Name *</label>
          <input type="text" name="title" class="form-control" placeholder="e.g. Senior Frontend Engineer" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
          <div class="form-group">
            <label class="form-label">Department *</label>
            <select name="department" class="form-control" required>
              <option value="Engineering">Engineering</option>
              <option value="AI & Data">AI & Data</option>
              <option value="Marketing">Marketing</option>
              <option value="Design">Design</option>
              <option value="Sales">Sales</option>
              <option value="Operations">Operations</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Job Type *</label>
            <select name="type" class="form-control" required>
              <option value="Full-time">Full-time</option>
              <option value="Internship">Internship</option>
              <option value="Part-time">Part-time</option>
              <option value="Contract">Contract</option>
            </select>
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
          <div class="form-group">
            <label class="form-label">Location *</label>
            <select name="location" class="form-control" required>
              <option value="Remote">Remote</option>
              <option value="Hybrid">Hybrid</option>
              <option value="On-site">On-site</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Experience Required *</label>
            <input type="text" name="experience" class="form-control" placeholder="e.g. 2+ Years, Fresher" required>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Stipend / Salary Compensation</label>
          <input type="text" name="stipend" class="form-control" placeholder="e.g. 5k - 10k/month, 8 LPA">
        </div>

        <div class="form-group">
          <label class="form-label">Other Requirements / Key Skills</label>
          <textarea name="requirements" class="form-control" rows="3" placeholder="Paste requirements, key skills, tools needed (one per line is fine)..."></textarea>
        </div>

        <div class="form-group">
          <label class="form-label">Role Description *</label>
          <textarea name="description" class="form-control" rows="3" placeholder="Provide a brief summary of the role and responsibilities..." required></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-full" style="margin-top: 1rem;">
          <span>Publish Career Role</span>
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
        alert(result.message || 'Failed to add job opening');
      }
    } catch (err) {
      alert('Server communication error.');
    } finally {
      if (submitBtn) submitBtn.disabled = false;
    }
  };

  // Modal helpers
  window.showAdminModal = function (title, htmlBody) {
    let overlay = document.getElementById('adminModalOverlay');
    if (!overlay) {
      overlay = document.createElement('div');
      overlay.id = 'adminModalOverlay';
      overlay.className = 'modal-overlay';
      overlay.innerHTML = `
        <div class="modal-box" style="max-width: 600px; max-height: 95vh;">
          <button class="modal-close" onclick="closeAdminModal()">&times;</button>
          <h3 id="adminModalTitle" style="font-size: 1.4rem; margin-bottom: 1.25rem; color: #0b192c;"></h3>
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
