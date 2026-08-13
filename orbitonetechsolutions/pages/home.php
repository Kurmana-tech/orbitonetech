<!-- Orbitone Tech Solutions - Redesigned Homepage (Premium Enterprise & AI Ecosystem) -->
<?php
$db = getDB();
$featuredProjects = [];
try {
    $stmt = $db->query("SELECT * FROM projects ORDER BY featured DESC, id ASC LIMIT 3");
    $featuredProjects = $stmt->fetchAll();
} catch (Exception $e) {
    // Fallback if db error
    $featuredProjects = [];
}
?>

<!-- =============================================================
     SECTION 1: HERO SECTION & SIGNATURE ORBITAL VISUAL
     ============================================================= -->
<section class="hero-section">
  <!-- Subtle Background Ambient Orbit Glow -->
  <div class="hero-ambient-glow"></div>

  <div class="container">
    <div class="hero-content">
      
      <!-- Hero Left Column: Headline, Outcome Value Prop & CTAs -->
      <div class="hero-text">
        <div class="hero-badge-wrap">
          <span class="badge">
            <span class="pulse-dot"></span>
            <span>Enterprise Technology & Digital Growth</span>
          </span>
        </div>
        
        <h1 class="hero-headline">
          Build Smarter.<br>
          <span class="gradient-text">Scale Faster.</span>
        </h1>

        <p class="hero-subtext">
          We engineer AI-powered software, intelligent data systems, and digital experiences that help ambitious businesses move from idea to measurable growth.
        </p>
        
        <div class="hero-tagline-wrap">
          <span class="brand-tagline">INNOVATE • INTEGRATE • ELEVATE</span>
        </div>

        <div class="hero-actions">
          <a href="?page=quote" class="btn btn-primary btn-hero-primary">
            <span>Start a Project</span>
            <i class="ri-arrow-right-line"></i>
          </a>
          <a href="?page=services" class="btn btn-secondary btn-hero-secondary">
            <span>Explore Solutions</span>
            <i class="ri-arrow-right-up-line"></i>
          </a>
        </div>
      </div>

      <!-- Hero Right Column: Orbitone Signature Technology Ecosystem Visualization -->
      <div class="hero-visual-wrapper">
        <div class="orbit-visual-container" id="orbitVisual">
          
          <!-- Concentric Technology Orbital Trajectories & Radial Bus (SVG) -->
          <svg class="orbit-tracks-svg" viewBox="0 0 540 540" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Outer Trajectory Track (Radius 225) -->
            <circle cx="270" cy="270" r="225" stroke="rgba(11, 25, 44, 0.08)" stroke-width="1.5" stroke-dasharray="6 8" />
            <!-- Middle Primary Trajectory (Radius 165) -->
            <circle cx="270" cy="270" r="165" stroke="rgba(217, 119, 6, 0.22)" stroke-width="1.5" />
            <!-- Inner Trajectory (Radius 105) -->
            <circle cx="270" cy="270" r="105" stroke="rgba(11, 25, 44, 0.07)" stroke-width="1.2" stroke-dasharray="4 6" />
            
            <!-- Radial Connection Conduits (Center Core to Nodes) -->
            <line class="conduit-line conduit-cloud" x1="270" y1="200" x2="270" y2="85" stroke="rgba(11, 25, 44, 0.08)" stroke-width="1.2" stroke-dasharray="3 3" />
            <line class="conduit-line conduit-software" x1="215" y1="215" x2="105" y2="155" stroke="rgba(11, 25, 44, 0.08)" stroke-width="1.2" stroke-dasharray="3 3" />
            <line class="conduit-line conduit-auto" x1="325" y1="215" x2="435" y2="155" stroke="rgba(11, 25, 44, 0.08)" stroke-width="1.2" stroke-dasharray="3 3" />
            <line class="conduit-line conduit-data" x1="215" y1="325" x2="115" y2="385" stroke="rgba(11, 25, 44, 0.08)" stroke-width="1.2" stroke-dasharray="3 3" />
            <line class="conduit-line conduit-ai" x1="325" y1="325" x2="425" y2="385" stroke="rgba(11, 25, 44, 0.08)" stroke-width="1.2" stroke-dasharray="3 3" />
            <line class="conduit-line conduit-digital" x1="270" y1="340" x2="270" y2="455" stroke="rgba(11, 25, 44, 0.08)" stroke-width="1.2" stroke-dasharray="3 3" />

            <!-- Dynamic Orbiting Satellite Nodes (Restrained Motion) -->
            <circle class="orbit-satellite sat-1" cx="495" cy="270" r="3.5" fill="var(--gold-primary)" />
            <circle class="orbit-satellite sat-2" cx="270" cy="105" r="3" fill="var(--gold-amber)" />
            <circle class="orbit-satellite sat-3" cx="165" cy="270" r="2.5" fill="var(--navy-light)" />
          </svg>

          <!-- Central Orbitone Nucleus (Core Technology Origin) -->
          <div class="orbit-center-nucleus">
            <div class="nucleus-ambient-pulse"></div>
            <div class="nucleus-ring-energy"></div>
            
            <div class="nucleus-orb">
              <img src="assets/images/orbitone-nucleus.png" alt="Orbitone Core Nucleus" class="nucleus-emblem-img">
            </div>

            <div class="nucleus-label">
              <span class="nucleus-brand-name">ORBITONE</span>
              <span class="nucleus-brand-sub">Technology Ecosystem</span>
            </div>
          </div>

          <!-- Revolving Technology Planetary Orbit System (Smooth Continuous Revolution) -->
          <div class="tech-revolution-system" id="techRevolution">

            <!-- Slot 1: CLOUD (0 deg / Top) -->
            <div class="orbit-node-slot slot-1">
              <div class="tech-orbit-node" data-node="cloud">
                <div class="tech-node-anchor">
                  <div class="tech-icon-disc">
                    <svg class="tech-icon-svg" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M7 19C5.34315 19 4 17.6569 4 16C4 14.4565 5.16308 13.1843 6.66035 13.0211C7.14441 9.60155 10.0766 7 13.6 7C16.5925 7 19.1678 8.87198 20.1206 11.536C20.6698 11.3533 21.2583 11.25 21.8667 11.25C24.7017 11.25 27 13.5483 27 16.3833C27 19.0069 25.0326 21.1718 22.4842 21.4746" stroke="var(--navy-dark)" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
                      <line x1="8" y1="25" x2="24" y2="25" stroke="var(--navy-dark)" stroke-width="1.5" stroke-linecap="round" />
                      <line x1="10" y1="19" x2="10" y2="25" stroke="var(--navy-dark)" stroke-width="1.5" stroke-linecap="round" />
                      <line x1="16" y1="15" x2="16" y2="25" stroke="var(--gold-dark)" stroke-width="1.5" stroke-dasharray="2 2" stroke-linecap="round" />
                      <line x1="22" y1="19" x2="22" y2="25" stroke="var(--navy-dark)" stroke-width="1.5" stroke-linecap="round" />
                      <circle cx="10" cy="25" r="2" fill="#ffffff" stroke="var(--navy-dark)" stroke-width="1.5" />
                      <circle cx="16" cy="25" r="2" fill="var(--gold-primary)" stroke="var(--gold-dark)" stroke-width="1.5" />
                      <circle cx="22" cy="25" r="2" fill="#ffffff" stroke="var(--navy-dark)" stroke-width="1.5" />
                    </svg>
                  </div>
                  <div class="tech-node-meta">
                    <span class="tech-domain-label">CLOUD</span>
                  </div>
                </div>
                <div class="tech-node-popover">
                  <div class="popover-cat">Infrastructure</div>
                  <div class="popover-head">Cloud & DevOps</div>
                  <div class="popover-body">Cloud Architecture • CI/CD Automation • High-Availability Scaling</div>
                  <a href="?page=services" class="popover-action">Explore Cloud &rarr;</a>
                </div>
              </div>
            </div>

            <!-- Slot 2: AUTOMATION (60 deg / Top Right) -->
            <div class="orbit-node-slot slot-2">
              <div class="tech-orbit-node" data-node="auto">
                <div class="tech-node-anchor">
                  <div class="tech-icon-disc">
                    <svg class="tech-icon-svg" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M16 5C21.5228 5 26 9.47715 26 15" stroke="var(--navy-dark)" stroke-width="1.75" stroke-linecap="round" />
                      <path d="M26 15L23.5 13M26 15L28.5 13" stroke="var(--navy-dark)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M25 19C23.1428 23.6337 18.5299 26.75 13.5 26.75" stroke="var(--navy-dark)" stroke-width="1.75" stroke-linecap="round" />
                      <path d="M13.5 26.75L15 29M13.5 26.75L15 24.5" stroke="var(--navy-dark)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M9.5 24C6.11571 21.0543 5 16.3218 6.5 12" stroke="var(--navy-dark)" stroke-width="1.75" stroke-linecap="round" />
                      <path d="M6.5 12L8.5 13.5M6.5 12L5 14" stroke="var(--navy-dark)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                      <circle cx="16" cy="16" r="4.5" stroke="var(--navy-dark)" stroke-width="1.5" stroke-dasharray="3 2" />
                      <circle cx="16" cy="16" r="2" fill="var(--gold-primary)" />
                      <circle cx="16" cy="5" r="1.75" fill="var(--gold-primary)" />
                      <circle cx="25" cy="20" r="1.75" fill="var(--navy-dark)" />
                      <circle cx="7.5" cy="22" r="1.75" fill="var(--navy-dark)" />
                    </svg>
                  </div>
                  <div class="tech-node-meta">
                    <span class="tech-domain-label">AUTOMATION</span>
                  </div>
                </div>
                <div class="tech-node-popover">
                  <div class="popover-cat">Efficiency</div>
                  <div class="popover-head">Workflow Automation</div>
                  <div class="popover-body">Intelligent Workflows • Robotic Automation • API Orchestration</div>
                  <a href="?page=app-development" class="popover-action">Explore Automation &rarr;</a>
                </div>
              </div>
            </div>

            <!-- Slot 3: AI & ML (120 deg / Bottom Right) -->
            <div class="orbit-node-slot slot-3">
              <div class="tech-orbit-node" data-node="ai">
                <div class="tech-node-anchor">
                  <div class="tech-icon-disc">
                    <svg class="tech-icon-svg" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <polygon points="16,6 25,11 25,21 16,26 7,21 7,11" stroke="var(--navy-dark)" stroke-width="1.5" stroke-dasharray="3 2" />
                      <line x1="16" y1="16" x2="16" y2="6" stroke="var(--navy-dark)" stroke-width="1.5" stroke-linecap="round"/>
                      <line x1="16" y1="16" x2="25" y2="11" stroke="var(--navy-dark)" stroke-width="1.5" stroke-linecap="round"/>
                      <line x1="16" y1="16" x2="25" y2="21" stroke="var(--navy-dark)" stroke-width="1.5" stroke-linecap="round"/>
                      <line x1="16" y1="16" x2="16" y2="26" stroke="var(--navy-dark)" stroke-width="1.5" stroke-linecap="round"/>
                      <line x1="16" y1="16" x2="7" y2="21" stroke="var(--navy-dark)" stroke-width="1.5" stroke-linecap="round"/>
                      <line x1="16" y1="16" x2="7" y2="11" stroke="var(--navy-dark)" stroke-width="1.5" stroke-linecap="round"/>
                      <circle cx="16" cy="16" r="3.5" fill="#ffffff" stroke="var(--gold-dark)" stroke-width="1.75"/>
                      <circle cx="16" cy="16" r="1.75" fill="var(--gold-primary)"/>
                      <circle cx="16" cy="6" r="1.75" fill="var(--gold-primary)" />
                      <circle cx="25" cy="11" r="1.75" fill="var(--navy-dark)" />
                      <circle cx="25" cy="21" r="1.75" fill="var(--gold-primary)" />
                      <circle cx="16" cy="26" r="1.75" fill="var(--navy-dark)" />
                      <circle cx="7" cy="21" r="1.75" fill="var(--gold-primary)" />
                      <circle cx="7" cy="11" r="1.75" fill="var(--navy-dark)" />
                    </svg>
                  </div>
                  <div class="tech-node-meta">
                    <span class="tech-domain-label">AI & ML</span>
                  </div>
                </div>
                <div class="tech-node-popover">
                  <div class="popover-cat">Intelligence</div>
                  <div class="popover-head">AI & Machine Learning</div>
                  <div class="popover-body">LLM Applications • RAG Pipelines • Autonomous Agents • Predictive Models</div>
                  <a href="?page=ai-solutions" class="popover-action">Explore AI &rarr;</a>
                </div>
              </div>
            </div>

            <!-- Slot 4: DIGITAL (180 deg / Bottom) -->
            <div class="orbit-node-slot slot-4">
              <div class="tech-orbit-node" data-node="digital">
                <div class="tech-node-anchor">
                  <div class="tech-icon-disc">
                    <svg class="tech-icon-svg" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M16 4L27 10.5V21.5L16 28L5 21.5V10.5L16 4Z" stroke="var(--navy-dark)" stroke-width="1.75" stroke-linejoin="round"/>
                      <path d="M16 4V16M16 16L27 10.5M16 16L5 10.5M16 16V28" stroke="var(--navy-dark)" stroke-width="1.5" stroke-linejoin="round" opacity="0.6"/>
                      <path d="M11 20L16 14L21 17L26 8" stroke="var(--gold-primary)" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
                      <circle cx="26" cy="8" r="2" fill="var(--gold-primary)" stroke="var(--gold-dark)" stroke-width="1"/>
                      <circle cx="16" cy="14" r="1.5" fill="var(--navy-dark)" />
                    </svg>
                  </div>
                  <div class="tech-node-meta">
                    <span class="tech-domain-label">DIGITAL</span>
                  </div>
                </div>
                <div class="tech-node-popover">
                  <div class="popover-cat">Growth</div>
                  <div class="popover-head">Digital Experiences</div>
                  <div class="popover-body">Conversion Engineering • Growth Systems • Performance Optimization</div>
                  <a href="?page=digital-marketing" class="popover-action">Explore Digital &rarr;</a>
                </div>
              </div>
            </div>

            <!-- Slot 5: DATA (240 deg / Bottom Left) -->
            <div class="orbit-node-slot slot-5">
              <div class="tech-orbit-node" data-node="data">
                <div class="tech-node-anchor">
                  <div class="tech-icon-disc">
                    <svg class="tech-icon-svg" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <ellipse cx="16" cy="8" rx="9" ry="3.5" stroke="var(--navy-dark)" stroke-width="1.75"/>
                      <path d="M7 8V14C7 15.933 11.0294 17.5 16 17.5C20.9706 17.5 25 15.933 25 14V8" stroke="var(--navy-dark)" stroke-width="1.75"/>
                      <path d="M7 14V20C7 21.933 11.0294 23.5 16 23.5C20.9706 23.5 25 21.933 25 20V14" stroke="var(--navy-dark)" stroke-width="1.75"/>
                      <line x1="20.5" y1="8" x2="20.5" y2="24" stroke="var(--gold-dark)" stroke-width="1.5" stroke-dasharray="2 2"/>
                      <circle cx="20.5" cy="11" r="1.5" fill="var(--gold-primary)"/>
                      <circle cx="20.5" cy="17" r="1.5" fill="var(--gold-primary)"/>
                      <circle cx="20.5" cy="24" r="2" fill="var(--gold-primary)" stroke="var(--gold-dark)" stroke-width="1"/>
                    </svg>
                  </div>
                  <div class="tech-node-meta">
                    <span class="tech-domain-label">DATA</span>
                  </div>
                </div>
                <div class="tech-node-popover">
                  <div class="popover-cat">Telemetry</div>
                  <div class="popover-head">Data & Analytics</div>
                  <div class="popover-body">Data Pipelines • Executive BI Dashboards • Real-time Telemetry</div>
                  <a href="?page=data-analytics" class="popover-action">Explore Data &rarr;</a>
                </div>
              </div>
            </div>

            <!-- Slot 6: SOFTWARE (300 deg / Top Left) -->
            <div class="orbit-node-slot slot-6">
              <div class="tech-orbit-node" data-node="software">
                <div class="tech-node-anchor">
                  <div class="tech-icon-disc">
                    <svg class="tech-icon-svg" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M9 10L4 16L9 22" stroke="var(--navy-dark)" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M23 10L28 16L23 22" stroke="var(--navy-dark)" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
                      <rect x="11" y="9" width="4.5" height="4.5" rx="1" stroke="var(--navy-dark)" stroke-width="1.5" />
                      <rect x="16.5" y="9" width="4.5" height="4.5" rx="1" stroke="var(--navy-dark)" stroke-width="1.5" />
                      <rect x="11" y="14.5" width="4.5" height="4.5" rx="1" stroke="var(--navy-dark)" stroke-width="1.5" />
                      <rect x="16.5" y="14.5" width="4.5" height="4.5" rx="1" fill="var(--gold-primary)" stroke="var(--gold-dark)" stroke-width="1.5" />
                      <path d="M13 22H19" stroke="var(--gold-dark)" stroke-width="1.5" stroke-linecap="round" />
                      <circle cx="16" cy="22" r="1.5" fill="var(--gold-primary)" />
                    </svg>
                  </div>
                  <div class="tech-node-meta">
                    <span class="tech-domain-label">SOFTWARE</span>
                  </div>
                </div>
                <div class="tech-node-popover">
                  <div class="popover-cat">Engineering</div>
                  <div class="popover-head">Software Engineering</div>
                  <div class="popover-body">Web Apps • High-Throughput APIs • Microservices Architecture</div>
                  <a href="?page=web-development" class="popover-action">Explore Software &rarr;</a>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<!-- =============================================================
     SECTION 2: CREDIBLE CAPABILITIES & PROOF BAR
     ============================================================= -->
