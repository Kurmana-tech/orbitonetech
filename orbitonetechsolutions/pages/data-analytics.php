<!-- Orbitone Tech Solutions - Data Analytics Page -->

<section class="section">
  <div class="container">
    <div class="section-title">
      <span class="badge">Business Intelligence</span>
      <h2>Turn Data Into <span class="gradient-text">Decisions</span></h2>
      <p>Businesses generate enormous amounts of data. We help transform that raw data into actionable insights through analytics, visualization and executive reporting.</p>
    </div>

    <!-- Live Interactive Mock Dashboard -->
    <div class="dashboard-demo-box" style="margin-bottom: 4rem;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
          <h3 style="font-size: 1.4rem;">Live Business Intelligence Analytics Console</h3>
          <p style="font-size: 0.85rem; color: var(--text-muted);">Real-time telemetry stream simulator</p>
        </div>
        <div class="dash-controls">
          <button class="dash-tab active" data-metric="revenue">Revenue Stream</button>
          <button class="dash-tab" data-metric="customers">Customer Acquisition</button>
          <button class="dash-tab" data-metric="conversion">Conversion Funnel</button>
          <button class="dash-tab" data-metric="performance">System Performance</button>
        </div>
      </div>

      <!-- Stats Metric Cards -->
      <div class="dash-stats-row">
        <div class="stat-box">
          <div class="label">Gross Revenue</div>
          <div class="value" id="dashValRevenue">$1.48M</div>
          <div class="change"><i class="ri-arrow-up-line"></i> +34.2% MoM</div>
        </div>

        <div class="stat-box">
          <div class="label">Active Customers</div>
          <div class="value" id="dashValCustomers">14,250</div>
          <div class="change"><i class="ri-arrow-up-line"></i> +18.6% MoM</div>
        </div>

        <div class="stat-box">
          <div class="label">Quarterly Growth</div>
          <div class="value" id="dashValGrowth">+34.2%</div>
          <div class="change"><i class="ri-arrow-up-line"></i> Exceeding Target</div>
        </div>

        <div class="stat-box">
          <div class="label">Avg Conversion</div>
          <div class="value" id="dashValConv">4.85%</div>
          <div class="change"><i class="ri-arrow-up-line"></i> +1.2% Optimization</div>
        </div>
      </div>

      <!-- Live Dynamic Chart Mock -->
      <div class="dash-chart-mock">
        <div class="bar-col" style="height: 40%;" data-value="40%"></div>
        <div class="bar-col" style="height: 65%;" data-value="65%"></div>
        <div class="bar-col" style="height: 80%;" data-value="80%"></div>
        <div class="bar-col" style="height: 55%;" data-value="55%"></div>
        <div class="bar-col" style="height: 90%;" data-value="90%"></div>
        <div class="bar-col" style="height: 75%;" data-value="75%"></div>
        <div class="bar-col" style="height: 100%;" data-value="100%"></div>
      </div>
      <div style="display: flex; justify-content: space-around; font-size: 0.8rem; color: var(--text-dim); margin-top: 0.75rem;">
        <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
      </div>
    </div>

    <!-- Data Services Grid -->
    <div class="section-title">
      <span class="badge">Data Spectrum</span>
      <h2>Data Analytics Services</h2>
      <p>Unifying fragmented database tables into structured, actionable insights.</p>
    </div>

    <div class="feature-grid">
      <!-- Feature 1: Data Cleaning & Preprocessing -->
      <div class="feature-card">
        <div class="feature-card-header">
          <div class="feature-icon-wrap">
            <svg class="feature-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 7H20M7 12H17M10 17H14" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" />
              <circle cx="17" cy="12" r="1.5" fill="#d97706" />
            </svg>
          </div>
          <h4 class="feature-card-title">Data Cleaning & Preprocessing</h4>
        </div>
        <p class="feature-card-desc">Automated removal of duplicates, missing value imputation, and schema standardization.</p>
      </div>

      <!-- Feature 2: Automated Data Pipelines (ETL) -->
      <div class="feature-card">
        <div class="feature-card-header">
          <div class="feature-icon-wrap">
            <svg class="feature-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="6" cy="6" r="3" stroke="currentColor" stroke-width="1.75" />
              <circle cx="18" cy="18" r="3" stroke="currentColor" stroke-width="1.75" />
              <path d="M6 9V14C6 15.6569 7.34315 17 9 17H15" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
              <polyline points="13,15 15,17 13,19" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
              <circle cx="6" cy="6" r="1" fill="#d97706" />
              <circle cx="18" cy="18" r="1" fill="#d97706" />
            </svg>
          </div>
          <h4 class="feature-card-title">Automated Data Pipelines (ETL)</h4>
        </div>
        <p class="feature-card-desc">Scheduled data ingestion workflows connecting Snowflake, PostgreSQL, BigQuery, and APIs.</p>
      </div>

      <!-- Feature 3: Interactive Data Visualization -->
      <div class="feature-card">
        <div class="feature-card-header">
          <div class="feature-icon-wrap">
            <svg class="feature-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.75"/>
              <path d="M7 16L11 12L14 15L17 9" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
              <circle cx="17" cy="9" r="1.5" fill="#d97706" />
            </svg>
          </div>
          <h4 class="feature-card-title">Interactive Data Visualization</h4>
        </div>
        <p class="feature-card-desc">Custom executive BI dashboards built in Power BI, Tableau, and embedded React chart frameworks.</p>
      </div>

      <!-- Feature 4: Business Intelligence (BI) -->
      <div class="feature-card">
        <div class="feature-card-header">
          <div class="feature-icon-wrap">
            <svg class="feature-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <ellipse cx="12" cy="6" rx="8" ry="3" stroke="currentColor" stroke-width="1.75"/>
              <path d="M4 6V12C4 13.6569 7.58172 15 12 15C16.4183 15 20 13.6569 20 12V6" stroke="currentColor" stroke-width="1.75"/>
              <path d="M4 12V18C4 19.6569 7.58172 21 12 21C16.4183 21 20 19.6569 20 18V12" stroke="currentColor" stroke-width="1.75"/>
              <circle cx="16" cy="18" r="1.5" fill="#d97706" />
            </svg>
          </div>
          <h4 class="feature-card-title">Business Intelligence (BI)</h4>
        </div>
        <p class="feature-card-desc">Consolidate sales, operations, and financial metrics into a single unified executive view.</p>
      </div>

      <!-- Feature 5: Predictive Data Analytics -->
      <div class="feature-card">
        <div class="feature-card-header">
          <div class="feature-icon-wrap">
            <svg class="feature-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="currentColor" stroke-width="1.75" stroke-linejoin="round"/>
              <circle cx="12" cy="11" r="2" fill="#d97706" />
            </svg>
          </div>
          <h4 class="feature-card-title">Predictive Data Analytics</h4>
        </div>
        <p class="feature-card-desc">Leverage statistical models to anticipate market trends, seasonal demand, and customer behavior.</p>
      </div>

      <!-- Feature 6: KPI Tracking & Automated Alerts -->
      <div class="feature-card">
        <div class="feature-card-header">
          <div class="feature-icon-wrap">
            <svg class="feature-icon-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M18 8A6 6 0 0 0 6 8C6 15 3 17 3 17H21S18 15 18 8" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M13.73 21A2 2 0 0 1 10.27 21" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
              <circle cx="18" cy="6" r="2" fill="#d97706" />
            </svg>
          </div>
          <h4 class="feature-card-title">KPI Tracking & Automated Alerts</h4>
        </div>
        <p class="feature-card-desc">Real-time Slack/Email alerts triggered when performance metrics breach operational thresholds.</p>
      </div>
    </div>
  </div>
</section>
