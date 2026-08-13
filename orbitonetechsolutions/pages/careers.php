<!-- Orbitone Tech Solutions - Careers Page -->
<?php
$db = getDB();
$stmt = $db->query("SELECT * FROM job_openings WHERE status = 'Active' ORDER BY id DESC");
$jobs = $stmt->fetchAll();

function getDeptIcon($dept) {
    $dept = strtolower(trim($dept));
    if (strpos($dept, 'engineer') !== false || strpos($dept, 'tech') !== false || strpos($dept, 'code') !== false) {
        return 'ri-terminal-box-line';
    }
    if (strpos($dept, 'ai') !== false || strpos($dept, 'data') !== false || strpos($dept, 'machine') !== false) {
        return 'ri-brain-line';
    }
    if (strpos($dept, 'marketing') !== false || strpos($dept, 'growth') !== false || strpos($dept, 'sales') !== false) {
        return 'ri-rocket-line';
    }
    if (strpos($dept, 'design') !== false || strpos($dept, 'ui') !== false || strpos($dept, 'creative') !== false) {
        return 'ri-palette-line';
    }
    return 'ri-briefcase-line';
}

function getDeptColors($dept) {
    $dept = strtolower(trim($dept));
    if (strpos($dept, 'engineer') !== false || strpos($dept, 'tech') !== false || strpos($dept, 'code') !== false) {
        return ['bg' => 'rgba(59, 130, 246, 0.08)', 'text' => '#1d4ed8', 'border' => 'rgba(59, 130, 246, 0.2)'];
    }
    if (strpos($dept, 'ai') !== false || strpos($dept, 'data') !== false || strpos($dept, 'machine') !== false) {
        return ['bg' => 'rgba(139, 92, 246, 0.08)', 'text' => '#6d28d9', 'border' => 'rgba(139, 92, 246, 0.2)'];
    }
    if (strpos($dept, 'marketing') !== false || strpos($dept, 'growth') !== false || strpos($dept, 'sales') !== false) {
        return ['bg' => 'rgba(217, 119, 6, 0.08)', 'text' => '#b45309', 'border' => 'rgba(217, 119, 6, 0.2)'];
    }
    if (strpos($dept, 'design') !== false || strpos($dept, 'ui') !== false || strpos($dept, 'creative') !== false) {
        return ['bg' => 'rgba(236, 72, 153, 0.08)', 'text' => '#be185d', 'border' => 'rgba(236, 72, 153, 0.2)'];
    }
    return ['bg' => 'rgba(100, 116, 139, 0.08)', 'text' => '#475569', 'border' => 'rgba(100, 116, 139, 0.2)'];
}
?>