<section class="proof-bar-section">
  <div class="container">
    <div class="proof-grid">
      
      <div class="proof-item">
        <div class="proof-icon-wrap"><i class="ri-shield-check-line"></i></div>
        <div class="proof-content">
          <div class="proof-title">Enterprise Engineering</div>
          <div class="proof-subtitle">Cloud-native architectures & resilient full-stack systems</div>
        </div>
      </div>

      <div class="proof-item">
        <div class="proof-icon-wrap"><i class="ri-cpu-line"></i></div>
        <div class="proof-content">
          <div class="proof-title">AI & Intelligent Pipelines</div>
          <div class="proof-subtitle">Custom LLMs, RAG search engines & automated agents</div>
        </div>
      </div>

      <div class="proof-item">
        <div class="proof-icon-wrap"><i class="ri-pie-chart-2-line"></i></div>
        <div class="proof-content">
          <div class="proof-title">Data & Telemetry Insights</div>
          <div class="proof-subtitle">Executive BI dashboards & automated ETL pipelines</div>
        </div>
      </div>

      <div class="proof-item">
        <div class="proof-icon-wrap"><i class="ri-team-line"></i></div>
        <div class="proof-content">
          <div class="proof-title">End-to-End Partnership</div>
          <div class="proof-subtitle">From architectural design to scaled production delivery</div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- =============================================================
     SECTION 3: SERVICES CAPABILITIES SECTION
     ============================================================= -->
