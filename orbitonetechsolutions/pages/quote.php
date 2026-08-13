<!-- Orbitone Tech Solutions - Interactive Project Cost Estimator & Quote Wizard -->

<section class="section quote-page-section">
  <div class="container">
    
    <div class="section-title text-center">
      <span class="badge">Enterprise Scoping & Estimation</span>
      <h2>Tell Us What You <span class="gradient-text">Want to Build</span></h2>
      <p class="section-subtitle">Complete our 4-step project scoping wizard to receive an architectural breakdown and tailored proposal.</p>
    </div>

    <!-- 4-Step Interactive Quote Wizard -->
    <div class="quote-wizard-container">
      
      <!-- Progress Bar & Step Tracker -->
      <div class="wizard-header">
        <div class="wizard-progress-track">
          <div class="wizard-progress-bar" id="wizardProgressBar" style="width: 25%;"></div>
        </div>

        <div class="wizard-steps-track">
          <div class="step-indicator active" data-step="1">
            <div class="step-num-circle">
              <span class="step-num">1</span>
              <i class="ri-check-line step-check-icon"></i>
            </div>
            <div class="step-text-wrap">
              <span class="step-label">Services</span>
              <span class="step-sublabel">Select Capabilities</span>
            </div>
          </div>

          <div class="step-indicator" data-step="2">
            <div class="step-num-circle">
              <span class="step-num">2</span>
              <i class="ri-check-line step-check-icon"></i>
            </div>
            <div class="step-text-wrap">
              <span class="step-label">Scope</span>
              <span class="step-sublabel">Timeline & Goals</span>
            </div>
          </div>

          <div class="step-indicator" data-step="3">
            <div class="step-num-circle">
              <span class="step-num">3</span>
              <i class="ri-check-line step-check-icon"></i>
            </div>
            <div class="step-text-wrap">
              <span class="step-label">Budget</span>
              <span class="step-sublabel">Estimated Range</span>
            </div>
          </div>

          <div class="step-indicator" data-step="4">
            <div class="step-num-circle">
              <span class="step-num">4</span>
              <i class="ri-check-line step-check-icon"></i>
            </div>
            <div class="step-text-wrap">
              <span class="step-label">Contact</span>
              <span class="step-sublabel">Proposal Delivery</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Wizard Form -->
      <form id="quoteWizardForm">
        <div class="wizard-body">

          <!-- ==========================================
               STEP 1: SERVICE SELECTION CHECKLIST
               ========================================== -->
          <div class="step-pane active" id="step1">
            <div class="step-pane-header">
              <div class="step-pane-badge">Step 1 of 4</div>
              <h3 class="step-pane-title">What capabilities does your project require?</h3>
              <p class="step-pane-desc">Select all services that apply. We can combine multiple disciplines into a unified solution.</p>
            </div>

            <div class="checklist-grid">
              
              <!-- Option 1: Website -->
              <div class="checklist-card" data-service="website" tabindex="0" role="checkbox" aria-checked="false">
                <input type="checkbox" name="services[]" value="Website" class="checklist-checkbox">
                <div class="card-custom-check">
                  <i class="ri-check-line"></i>
                </div>
                <div class="card-icon-badge icon-bg-amber">
                  <i class="ri-window-fill"></i>
                </div>
                <div class="card-info">
                  <div class="card-title">Website & Portals</div>
                  <div class="card-desc">Corporate brand presence, responsive UI & high-performance frontend</div>
                </div>
                <div class="card-tag">Fast Delivery</div>
              </div>

              <!-- Option 2: Web App -->
              <div class="checklist-card" data-service="webapp" tabindex="0" role="checkbox" aria-checked="false">
                <input type="checkbox" name="services[]" value="Web Application" class="checklist-checkbox">
                <div class="card-custom-check">
                  <i class="ri-check-line"></i>
                </div>
                <div class="card-icon-badge icon-bg-emerald">
                  <i class="ri-terminal-box-fill"></i>
                </div>
                <div class="card-info">
                  <div class="card-title">Web Application & SaaS</div>
                  <div class="card-desc">Scalable cloud SaaS, client portals, APIs & microservices architecture</div>
                </div>
                <div class="card-tag">High Scale</div>
              </div>

              <!-- Option 3: Mobile App -->
              <div class="checklist-card" data-service="mobile" tabindex="0" role="checkbox" aria-checked="false">
                <input type="checkbox" name="services[]" value="Mobile Application" class="checklist-checkbox">
                <div class="card-custom-check">
                  <i class="ri-check-line"></i>
                </div>
                <div class="card-icon-badge icon-bg-blue">
                  <i class="ri-smartphone-fill"></i>
                </div>
                <div class="card-info">
                  <div class="card-title">Mobile Application</div>
                  <div class="card-desc">Native & cross-platform iOS & Android mobile applications</div>
                </div>
                <div class="card-tag">iOS / Android</div>
              </div>

              <!-- Option 4: AI & ML -->
              <div class="checklist-card" data-service="ai" tabindex="0" role="checkbox" aria-checked="false">
                <input type="checkbox" name="services[]" value="AI Solution" class="checklist-checkbox">
                <div class="card-custom-check">
                  <i class="ri-check-line"></i>
                </div>
                <div class="card-icon-badge icon-bg-purple">
                  <i class="ri-brain-fill"></i>
                </div>
                <div class="card-info">
                  <div class="card-title">AI & ML Solutions</div>
                  <div class="card-desc">Custom LLM applications, RAG pipelines, agents & predictive models</div>
                </div>
                <div class="card-tag">Intelligent</div>
              </div>

              <!-- Option 5: Data Analytics -->
              <div class="checklist-card" data-service="data" tabindex="0" role="checkbox" aria-checked="false">
                <input type="checkbox" name="services[]" value="Data Analytics" class="checklist-checkbox">
                <div class="card-custom-check">
                  <i class="ri-check-line"></i>
                </div>
                <div class="card-icon-badge icon-bg-cyan">
                  <i class="ri-pie-chart-2-fill"></i>
                </div>
                <div class="card-info">
                  <div class="card-title">Data & Telemetry Insights</div>
                  <div class="card-desc">Executive BI dashboards, automated ETL pipelines & analytics</div>
                </div>
                <div class="card-tag">Telemetry</div>
              </div>

              <!-- Option 6: Digital Marketing -->
              <div class="checklist-card" data-service="digital" tabindex="0" role="checkbox" aria-checked="false">
                <input type="checkbox" name="services[]" value="Digital Marketing" class="checklist-checkbox">
                <div class="card-custom-check">
                  <i class="ri-check-line"></i>
                </div>
                <div class="card-icon-badge icon-bg-pink">
                  <i class="ri-rocket-2-fill"></i>
                </div>
                <div class="card-info">
                  <div class="card-title">Digital Growth & Marketing</div>
                  <div class="card-desc">Conversion engineering, SEO optimization & performance campaigns</div>
                </div>
                <div class="card-tag">Growth</div>
              </div>

            </div>
          </div>

          <!-- ==========================================
               STEP 2: PROJECT REQUIREMENTS & TIMELINE
               ========================================== -->
          <div class="step-pane" id="step2">
            <div class="step-pane-header">
              <div class="step-pane-badge">Step 2 of 4</div>
              <h3 class="step-pane-title">Scope & Expected Timeline</h3>
              <p class="step-pane-desc">Tell us about your objectives and target timeline.</p>
            </div>

            <!-- Quick Requirement Tags -->
            <div class="form-group" style="margin-bottom: 1.5rem;">
              <label class="form-label">Project Objectives & Description</label>
              <textarea name="requirements" id="requirementsText" class="form-control quote-textarea" rows="4" placeholder="Describe the core features, business challenges, or user workflow you want to build..."></textarea>
              
              <div class="quick-tags-wrap">
                <span class="quick-tags-label">Quick suggestions:</span>
                <div class="quick-tags-list">
                  <button type="button" class="quick-tag-chip" data-tag="Need rapid MVP in 4-6 weeks">+ Rapid MVP (4-6 wks)</button>
                  <button type="button" class="quick-tag-chip" data-tag="Custom AI/LLM integration">+ Custom AI / RAG</button>
                  <button type="button" class="quick-tag-chip" data-tag="Cloud microservices architecture">+ Cloud Microservices</button>
                  <button type="button" class="quick-tag-chip" data-tag="Executive BI & data dashboards">+ Executive BI Dashboard</button>
                  <button type="button" class="quick-tag-chip" data-tag="High-throughput payment gateway">+ Payment Gateway</button>
                </div>
              </div>
            </div>

            <!-- Target Timeline Selection -->
            <div class="form-group">
              <label class="form-label">Target Delivery Timeline</label>
              <div class="timeline-grid">
                
                <div class="timeline-card" data-val="Urgent (< 1 Month)" tabindex="0" role="radio" aria-checked="false">
                  <input type="radio" name="timeline" value="Urgent (< 1 Month)">
                  <div class="timeline-card-content">
                    <div class="timeline-icon"><i class="ri-flashlight-fill"></i></div>
                    <div class="timeline-title">Urgent Sprint</div>
                    <div class="timeline-desc">&lt; 1 Month</div>
                  </div>
                </div>

                <div class="timeline-card selected" data-val="Standard (1-3 Months)" tabindex="0" role="radio" aria-checked="true">
                  <input type="radio" name="timeline" value="Standard (1-3 Months)" checked>
                  <div class="timeline-card-content">
                    <div class="timeline-icon"><i class="ri-calendar-event-fill"></i></div>
                    <div class="timeline-title">Standard Phase</div>
                    <div class="timeline-desc">1 – 3 Months</div>
                  </div>
                </div>

                <div class="timeline-card" data-val="Strategic (3-6 Months)" tabindex="0" role="radio" aria-checked="false">
                  <input type="radio" name="timeline" value="Strategic (3-6 Months)">
                  <div class="timeline-card-content">
                    <div class="timeline-icon"><i class="ri-building-2-fill"></i></div>
                    <div class="timeline-title">Strategic Build</div>
                    <div class="timeline-desc">3 – 6 Months</div>
                  </div>
                </div>

                <div class="timeline-card" data-val="Flexible / Ongoing" tabindex="0" role="radio" aria-checked="false">
                  <input type="radio" name="timeline" value="Flexible / Ongoing">
                  <div class="timeline-card-content">
                    <div class="timeline-icon"><i class="ri-loop-right-fill"></i></div>
                    <div class="timeline-title">Flexible / Ongoing</div>
                    <div class="timeline-desc">Continuous Agile</div>
                  </div>
                </div>

              </div>
            </div>

          </div>

          <!-- ==========================================
               STEP 3: BUDGET RANGE
               ========================================== -->
          <div class="step-pane" id="step3">
            <div class="step-pane-header">
              <div class="step-pane-badge">Step 3 of 4</div>
              <h3 class="step-pane-title">What is your planned investment tier?</h3>
              <p class="step-pane-desc">This helps us calibrate the architectural depth and technology stack recommendations.</p>
            </div>

            <div class="budget-tiers-grid">
              
              <div class="budget-card" data-val="₹25K – ₹50K" tabindex="0" role="radio" aria-checked="false">
                <input type="radio" name="budget" value="₹25K – ₹50K">
                <div class="budget-card-inner">
                  <div class="budget-tier-tag">Starter</div>
                  <div class="budget-amount">₹25K – ₹50K</div>
                  <div class="budget-desc">Basic prototype, landing portal, or architectural audit</div>
                </div>
              </div>

              <div class="budget-card" data-val="₹50K – ₹1L" tabindex="0" role="radio" aria-checked="false">
                <input type="radio" name="budget" value="₹50K – ₹1L">
                <div class="budget-card-inner">
                  <div class="budget-tier-tag">Growth</div>
                  <div class="budget-amount">₹50K – ₹1L</div>
                  <div class="budget-desc">Custom web application, AI prototype, or mobile MVP</div>
                </div>
              </div>

              <div class="budget-card" data-val="₹1L – ₹5L" tabindex="0" role="radio" aria-checked="false">
                <input type="radio" name="budget" value="₹1L – ₹5L">
                <div class="budget-card-inner">
                  <div class="budget-tier-tag popular">Most Popular</div>
                  <div class="budget-amount">₹1L – ₹5L</div>
                  <div class="budget-desc">Full-scale mobile app, SaaS platform, or enterprise BI system</div>
                </div>
              </div>

              <div class="budget-card" data-val="₹5L+" tabindex="0" role="radio" aria-checked="false">
                <input type="radio" name="budget" value="₹5L+">
                <div class="budget-card-inner">
                  <div class="budget-tier-tag">Enterprise</div>
                  <div class="budget-amount">₹5L+</div>
                  <div class="budget-desc">Comprehensive cloud ecosystem, microservices & full-cycle AI</div>
                </div>
              </div>

              <div class="budget-card selected" data-val="Not Sure" tabindex="0" role="radio" aria-checked="true">
                <input type="radio" name="budget" value="Not Sure" checked>
                <div class="budget-card-inner">
                  <div class="budget-tier-tag">Consultative</div>
                  <div class="budget-amount">Not Sure Yet</div>
                  <div class="budget-desc">Need architectural advice and custom scope estimation</div>
                </div>
              </div>

            </div>
          </div>

          <!-- ==========================================
               STEP 4: CONTACT INFORMATION
               ========================================== -->
          <div class="step-pane" id="step4">
            <div class="step-pane-header">
              <div class="step-pane-badge">Step 4 of 4</div>
              <h3 class="step-pane-title">Where should we deliver your custom proposal?</h3>
              <p class="step-pane-desc">Our solutions architect will review your submission and reach out within 24 hours.</p>
            </div>

            <div class="contact-inputs-grid">
              <div class="form-group">
                <label class="form-label">Your Full Name <span class="req-star">*</span></label>
                <div class="input-icon-group">
                  <i class="ri-user-3-line"></i>
                  <input type="text" name="contact_name" class="form-control input-with-icon" required placeholder="Alex Turner">
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Work Email <span class="req-star">*</span></label>
                <div class="input-icon-group">
                  <i class="ri-mail-line"></i>
                  <input type="email" name="contact_email" class="form-control input-with-icon" required placeholder="alex@company.com">
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Phone / WhatsApp Number</label>
                <div class="input-icon-group">
                  <i class="ri-phone-line"></i>
                  <input type="tel" name="contact_phone" class="form-control input-with-icon" placeholder="+91 98765 43210">
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Company / Organization</label>
                <div class="input-icon-group">
                  <i class="ri-building-line"></i>
                  <input type="text" name="company" class="form-control input-with-icon" placeholder="Acme Technologies Inc.">
                </div>
              </div>
            </div>

            <!-- Trust & NDA Assurance Box -->
            <div class="trust-assurance-box">
              <div class="trust-icon"><i class="ri-shield-check-fill"></i></div>
              <div class="trust-text">
                <strong>100% Confidential & Secure:</strong> All project discussions and requirements are strictly protected under mutual confidentiality. We provide a transparent scope breakdown with zero obligation.
              </div>
            </div>

          </div>

        </div>

        <!-- Wizard Navigation Controls -->
        <div class="wizard-footer">
          <button type="button" class="btn btn-secondary btn-wizard-prev" id="wizardPrev" style="display: none;">
            <i class="ri-arrow-left-line"></i>
            <span>Previous Step</span>
          </button>
          
          <div class="wizard-footer-right">
            <button type="button" class="btn btn-primary btn-wizard-next" id="wizardNext">
              <span>Next Step</span>
              <i class="ri-arrow-right-line"></i>
            </button>

            <button type="submit" class="btn btn-cta-primary btn-wizard-submit" id="wizardSubmit" style="display: none;">
              <span>Submit & Generate Proposal</span>
              <i class="ri-send-plane-fill"></i>
            </button>
          </div>
        </div>

      </form>
    </div>

  </div>
</section>

