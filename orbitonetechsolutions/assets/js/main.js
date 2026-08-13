/* Orbitone Tech Solutions - Main Client Interactive Script */

document.addEventListener('DOMContentLoaded', () => {

  /* -------------------------------------------------------------
   * 1. Mobile Menu Drawer Toggle
   * ------------------------------------------------------------- */
  const mobileToggle = document.getElementById('mobileToggle');
  const mobileNav = document.getElementById('mobileNav');

  if (mobileToggle && mobileNav) {
    mobileToggle.addEventListener('click', () => {
      mobileNav.classList.toggle('open');
      const icon = mobileToggle.querySelector('i');
      if (icon) {
        icon.className = mobileNav.classList.contains('open') ? 'ri-close-line' : 'ri-menu-line';
      }
    });
  }

  /* -------------------------------------------------------------
   * 2. Interactive Data Analytics Dashboard Demo
   * ------------------------------------------------------------- */
  const dashTabs = document.querySelectorAll('.dash-tab');
  const barCols = document.querySelectorAll('.bar-col');
  const revVal = document.getElementById('dashValRevenue');
  const custVal = document.getElementById('dashValCustomers');
  const growthVal = document.getElementById('dashValGrowth');
  const convVal = document.getElementById('dashValConv');

  const dashDatasets = {
    revenue: {
      revenue: '$1.48M',
      customers: '14,250',
      growth: '+34.2%',
      conv: '4.85%',
      bars: [40, 65, 80, 55, 90, 75, 100]
    },
    customers: {
      revenue: '$920K',
      customers: '28,900',
      growth: '+52.1%',
      conv: '6.12%',
      bars: [60, 70, 85, 90, 65, 95, 88]
    },
    conversion: {
      revenue: '$2.10M',
      customers: '18,400',
      growth: '+28.4%',
      conv: '8.40%',
      bars: [30, 50, 75, 85, 92, 98, 95]
    },
    performance: {
      revenue: '$3.5M',
      customers: '42,100',
      growth: '+64.0%',
      conv: '9.95%',
      bars: [50, 75, 90, 95, 100, 98, 99]
    }
  };

  dashTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      dashTabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');

      const metric = tab.dataset.metric;
      const data = dashDatasets[metric] || dashDatasets.revenue;

      if (revVal) revVal.textContent = data.revenue;
      if (custVal) custVal.textContent = data.customers;
      if (growthVal) growthVal.textContent = data.growth;
      if (convVal) convVal.textContent = data.conv;

      barCols.forEach((bar, idx) => {
        const val = data.bars[idx] || 50;
        bar.style.height = val + '%';
        bar.setAttribute('data-value', val + '%');
      });
    });
  });

  /* -------------------------------------------------------------
   * 3. Interactive Marketing Funnel Stages
   * ------------------------------------------------------------- */
  const funnelSteps = document.querySelectorAll('.funnel-step');
  const funnelDetailBox = document.getElementById('funnelDetailText');

  const funnelDetails = {
    reach: 'Stage 1: Reach — Driving targeted impressions through high-intent SEO, Google Search Ads, and LinkedIn campaign awareness.',
    engagement: 'Stage 2: Engagement — Capturing interest with high-converting landing pages, interactive product demos, and ROI calculators.',
    leads: 'Stage 3: Leads — Converting visitors into qualified inbound sales inquiries via personalized multi-step forms and gated whitepapers.',
    conversion: 'Stage 4: Conversion — Closing high-value contracts through automated lead scoring, CRM integration, and retargeting ads.',
    retention: 'Stage 5: Retention — Driving repeat customer lifetime value with automated onboarding, referral campaigns, and analytics tracking.'
  };

  funnelSteps.forEach(step => {
    step.addEventListener('click', () => {
      funnelSteps.forEach(s => s.classList.remove('active'));
      step.classList.add('active');
      const stage = step.dataset.stage;
      if (funnelDetailBox && funnelDetails[stage]) {
        funnelDetailBox.textContent = funnelDetails[stage];
      }
    });
  });

  /* -------------------------------------------------------------
   * 4. Multi-Step Interactive Quote Wizard
   * ------------------------------------------------------------- */
  const wizardForm = document.getElementById('quoteWizardForm');
  if (wizardForm) {
    let currentStep = 1;
    const totalSteps = 4;

    const nextBtn = document.getElementById('wizardNext');
    const prevBtn = document.getElementById('wizardPrev');
    const submitBtn = document.getElementById('wizardSubmit');

    function updateWizard() {
      document.querySelectorAll('.step-pane').forEach((pane, idx) => {
        pane.classList.toggle('active', idx + 1 === currentStep);
      });

      document.querySelectorAll('.step-indicator').forEach((ind, idx) => {
        ind.classList.remove('active', 'completed');
        if (idx + 1 === currentStep) ind.classList.add('active');
        if (idx + 1 < currentStep) ind.classList.add('completed');
      });

      const progressBar = document.getElementById('wizardProgressBar');
      if (progressBar) {
        progressBar.style.width = `${(currentStep / totalSteps) * 100}%`;
      }

      if (prevBtn) prevBtn.style.display = currentStep === 1 ? 'none' : 'inline-flex';
      if (nextBtn) nextBtn.style.display = currentStep === totalSteps ? 'none' : 'inline-flex';
      if (submitBtn) submitBtn.style.display = currentStep === totalSteps ? 'inline-flex' : 'none';

      // Scroll smoothly to wizard top on mobile
      if (window.innerWidth <= 768) {
        wizardForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        // Validation for step 1: must pick at least 1 service
        if (currentStep === 1) {
          const checked = wizardForm.querySelectorAll('input[name="services[]"]:checked');
          if (checked.length === 0) {
            alert('Please select at least one capability for your project.');
            return;
          }
        }
        if (currentStep < totalSteps) {
          currentStep++;
          updateWizard();
        }
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        if (currentStep > 1) {
          currentStep--;
          updateWizard();
        }
      });
    }

    // Step indicators jump
    document.querySelectorAll('.step-indicator').forEach(ind => {
      ind.addEventListener('click', () => {
        const targetStep = parseInt(ind.dataset.step, 10);
        if (targetStep && targetStep <= currentStep) {
          currentStep = targetStep;
          updateWizard();
        }
      });
    });

    // 1. Checklist Cards (Step 1)
    const checklistCards = document.querySelectorAll('.checklist-card');
    checklistCards.forEach(card => {
      const chk = card.querySelector('.checklist-checkbox');
      if (!chk) return;

      function toggleCheck() {
        chk.checked = !chk.checked;
        card.classList.toggle('selected', chk.checked);
        card.setAttribute('aria-checked', chk.checked ? 'true' : 'false');
        
        card.classList.add('pulse-select');
        setTimeout(() => card.classList.remove('pulse-select'), 300);
      }

      card.addEventListener('click', (e) => {
        toggleCheck();
      });

      card.addEventListener('keydown', (e) => {
        if (e.key === ' ' || e.key === 'Enter') {
          e.preventDefault();
          toggleCheck();
        }
      });
    });

    // 2. Timeline Cards (Step 2)
    const timelineCards = document.querySelectorAll('.timeline-card');
    timelineCards.forEach(card => {
      const radio = card.querySelector('input[type="radio"]');
      if (!radio) return;

      function selectTimeline() {
        timelineCards.forEach(c => {
          c.classList.remove('selected');
          c.setAttribute('aria-checked', 'false');
        });
        radio.checked = true;
        card.classList.add('selected');
        card.setAttribute('aria-checked', 'true');
        
        card.classList.add('pulse-select');
        setTimeout(() => card.classList.remove('pulse-select'), 300);
      }

      card.addEventListener('click', selectTimeline);
      card.addEventListener('keydown', (e) => {
        if (e.key === ' ' || e.key === 'Enter') {
          e.preventDefault();
          selectTimeline();
        }
      });
    });

    // 3. Quick Tag Suggestions (Step 2)
    document.querySelectorAll('.quick-tag-chip').forEach(chip => {
      chip.addEventListener('click', () => {
        const tag = chip.dataset.tag;
        const textarea = document.getElementById('requirementsText');
        if (textarea && tag) {
          const currentVal = textarea.value.trim();
          if (currentVal.length > 0) {
            textarea.value = currentVal + (currentVal.endsWith('.') ? ' ' : '. ') + tag;
          } else {
            textarea.value = tag;
          }
          textarea.focus();

          chip.classList.add('active-chip');
          setTimeout(() => chip.classList.remove('active-chip'), 400);
        }
      });
    });

    // 4. Budget Range Cards (Step 3)
    const budgetCards = document.querySelectorAll('.budget-card');
    budgetCards.forEach(card => {
      const radio = card.querySelector('input[type="radio"]');
      if (!radio) return;

      function selectBudget() {
        budgetCards.forEach(c => {
          c.classList.remove('selected');
          c.setAttribute('aria-checked', 'false');
        });
        radio.checked = true;
        card.classList.add('selected');
        card.setAttribute('aria-checked', 'true');
        
        card.classList.add('pulse-select');
        setTimeout(() => card.classList.remove('pulse-select'), 300);
      }

      card.addEventListener('click', selectBudget);
      card.addEventListener('keydown', (e) => {
        if (e.key === ' ' || e.key === 'Enter') {
          e.preventDefault();
          selectBudget();
        }
      });
    });

    // 5. Holographic Preloader & Executive Success Submission Handler
    wizardForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(wizardForm);
      const submitBtn = document.getElementById('wizardSubmit');
      if (submitBtn) submitBtn.disabled = true;

      // Show Holographic Preloader Overlay
      let preloaderOverlay = document.getElementById('quotePreloaderOverlay');
      if (!preloaderOverlay) {
        preloaderOverlay = document.createElement('div');
        preloaderOverlay.id = 'quotePreloaderOverlay';
        preloaderOverlay.className = 'quote-preloader-overlay';
        document.body.appendChild(preloaderOverlay);
      }

      // Render Dynamic Holographic Synthesis Console
      preloaderOverlay.innerHTML = `
        <div class="quote-preloader-card">
          <div class="preloader-top-bar"></div>

          <!-- Animated Holographic Radar -->
          <div class="preloader-radar-system">
            <div class="radar-outer-ring"></div>
            <div class="radar-mid-ring"></div>
            <div class="radar-scan-beam"></div>
            <div class="radar-particle particle-1"></div>
            <div class="radar-particle particle-2"></div>
            <div class="radar-particle particle-3"></div>
            <div class="radar-core-orb">
              <img src="assets/images/orbitone-nucleus.png" alt="Orbitone" class="radar-core-logo">
            </div>
          </div>

          <!-- Preloader Header & Dynamic Step Status -->
          <div class="preloader-badge">
            <span class="badge-pulse-dot"></span>
            SYNTHESIZING ARCHITECTURE
          </div>
          <h3 class="preloader-heading">Formulating Project Dossier</h3>
          <div class="preloader-status-sub" id="preloaderSub">Validating technology stack & scope...</div>

          <!-- Live Progress Meter Bar -->
          <div class="preloader-meter-wrap">
            <div class="meter-bar-container">
              <div class="meter-bar-fill" id="preloaderFill" style="width: 20%;"></div>
            </div>
            <div class="meter-meta">
              <span class="meter-label">Telemetry Pipeline</span>
              <span class="meter-percent" id="preloaderPercent">20%</span>
            </div>
          </div>

          <!-- Telemetry Checklist Steps -->
          <div class="preloader-telemetry-list">
            <div class="telemetry-item active" id="teleStep1">
              <div class="tele-icon"><i class="ri-loader-4-line spin-fast"></i></div>
              <div class="tele-text">Verifying service capabilities & deliverables</div>
            </div>
            <div class="telemetry-item" id="teleStep2">
              <div class="tele-icon"><i class="ri-cpu-line"></i></div>
              <div class="tele-text">Synthesizing cloud architecture & roadmap</div>
            </div>
            <div class="telemetry-item" id="teleStep3">
              <div class="tele-icon"><i class="ri-shield-keyhole-line"></i></div>
              <div class="tele-text">Encrypting dossier for lead architect</div>
            </div>
          </div>
        </div>
      `;
      preloaderOverlay.classList.add('open');

      const fillEl = document.getElementById('preloaderFill');
      const percentEl = document.getElementById('preloaderPercent');
      const subEl = document.getElementById('preloaderSub');
      const step1 = document.getElementById('teleStep1');
      const step2 = document.getElementById('teleStep2');
      const step3 = document.getElementById('teleStep3');

      // Live Telemetry Progression Timeline
      let progress = 20;
      const progressTimer = setInterval(() => {
        if (progress < 95) {
          progress += Math.floor(Math.random() * 8) + 4;
          if (progress > 95) progress = 95;
          if (fillEl) fillEl.style.width = progress + '%';
          if (percentEl) percentEl.textContent = progress + '%';

          if (progress > 45 && step1 && step2) {
            step1.className = 'telemetry-item completed';
            step1.querySelector('.tele-icon').innerHTML = '<i class="ri-check-line"></i>';
            step2.className = 'telemetry-item active';
            step2.querySelector('.tele-icon').innerHTML = '<i class="ri-loader-4-line spin-fast"></i>';
            if (subEl) subEl.textContent = 'Generating cloud topology & milestone roadmap...';
          }
          if (progress > 75 && step2 && step3) {
            step2.className = 'telemetry-item completed';
            step2.querySelector('.tele-icon').innerHTML = '<i class="ri-check-line"></i>';
            step3.className = 'telemetry-item active';
            step3.querySelector('.tele-icon').innerHTML = '<i class="ri-loader-4-line spin-fast"></i>';
            if (subEl) subEl.textContent = 'Routing dossier to solutions engineering...';
          }
        }
      }, 180);

      const startTime = Date.now();

      try {
        const res = await fetch('api/quote.php', {
          method: 'POST',
          body: formData
        });
        const result = await res.json();

        // Allow 2.5s for seamless animations
        const elapsed = Date.now() - startTime;
        const delay = Math.max(0, 2500 - elapsed);

        setTimeout(() => {
          clearInterval(progressTimer);

          if (result.success) {
            if (fillEl) fillEl.style.width = '100%';
            if (percentEl) percentEl.textContent = '100%';

            setTimeout(() => {
              const card = preloaderOverlay.querySelector('.quote-preloader-card');
              card.className = 'quote-preloader-card success-card-mode';
              card.innerHTML = `
                <div class="preloader-top-bar success-bar"></div>
                <button type="button" class="modal-close-x" onclick="document.getElementById('quotePreloaderOverlay').classList.remove('open');" aria-label="Close">&times;</button>

                <!-- Celebratory Animated Holographic Success Badge -->
                <div class="success-badge-system">
                  <div class="success-energy-ring ring-1"></div>
                  <div class="success-energy-ring ring-2"></div>
                  <div class="success-icon-core">
                    <svg class="success-check-svg" viewBox="0 0 52 52">
                      <circle class="check-circle" cx="26" cy="26" r="23" fill="none"/>
                      <path class="check-path" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                    </svg>
                  </div>
                </div>

                <!-- Header -->
                <div class="success-tag-pill">
                  <i class="ri-shield-check-fill"></i>
                  DOSSIER DISPATCHED SECURELY
                </div>
                <h2 class="success-headline">Project Scope Confirmed!</h2>
                <p class="success-summary">
                  Thank you! Your project requirements have been encrypted and routed directly to our Solutions Architecture team.
                </p>

                <!-- High-Tech Vault Reference Box with Animated Copy -->
                <div class="success-vault-card">
                  <div class="vault-header">
                    <span class="vault-label"><i class="ri-key-2-fill"></i> OFFICIAL TRACKING ID</span>
                    <span class="vault-status">STATUS: ENCRYPTED &amp; QUEUED</span>
                  </div>
                  <div class="vault-code-row">
                    <div class="vault-code-wrap">
                      <span class="vault-code-id" id="vaultRefCode">${result.reference_id}</span>
                    </div>
                    <button type="button" class="btn-vault-copy" id="btnVaultCopy" onclick="
                      navigator.clipboard.writeText('${result.reference_id}');
                      this.innerHTML = '<i class=\\'ri-check-line\\'></i><span>Copied!</span>';
                      this.style.background = '#10b981';
                      this.style.color = '#ffffff';
                      setTimeout(() => {
                        this.innerHTML = '<i class=\\'ri-file-copy-line\\'></i><span>Copy ID</span>';
                        this.style.background = '';
                        this.style.color = '';
                      }, 2000);
                    ">
                      <i class="ri-file-copy-line"></i>
                      <span>Copy ID</span>
                    </button>
                  </div>
                </div>

                <!-- 3-Step Interactive "What Happens Next" Roadmap -->
                <div class="success-timeline-card">
                  <div class="timeline-header">
                    <i class="ri-flashlight-fill"></i>
                    <span>What Happens Next?</span>
                  </div>
                  <div class="success-steps-grid">
                    <div class="success-step-item">
                      <div class="step-badge">1</div>
                      <div class="step-content">
                        <div class="step-time">Within 2 Hours</div>
                        <div class="step-desc">Architectural audit &amp; tech stack feasibility review</div>
                      </div>
                    </div>
                    <div class="success-step-item">
                      <div class="step-badge">2</div>
                      <div class="step-content">
                        <div class="step-time">Within 24 Hours</div>
                        <div class="step-desc">Custom roadmap breakdown &amp; milestone pricing delivery</div>
                      </div>
                    </div>
                    <div class="success-step-item">
                      <div class="step-badge">3</div>
                      <div class="step-content">
                        <div class="step-time">Priority Discovery</div>
                        <div class="step-desc">Optional 30-min strategy call with our principal engineer</div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Action CTAs -->
                <div class="success-actions-row">
                  <a href="?page=projects" class="btn btn-secondary btn-full">
                    <i class="ri-folder-shield-2-line"></i> View Portfolio
                  </a>
                  <button type="button" class="btn btn-primary btn-full btn-glow" onclick="document.getElementById('quotePreloaderOverlay').classList.remove('open');">
                    <i class="ri-check-double-line"></i> Done
                  </button>
                </div>
              `;

              wizardForm.reset();
              currentStep = 1;
              updateWizard();
              document.querySelectorAll('.checklist-card, .timeline-card, .budget-card').forEach(c => {
                c.classList.remove('selected');
                c.setAttribute('aria-checked', 'false');
              });
            }, 300);

          } else {
            preloaderOverlay.classList.remove('open');
            alert('Error: ' + (result.message || 'Submission failed'));
          }
        }, delay);

      } catch (err) {
        clearInterval(progressTimer);
        preloaderOverlay.classList.remove('open');
        alert('Server communication error. Please try again.');
      } finally {
        if (submitBtn) submitBtn.disabled = false;
      }
    });
  }

  /* -------------------------------------------------------------
   * 5. AJAX Contact Form Submission
   * ------------------------------------------------------------- */
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(contactForm);
      const btn = contactForm.querySelector('button[type="submit"]');
      if (btn) btn.disabled = true;

      try {
        const res = await fetch('api/contact.php', {
          method: 'POST',
          body: formData
        });
        const result = await res.json();

        if (result.success) {
          showModal('Message Received', `
            <div style="text-align: center; padding: 1rem 0;">
              <i class="ri-mail-send-fill" style="font-size: 3.5rem; color: #d97706;"></i>
              <h3 style="margin-top: 1rem;">We'll Be In Touch Soon</h3>
              <p style="color: #475569; margin-top: 0.5rem;">Thank you for contacting Orbitone Tech Solutions. A representative will contact you shortly.</p>
            </div>
          `);
          contactForm.reset();
        } else {
          alert('Error: ' + (result.message || 'Could not send message'));
        }
      } catch (err) {
        alert('Form submission error. Please try again.');
      } finally {
        if (btn) btn.disabled = false;
      }
    });
  }

  /* -------------------------------------------------------------
   * 6. Portfolio Category Filter
   * ------------------------------------------------------------- */
  const filterBtns = document.querySelectorAll('.filter-btn[data-filter]');
  const portfolioCards = document.querySelectorAll('.portfolio-card');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const filter = btn.dataset.filter;
      portfolioCards.forEach(card => {
        if (filter === 'all' || card.dataset.category === filter) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });

  /* -------------------------------------------------------------
   * 7. Orbitone Signature Technology Ecosystem Controller
   * ------------------------------------------------------------- */
  const orbitVisual = document.getElementById('orbitVisual');
  if (orbitVisual) {
    const techNodes = orbitVisual.querySelectorAll('.tech-orbit-node');
    let autoCycleTimer = null;
    let activeIndex = 0;
    let userInteracting = false;

    techNodes.forEach((node, idx) => {
      const nodeType = node.dataset.node;

      node.addEventListener('mouseenter', () => {
        userInteracting = true;
        clearInterval(autoCycleTimer);
        techNodes.forEach(n => n.classList.remove('active'));
        orbitVisual.className = 'orbit-visual-container hover-' + nodeType;
        node.classList.add('active');
      });

      node.addEventListener('mouseleave', () => {
        userInteracting = false;
        node.classList.remove('active');
        orbitVisual.className = 'orbit-visual-container';
        startAutoCycle();
      });

      // Mobile touch support
      node.addEventListener('click', (e) => {
        if (window.innerWidth <= 768) {
          const title = node.querySelector('.popover-head')?.textContent || 'Capability';
          const desc = node.querySelector('.popover-body')?.textContent || '';
          const tag = node.querySelector('.popover-cat')?.textContent || 'Technology';
          if (typeof window.showModal === 'function') {
            window.showModal(title, `
              <div style="padding: 0.5rem 0;">
                <span class="badge">${tag}</span>
                <p style="color: var(--text-muted); font-size: 1rem; margin-top: 1rem; line-height: 1.6;">${desc}</p>
                <div style="margin-top: 1.5rem;">
                  <a href="?page=services" class="btn btn-primary btn-full">Explore Capabilities</a>
                </div>
              </div>
            `);
          }
        }
      });
    });

    function startAutoCycle() {
      if (window.innerWidth <= 768) return;
      clearInterval(autoCycleTimer);
      autoCycleTimer = setInterval(() => {
        if (userInteracting) return;
        techNodes.forEach(n => n.classList.remove('active'));
        orbitVisual.className = 'orbit-visual-container';

        if (techNodes[activeIndex]) {
          const nodeType = techNodes[activeIndex].dataset.node;
          techNodes[activeIndex].classList.add('active');
          orbitVisual.className = 'orbit-visual-container hover-' + nodeType;

          setTimeout(() => {
            if (!userInteracting && techNodes[activeIndex]) {
              techNodes[activeIndex].classList.remove('active');
              orbitVisual.className = 'orbit-visual-container';
            }
          }, 2400);
        }

        activeIndex = (activeIndex + 1) % techNodes.length;
      }, 5000);
    }

    startAutoCycle();
  }

  /* -------------------------------------------------------------
   * Helper: Dynamic Modal Generator
   * ------------------------------------------------------------- */
  window.showModal = function (title, htmlBody) {
    let overlay = document.getElementById('globalModalOverlay');
    if (!overlay) {
      overlay = document.createElement('div');
      overlay.id = 'globalModalOverlay';
      overlay.className = 'modal-overlay';
      overlay.innerHTML = `
        <div class="modal-box">
          <button class="modal-close" onclick="closeModal()">&times;</button>
          <h3 id="modalTitle" style="font-size: 1.4rem; margin-bottom: 1.25rem; color: #0b192c;"></h3>
          <div id="modalBody"></div>
        </div>
      `;
      overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeModal();
      });
      document.body.appendChild(overlay);
    }

    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalBody').innerHTML = htmlBody;
    overlay.classList.add('open');
  };

  window.closeModal = function () {
    const overlay = document.getElementById('globalModalOverlay');
    if (overlay) overlay.classList.remove('open');
  };

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeModal();
  });

});