<section class="section services-showcase-section">
  <div class="container">
    <div class="section-title">
      <span class="badge">Core Disciplines</span>
      <h2>One Technology Partner.<br><span class="gradient-text">Multiple Capabilities.</span></h2>
      <p>We combine deep technical engineering with strategic product vision to build solutions that drive measurable business ROI.</p>
    </div>

    <div class="capabilities-grid">
      
      <!-- Capability 1: AI & ML -->
      <div class="capability-card">
        <div class="capability-card-header">
          <div class="capability-icon"><i class="ri-robot-line"></i></div>
          <span class="capability-num">01</span>
        </div>
        <h3 class="capability-title">AI & Machine Learning</h3>
        <p class="capability-desc">
          Custom generative AI assistants, enterprise RAG search engines, predictive modeling, and intelligent workflow automation built for production scale.
        </p>
        <div class="capability-tags">
          <span>LLM Pipelines</span>
          <span>RAG Search</span>
          <span>Predictive AI</span>
        </div>
        <a href="?page=ai-solutions" class="capability-link">
          <span>Explore AI Solutions</span>
          <i class="ri-arrow-right-line"></i>
        </a>
      </div>

      <!-- Capability 2: Software Engineering -->
      <div class="capability-card">
        <div class="capability-card-header">
          <div class="capability-icon"><i class="ri-code-box-line"></i></div>
          <span class="capability-num">02</span>
        </div>
        <h3 class="capability-title">Software Engineering</h3>
        <p class="capability-desc">
          Modern web platforms, scalable microservices, secure API architectures, and enterprise portals engineered with high code quality and zero bloat.
        </p>
        <div class="capability-tags">
          <span>Next.js / React</span>
          <span>Microservices</span>
          <span>High-Load APIs</span>
        </div>
        <a href="?page=web-development" class="capability-link">
          <span>Explore Software</span>
          <i class="ri-arrow-right-line"></i>
        </a>
      </div>

      <!-- Capability 3: Data & Analytics -->
      <div class="capability-card">
        <div class="capability-card-header">
          <div class="capability-icon"><i class="ri-bar-chart-2-line"></i></div>
          <span class="capability-num">03</span>
        </div>
        <h3 class="capability-title">Data & Analytics</h3>
        <p class="capability-desc">
          Centralized data warehouses, automated ETL pipelines, real-time telemetry, and executive BI dashboards turning raw data into strategic decisions.
        </p>
        <div class="capability-tags">
          <span>Data Warehousing</span>
          <span>ETL Pipelines</span>
          <span>BI Dashboards</span>
        </div>
        <a href="?page=data-analytics" class="capability-link">
          <span>Explore Analytics</span>
          <i class="ri-arrow-right-line"></i>
        </a>
      </div>

      <!-- Capability 4: Application Development -->
      <div class="capability-card">
        <div class="capability-card-header">
          <div class="capability-icon"><i class="ri-smartphone-line"></i></div>
          <span class="capability-num">04</span>
        </div>
        <h3 class="capability-title">Application Development</h3>
        <p class="capability-desc">
          Cross-platform mobile apps (iOS & Android), native software, and enterprise SaaS products featuring offline sync and fluid UX interfaces.
        </p>
        <div class="capability-tags">
          <span>React Native / Flutter</span>
          <span>iOS / Android</span>
          <span>SaaS Apps</span>
        </div>
        <a href="?page=app-development" class="capability-link">
          <span>Explore Applications</span>
          <i class="ri-arrow-right-line"></i>
        </a>
      </div>

      <!-- Capability 5: Cloud & Infrastructure -->
      <div class="capability-card">
        <div class="capability-card-header">
          <div class="capability-icon"><i class="ri-cloud-line"></i></div>
          <span class="capability-num">05</span>
        </div>
        <h3 class="capability-title">Cloud & Infrastructure</h3>
        <p class="capability-desc">
          Cloud-native migrations, container orchestration, automated CI/CD deployment pipelines, and 24/7 high-availability infrastructure management.
        </p>
        <div class="capability-tags">
          <span>AWS / Azure / GCP</span>
          <span>Kubernetes / Docker</span>
          <span>CI/CD DevOps</span>
        </div>
        <a href="?page=services" class="capability-link">
          <span>Explore Cloud</span>
          <i class="ri-arrow-right-line"></i>
        </a>
      </div>

      <!-- Capability 6: Digital Growth & Performance -->
      <div class="capability-card">
        <div class="capability-card-header">
          <div class="capability-icon"><i class="ri-line-chart-line"></i></div>
          <span class="capability-num">06</span>
        </div>
        <h3 class="capability-title">Digital Growth & Performance</h3>
        <p class="capability-desc">
          Conversion rate engineering, multi-touch attribution modeling, technical SEO architecture, and high-ROI digital acquisition strategies.
        </p>
        <div class="capability-tags">
          <span>Conversion CRO</span>
          <span>Marketing Attribution</span>
          <span>SEO Architecture</span>
        </div>
        <a href="?page=digital-marketing" class="capability-link">
          <span>Explore Growth</span>
          <i class="ri-arrow-right-line"></i>
        </a>
      </div>

    </div>
  </div>