<section class="section">
  <div class="container">
    <div class="section-title">
      <span class="badge">Join Our Team</span>
      <h2>Build the Future <span class="gradient-text">With Us</span></h2>
      <p>We're looking for curious minds, problem solvers and technology enthusiasts who want to build meaningful digital solutions.</p>
    </div>

    <!-- Company Culture & Perks Grid -->
    <div class="feature-grid" style="margin-bottom: 4rem;">
      <div class="feature-card">
        <h4 class="feature-card-heading">
          <svg class="feature-svg-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13 2L3 14H12L11 22L21 10H12L13 2Z" stroke="var(--navy-dark)" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="12" cy="12" r="1.5" fill="var(--gold-primary)"/>
          </svg>
          Cutting-Edge Tech
        </h4>
        <p>Work with LLMs, high-performance web frameworks, and modern cloud infrastructure.</p>
      </div>
      <div class="feature-card">
        <h4 class="feature-card-heading">
          <svg class="feature-svg-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="9" stroke="var(--navy-dark)" stroke-width="1.75"/>
            <path d="M3.6 9H20.4M3.6 15H20.4M12 3C14.5 6 15.5 9 15.5 12C15.5 15 14.5 18 12 21C9.5 18 8.5 15 8.5 12C8.5 9 9.5 6 12 3Z" stroke="var(--navy-dark)" stroke-width="1.5"/>
            <circle cx="12" cy="12" r="1.5" fill="var(--gold-primary)"/>
          </svg>
          Flexible Work Culture
        </h4>
        <p>Remote and hybrid workplace options designed around autonomy and productivity.</p>
      </div>
      <div class="feature-card">
        <h4 class="feature-card-heading">
          <svg class="feature-svg-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 20H21" stroke="var(--navy-dark)" stroke-width="1.75" stroke-linecap="round"/>
            <path d="M5 16L10 11L14 14L20 6" stroke="var(--navy-dark)" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
            <polyline points="15 6 20 6 20 11" stroke="var(--navy-dark)" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="20" cy="6" r="2" fill="var(--gold-primary)"/>
          </svg>
          Continuous Mentorship
        </h4>
        <p>Generous learning stipends, conference passes, and dedicated time for innovation projects.</p>
      </div>
    </div>

    <!-- Open Positions List -->
    <div class="section-title" style="margin-bottom: 2rem;">
      <h2>Open Positions</h2>
      <p>Explore current career opportunities across engineering, AI, analytics, and marketing.</p>
    </div>

    <div class="job-list">
      <?php foreach ($jobs as $j): 
        $colors = getDeptColors($j['department']);
      ?>
        <div class="job-card" style="align-items: flex-start;">
          <div style="display: flex; gap: 1.5rem; align-items: flex-start; flex: 1; flex-wrap: wrap;">
            <div style="background: <?= $colors['bg'] ?>; color: <?= $colors['text'] ?>; border: 1px solid <?= $colors['border'] ?>; width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; flex-shrink: 0; margin-top: 4px;">
              <i class="<?= getDeptIcon($j['department']) ?>"></i>
            </div>
            
            <div style="flex: 1; min-width: 250px;">
              <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.45rem; flex-wrap: wrap;">
                <span style="background: <?= $colors['bg'] ?>; color: <?= $colors['text'] ?>; border: 1px solid <?= $colors['border'] ?>; font-size: 0.72rem; padding: 3px 10px; font-weight: 700; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.05em;"><?= htmlspecialchars($j['department']) ?></span>
                <span style="font-size: 0.85rem; color: var(--text-dim);"><i class="ri-map-pin-line"></i> <?= htmlspecialchars($j['location']) ?> (<?= htmlspecialchars($j['type']) ?>)</span>
              </div>
              
              <h3 style="font-size: 1.35rem; color: var(--navy-dark); font-weight: 800; margin: 0 0 0.5rem 0;"><?= htmlspecialchars($j['title']) ?></h3>
              
              <div class="job-tags" style="margin-bottom: 0.75rem;">
                <span><i class="ri-briefcase-line"></i> Exp: <?= htmlspecialchars($j['experience']) ?></span>
                <?php if (!empty($j['stipend'])): ?>
                  <span>•</span>
                  <span style="color: var(--emerald); font-weight: 700;"><i class="ri-money-dollar-circle-line"></i> Stipend: <?= htmlspecialchars($j['stipend']) ?></span>
                <?php endif; ?>
              </div>
              
              <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem; max-width: 750px; line-height: 1.6;">
                <?= htmlspecialchars($j['description']) ?>
              </p>
              
              <?php if (!empty($j['requirements'])): ?>
                <div style="margin-top: 1rem; background: rgba(11, 25, 44, 0.02); padding: 1rem; border-radius: 8px; border: 1px solid rgba(11, 25, 44, 0.04);">
                  <strong style="font-size: 0.85rem; color: var(--navy-dark); display: flex; align-items: center; gap: 4px;"><i class="ri-checkbox-circle-line" style="color: var(--gold-dark);"></i> Key Requirements:</strong>
                  <ul style="margin: 0.35rem 0 0 0; padding-left: 1.25rem; font-size: 0.88rem; color: var(--text-muted); line-height: 1.6;">
                    <?php foreach (explode("\n", trim($j['requirements'])) as $req): ?>
                      <?php if (trim($req) !== ''): ?>
                        <li style="margin-bottom: 2px;"><?= htmlspecialchars(trim($req)) ?></li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <button class="btn btn-primary btn-sm" style="flex-shrink: 0; align-self: center; margin-top: 1rem;" onclick="openJobModal(<?= $j['id'] ?>, '<?= htmlspecialchars(addslashes($j['title'])) ?>')">
            <span>Apply Now</span>
            <i class="ri-arrow-right-line"></i>
          </button>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<script>
  function openJobModal(jobId, jobTitle) {
    showModal(`Apply for ${jobTitle}`, `
      <form id="jobAppForm" onsubmit="handleJobSubmit(event)">
        <input type="hidden" name="job_id" value="${jobId}">
        <input type="hidden" name="role" value="${jobTitle}">

        <div class="form-group">
          <label class="form-label">Full Name *</label>
          <input type="text" name="applicant_name" class="form-control" required placeholder="Jane Doe">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
          <div class="form-group">
            <label class="form-label">Work / Personal Email *</label>
            <input type="email" name="email" class="form-control" required placeholder="jane@example.com">
          </div>

          <div class="form-group">
            <label class="form-label">Phone Number</label>
            <input type="tel" name="phone" class="form-control" placeholder="+91 9876543210">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Years of Relevant Experience</label>
          <input type="text" name="experience" class="form-control" placeholder="e.g. 3+ years in React & Node.js">
        </div>

        <div class="form-group">
          <label class="form-label">LinkedIn Profile / Portfolio / Cover Note</label>
          <textarea name="resume_note" class="form-control" placeholder="Paste link to your LinkedIn, GitHub, or briefly introduce yourself..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-full">
          <span>Submit Application</span>
          <i class="ri-send-plane-fill"></i>
        </button>
      </form>
    `);
  }

  async function handleJobSubmit(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) submitBtn.disabled = true;

    try {
      const res = await fetch('api/career.php', {
        method: 'POST',
        body: formData
      });
      const result = await res.json();

      if (result.success) {
        showModal('Application Submitted!', `
          <div style="text-align: center; padding: 1.5rem 0;">
            <i class="ri-checkbox-circle-fill" style="font-size: 4rem; color: #10b981;"></i>
            <h3 style="margin: 1rem 0; font-size: 1.4rem;">Application Received!</h3>
            <p style="color: #475569;">
              Thank you for applying to Orbitone Tech Solutions. Our talent acquisition team will review your qualifications and reach out shortly.
            </p>
          </div>
        `);
      } else {
        alert('Error: ' + (result.message || 'Could not submit application'));
      }
    } catch (err) {
      alert('Server submission error. Please try again.');
    } finally {
      if (submitBtn) submitBtn.disabled = false;
    }
  }
</script>

