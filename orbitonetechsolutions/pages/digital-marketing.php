<!-- Orbitone Tech Solutions - Digital Marketing Page -->

<section class="section">
  <div class="container">
    <div class="section-title">
      <span class="badge">Growth Marketing</span>
      <h2>Get Found. Get Noticed. <span class="gradient-text">Grow.</span></h2>
      <p>Data-driven SEO, SEM, and social media campaigns designed to improve online visibility, audience engagement, and sales conversions.</p>
    </div>

    <!-- 3 Pillar Marketing Services -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-bottom: 4rem;">
      <!-- SEO Pillar -->
      <div class="glass-card">
        <div class="service-icon"><i class="ri-search-eye-line" style="font-size: 1.75rem;"></i></div>
        <h3>Search Engine Optimization (SEO)</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.25rem;">Dominate organic search rankings and drive high-intent traffic.</p>
        <ul style="list-style: none; font-size: 0.85rem; color: var(--text-muted); display: flex; flex-direction: column; gap: 0.5rem;">
          <li><i class="ri-check-line" style="color: var(--cyan);"></i> In-Depth Keyword Research</li>
          <li><i class="ri-check-line" style="color: var(--cyan);"></i> On-Page SEO & Content Audits</li>
          <li><i class="ri-check-line" style="color: var(--cyan);"></i> Technical SEO & Page Speed</li>
          <li><i class="ri-check-line" style="color: var(--cyan);"></i> Schema Markup & Indexing</li>
          <li><i class="ri-check-line" style="color: var(--cyan);"></i> Local SEO & Google Business</li>
        </ul>
      </div>

      <!-- SEM Pillar -->
      <div class="glass-card">
        <div class="service-icon"><i class="ri-advertisement-line" style="font-size: 1.75rem;"></i></div>
        <h3>Search Engine Marketing (SEM)</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.25rem;">Instant targeted leads through hyper-focused PPC advertising.</p>
        <ul style="list-style: none; font-size: 0.85rem; color: var(--text-muted); display: flex; flex-direction: column; gap: 0.5rem;">
          <li><i class="ri-check-line" style="color: var(--primary);"></i> Google Ads Search Campaigns</li>
          <li><i class="ri-check-line" style="color: var(--primary);"></i> High-Converting Remarketing</li>
          <li><i class="ri-check-line" style="color: var(--primary);"></i> Google Shopping & Display</li>
          <li><i class="ri-check-line" style="color: var(--primary);"></i> Negative Keyword Hygiene</li>
          <li><i class="ri-check-line" style="color: var(--primary);"></i> Bid Strategy Optimization</li>
        </ul>
      </div>

      <!-- Social Media Pillar -->
      <div class="glass-card">
        <div class="service-icon"><i class="ri-share-forward-line" style="font-size: 1.75rem;"></i></div>
        <h3>Social Media Marketing</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.25rem;">Build brand equity and convert followers into loyal customers.</p>
        <ul style="list-style: none; font-size: 0.85rem; color: var(--text-muted); display: flex; flex-direction: column; gap: 0.5rem;">
          <li><i class="ri-check-line" style="color: var(--purple);"></i> LinkedIn B2B Ad Strategies</li>
          <li><i class="ri-check-line" style="color: var(--purple);"></i> Instagram & Facebook Ads</li>
          <li><i class="ri-check-line" style="color: var(--purple);"></i> Strategic Content Creation</li>
          <li><i class="ri-check-line" style="color: var(--purple);"></i> Campaign Analytics Tracking</li>
          <li><i class="ri-check-line" style="color: var(--purple);"></i> Audience Demographics Tuning</li>
        </ul>
      </div>
    </div>

    <!-- Interactive Marketing Campaign Growth Calculator -->
    <div class="glass-card" style="border-color: var(--cyan); margin-bottom: 4rem;">
      <h3 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
        <i class="ri-calculator-line" style="color: var(--cyan);"></i> Digital Marketing Campaign ROI Estimator
      </h3>
      <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 2rem;">Adjust the monthly ad spend to estimate potential lead volume and revenue growth:</p>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: center;">
        <div>
          <div class="form-group">
            <label class="form-label" style="display: flex; justify-content: space-between;">
              <span>Monthly Ad Budget:</span>
              <strong id="roiSpendVal" style="color: var(--cyan); font-size: 1.2rem;">₹50,000 / mo</strong>
            </label>
            <input type="range" id="roiSpendRange" min="10000" max="500000" step="10000" value="50000" style="width: 100%; accent-color: var(--cyan);">
          </div>
        </div>

        <div style="background: #ffffff; border: 1px solid rgba(11, 25, 44, 0.08); border-radius: var(--radius-md); padding: 1.5rem; display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
          <div>
            <div style="font-size: 0.8rem; color: var(--navy-dark); font-weight: 700; text-transform: uppercase;">Est. Monthly Clicks</div>
            <div id="roiClicks" style="font-size: 1.8rem; font-weight: 800; color: var(--gold-dark);">1,660</div>
          </div>
          <div>
            <div style="font-size: 0.8rem; color: var(--navy-dark); font-weight: 700; text-transform: uppercase;">Est. Qualified Leads</div>
            <div id="roiLeads" style="font-size: 1.8rem; font-weight: 800; color: var(--emerald);">115</div>
          </div>
        </div>
      </div>
    </div>

    <script>
      const range = document.getElementById('roiSpendRange');
      const valDisp = document.getElementById('roiSpendVal');
      const clicksDisp = document.getElementById('roiClicks');
      const leadsDisp = document.getElementById('roiLeads');

      if (range) {
        range.addEventListener('input', (e) => {
          const val = parseInt(e.target.value);
          valDisp.textContent = '₹' + val.toLocaleString('en-IN') + ' / mo';
          const clicks = Math.round(val / 30);
          const leads = Math.round(clicks * 0.07);
          clicksDisp.textContent = clicks.toLocaleString('en-IN');
          leadsDisp.textContent = leads.toLocaleString('en-IN');
        });
      }
    </script>

    <div style="text-align: center;">
      <a href="?page=quote" class="btn btn-primary" style="padding: 1rem 2.25rem; font-size: 1.1rem;">Grow My Business &rarr;</a>
    </div>
  </div>
</section>