</section>

<!-- =============================================================
     SECTION 4: FROM IDEA TO IMPACT (PROCESS TIMELINE)
     ============================================================= -->
<section class="section process-section">
  <div class="container">
    <div class="section-title">
      <span class="badge">Disciplined Methodology</span>
      <h2>From Idea <span class="gradient-text">→ Impact</span></h2>
      <p>A proven, transparent engineering roadmap engineered to eliminate risk, accelerate time-to-market, and deliver sustained growth.</p>
    </div>

    <!-- Timeline Wrapper -->
    <div class="process-timeline-wrap">
      
      <!-- Step 1 -->
      <div class="process-step-card">
        <div class="step-indicator">
          <span class="step-num">01</span>
          <div class="step-dot"></div>
        </div>
        <div class="step-body">
          <h4 class="step-title">Discover</h4>
          <p class="step-desc">Deep-dive into your business challenge, target users, data landscape, and core KPIs.</p>
          <div class="step-outcome">Strategic Blueprint</div>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="process-step-card">
        <div class="step-indicator">
          <span class="step-num">02</span>
          <div class="step-dot"></div>
        </div>
        <div class="step-body">
          <h4 class="step-title">Design</h4>
          <p class="step-desc">Architect the technical system blueprint, data models, cloud architecture, and intuitive UI/UX flows.</p>
          <div class="step-outcome">System Architecture</div>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="process-step-card">
        <div class="step-indicator">
          <span class="step-num">03</span>
          <div class="step-dot"></div>
        </div>
        <div class="step-body">
          <h4 class="step-title">Build</h4>
          <p class="step-desc">Engineer clean, scalable, high-performance software in rapid, transparent agile sprints.</p>
          <div class="step-outcome">Agile Production</div>
        </div>
      </div>

      <!-- Step 4 -->
      <div class="process-step-card">
        <div class="step-indicator">
          <span class="step-num">04</span>
          <div class="step-dot"></div>
        </div>
        <div class="step-body">
          <h4 class="step-title">Intelligently Enable</h4>
          <p class="step-desc">Integrate AI pipelines, machine learning models, and automated workflows where they generate maximum ROI.</p>
          <div class="step-outcome">AI & Automation</div>
        </div>
      </div>

      <!-- Step 5 -->
      <div class="process-step-card">
        <div class="step-indicator">
          <span class="step-num">05</span>
          <div class="step-dot"></div>
        </div>
        <div class="step-body">
          <h4 class="step-title">Scale & Optimize</h4>
          <p class="step-desc">Monitor real-time telemetry, optimize cloud infrastructure, and continuously expand performance.</p>
          <div class="step-outcome">Measurable Growth</div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- =============================================================
     SECTION 5: SOLUTIONS IN ACTION (REAL PROJECTS)
     ============================================================= -->
<section class="section solutions-action-section">
  <div class="container">
    <div class="section-title">
      <span class="badge">Solutions in Action</span>
      <h2>Technology Built Around <span class="gradient-text">Real Problems.</span></h2>
      <p>Explore a selection of high-impact platforms, AI workflows, and analytics architectures engineered by our team.</p>
    </div>

    <div class="case-studies-grid">
      <?php if (!empty($featuredProjects)): ?>
        <?php foreach ($featuredProjects as $p): ?>
          <div class="case-study-card">
            <div class="case-study-img-wrap">
              <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" class="case-study-img" loading="lazy">
              <span class="case-study-badge"><?= htmlspecialchars($p['category']) ?></span>
            </div>
            
            <div class="case-study-content">
              <h3 class="case-study-title"><?= htmlspecialchars($p['title']) ?></h3>
              
              <div class="case-study-breakdown">
                <div class="breakdown-item">
                  <span class="breakdown-label challenge-label"><i class="ri-alert-line"></i> Challenge</span>
                  <p class="breakdown-text"><?= htmlspecialchars($p['challenge'] ?? $p['description']) ?></p>
                </div>
                <div class="breakdown-item">
                  <span class="breakdown-label solution-label"><i class="ri-check-double-line"></i> Orbitone Solution</span>
                  <p class="breakdown-text"><?= htmlspecialchars($p['solution'] ?? 'Custom scalable digital architecture.') ?></p>
                </div>
              </div>

              <div class="case-study-tech">
                <span class="tech-label">Stack:</span>
                <span class="tech-val"><?= htmlspecialchars($p['tech_stack']) ?></span>
              </div>

              <?php if (!empty($p['results'])): ?>
                <div class="case-study-outcome">
                  <i class="ri-line-chart-fill"></i>
                  <span><?= htmlspecialchars($p['results']) ?></span>
                </div>
              <?php endif; ?>

              <div style="margin-top: 1.25rem;">
                <button class="btn btn-secondary btn-sm btn-full" onclick="openProjectModal(<?= htmlspecialchars(json_encode($p)) ?>)">
                  <span>View Case Study Breakdown</span>
                  <i class="ri-arrow-right-line"></i>
                </button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Fallback Static High Impact Card if DB empty -->
        <div class="case-study-card">
          <div class="case-study-img-wrap">
            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80" alt="FinTech AI Engine" class="case-study-img">
            <span class="case-study-badge">AI Solutions</span>
          </div>
          <div class="case-study-content">
            <h3 class="case-study-title">Neural Analytics & Fraud Prevention Engine</h3>
            <div class="case-study-breakdown">
              <div class="breakdown-item">
                <span class="breakdown-label challenge-label"><i class="ri-alert-line"></i> Challenge</span>
                <p class="breakdown-text">Legacy batch processing caused delayed transaction risk scoring and high false-positive fraud alerts.</p>
              </div>
              <div class="breakdown-item">
                <span class="breakdown-label solution-label"><i class="ri-check-double-line"></i> Orbitone Solution</span>
                <p class="breakdown-text">Architected a real-time stream ML pipeline delivering sub-50ms inference with automated risk alerting.</p>
              </div>
            </div>
            <div class="case-study-tech">
              <span class="tech-label">Stack:</span>
              <span class="tech-val">Python, PyTorch, Kafka, FastAPI, React, PostgreSQL</span>
            </div>
            <div class="case-study-outcome">
              <i class="ri-line-chart-fill"></i>
              <span>99.4% detection accuracy & $4.2M saved in prevented fraud losses</span>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <div style="text-align: center; margin-top: 3rem;">
      <a href="?page=projects" class="btn btn-secondary">
        <span>View All Projects & Case Studies</span>
        <i class="ri-arrow-right-line"></i>
      </a>
    </div>
  </div>
</section>

<!-- =============================================================
     SECTION 6: INDUSTRIES SECTION
     ============================================================= -->
<section class="section industries-showcase-section">
  <div class="container">
    <div class="section-title">
      <span class="badge">Sector Expertise</span>
      <h2>Technology for <span class="gradient-text">Every Ambition.</span></h2>
      <p>Domain-specific architectures and intelligent digital engineering built to solve the distinct challenges of high-growth industries.</p>
    </div>

    <div class="industries-grid">
      
      <!-- Industry 1: Finance & FinTech -->
      <div class="industry-card">
        <div class="industry-icon"><i class="ri-bank-card-line"></i></div>
        <h4 class="industry-title">Finance & FinTech</h4>
        <p class="industry-desc">High-frequency trading pipelines, fraud analytics, KYC/AML automation, and secure payment integrations.</p>
        <div class="industry-pills">
          <span>Sub-50ms APIs</span>
          <span>Fraud ML</span>
          <span>PCI Compliance</span>
        </div>
      </div>

      <!-- Industry 2: Healthcare & Biotech -->
      <div class="industry-card">
        <div class="industry-icon"><i class="ri-heart-pulse-line"></i></div>
        <h4 class="industry-title">Healthcare & HealthTech</h4>
        <p class="industry-desc">HIPAA-ready patient portals, remote health telemetry, medical record NLP, and clinical workflow optimization.</p>
        <div class="industry-pills">
          <span>HIPAA Vaults</span>
          <span>Patient Telemetry</span>
          <span>Clinical NLP</span>
        </div>
      </div>

      <!-- Industry 3: Retail & E-Commerce -->
      <div class="industry-card">
        <div class="industry-icon"><i class="ri-shopping-bag-3-line"></i></div>
        <h4 class="industry-title">Retail & E-Commerce</h4>
        <p class="industry-desc">Headless commerce architectures, AI personalized recommendation engines, and inventory demand forecasting.</p>
        <div class="industry-pills">
          <span>Headless Next.js</span>
          <span>AI Recommenders</span>
          <span>Inventory Sync</span>
        </div>
      </div>

      <!-- Industry 4: Manufacturing & Logistics -->
      <div class="industry-card">
        <div class="industry-icon"><i class="ri-truck-line"></i></div>
        <h4 class="industry-title">Manufacturing & Logistics</h4>
        <p class="industry-desc">Fleet geospatial tracking, predictive equipment maintenance models, and automated supply chain telemetry.</p>
        <div class="industry-pills">
          <span>IoT Telemetry</span>
          <span>Route Optimization</span>
          <span>Asset Tracking</span>
        </div>
      </div>

      <!-- Industry 5: Education & EdTech -->
      <div class="industry-card">
        <div class="industry-icon"><i class="ri-graduation-cap-line"></i></div>
        <h4 class="industry-title">Education & EdTech</h4>
        <p class="industry-desc">Interactive learning management systems, automated student assessment pipelines, and institutional analytics.</p>
        <div class="industry-pills">
          <span>LMS Architecture</span>
          <span>Adaptive Testing</span>
          <span>Engagement BI</span>
        </div>
      </div>

      <!-- Industry 6: Startups & High-Growth SaaS -->
      <div class="industry-card">
        <div class="industry-icon"><i class="ri-rocket-2-line"></i></div>
        <h4 class="industry-title">Startups & SaaS</h4>
        <p class="industry-desc">Rapid MVP to enterprise scalability, multi-tenant cloud architectures, automated billing, and fast sprint execution.</p>
        <div class="industry-pills">
          <span>Multi-Tenant DB</span>
          <span>Rapid MVP</span>
          <span>Cloud Scaling</span>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- =============================================================
     SECTION 7: WHY ORBITONE? SECTION
     ============================================================= -->
<section class="section why-orbitone-section">
  <div class="container">
    <div class="section-title">
      <span class="badge">Our Competitive Edge</span>
      <h2>More Than a <span class="gradient-text">Technology Vendor.</span></h2>
      <p>We combine engineering depth, intelligent systems, and digital strategy to build solutions that solve real business problems.</p>
    </div>

    <div class="why-grid">
      
      <div class="why-card">
        <div class="why-icon-wrap"><i class="ri-focus-2-line"></i></div>
        <h3 class="why-title">Business-First Thinking</h3>
        <p class="why-desc">
          We don't build technology for the sake of technology. Every line of code, database schema, and automation workflow is explicitly mapped to your revenue, efficiency, and growth goals.
        </p>
      </div>

      <div class="why-card">
        <div class="why-icon-wrap"><i class="ri-stack-line"></i></div>
        <h3 class="why-title">Scalable Engineering</h3>
        <p class="why-desc">
          Our software architectures are built on clean, modular, and cloud-native principles that scale effortlessly with your user growth while preventing technical debt.
        </p>
      </div>

      <div class="why-card">
        <div class="why-icon-wrap"><i class="ri-cpu-line"></i></div>
        <h3 class="why-title">AI-Ready Architecture</h3>
        <p class="why-desc">
          From custom LLM integrations to predictive machine learning pipelines, we build systems designed from day one to harness artificial intelligence and automated workflows.
        </p>
      </div>

      <div class="why-card">
        <div class="why-icon-wrap"><i class="ri-hand-coin-line"></i></div>
        <h3 class="why-title">End-to-End Partnership</h3>
        <p class="why-desc">
          We stay with you beyond launch. From initial concept discovery and architecture to continuous deployment, performance telemetry, and proactive scaling.
        </p>
      </div>

    </div>
  </div>
</section>

<!-- =============================================================
     SECTION 8: PREMIUM FINAL CONVERSION CTA
     ============================================================= -->
<section class="final-cta-section">
  <div class="container">
    <div class="final-cta-card">
      <div class="final-cta-ambient"></div>
      
      <div class="final-cta-content">
        <span class="badge badge-gold-inverse">
          <span class="pulse-dot"></span>
          <span>Let's Connect</span>
        </span>
        
        <h2 class="final-cta-title">
          Have a Problem <span class="gradient-text">Worth Solving?</span>
        </h2>
        
        <p class="final-cta-desc">
          Tell us what you're building, improving, or trying to solve. We'll help you turn it into a scalable, high-performance digital solution.
        </p>

        <div class="final-cta-actions">
          <a href="?page=quote" class="btn btn-primary btn-cta-primary">
            <span>Let's Build Something</span>
            <i class="ri-arrow-right-line"></i>
          </a>
          <a href="?page=contact" class="btn btn-cta-secondary">
            <span>Talk to Our Team</span>
            <i class="ri-chat-1-line"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Case Study Modal Logic -->
<script>
  function openProjectModal(p) {
    if (typeof showModal === 'function') {
      showModal(p.title, `
        <div style="margin-bottom: 1.5rem;">
          <img src="${p.image_url}" style="width: 100%; height: 260px; object-fit: cover; border-radius: 12px; margin-bottom: 1.5rem;">
          <span class="badge">${p.category}</span>
          
          <div style="margin: 1.25rem 0;">
            <h4 style="color: #d97706; text-transform: uppercase; font-size: 0.8rem; font-weight: 800; letter-spacing: 0.05em;">The Challenge</h4>
            <p style="color: var(--text-muted); margin-top: 0.35rem; line-height: 1.6;">${p.challenge || p.description}</p>
          </div>

          <div style="margin-bottom: 1.25rem;">
            <h4 style="color: var(--navy-dark); text-transform: uppercase; font-size: 0.8rem; font-weight: 800; letter-spacing: 0.05em;">Orbitone Solution</h4>
            <p style="color: var(--text-muted); margin-top: 0.35rem; line-height: 1.6;">${p.solution || 'Architected high-performance cloud platform.'}</p>
          </div>

          <div style="margin-bottom: 1.25rem;">
            <h4 style="color: var(--purple); text-transform: uppercase; font-size: 0.8rem; font-weight: 800; letter-spacing: 0.05em;">Technologies Used</h4>
            <p style="color: var(--gold-dark); font-weight: 700; margin-top: 0.35rem;">${p.tech_stack}</p>
          </div>

          ${p.results ? `
            <div style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.3); padding: 1.15rem; border-radius: 10px;">
              <h4 style="color: var(--emerald); text-transform: uppercase; font-size: 0.8rem; font-weight: 800;">Measurable Results</h4>
              <p style="color: var(--navy-dark); font-weight: 700; margin-top: 0.35rem;">${p.results}</p>
            </div>
          ` : ''}
        </div>
      `);
    }
  }
</script>
