<!-- Orbitone Tech Solutions - Industries Page -->

<section class="section">
  <div class="container">
    <div class="section-title">
      <span class="badge">Sector Expertise</span>
      <h2>Tailored Solutions Across <span class="gradient-text">Industries</span></h2>
      <p>We don't offer generic IT templates. We craft industry-specific architectures that solve distinct market challenges.</p>
    </div>

    <!-- Interactive Industry Matrix -->
    <div style="display: grid; grid-template-columns: 280px 1fr; gap: 2rem; margin-bottom: 4rem;">
      <!-- Vertical Tabs -->
      <div style="display: flex; flex-direction: column; gap: 0.5rem;" id="indTabContainer">
        <button class="dash-tab active" style="text-align: left; width: 100%; padding: 0.85rem 1rem;" onclick="selectIndustry('fintech')"><i class="ri-bank-card-line"></i> Finance & FinTech</button>
        <button class="dash-tab" style="text-align: left; width: 100%; padding: 0.85rem 1rem;" onclick="selectIndustry('healthcare')"><i class="ri-hospital-line"></i> Healthcare & HealthTech</button>
        <button class="dash-tab" style="text-align: left; width: 100%; padding: 0.85rem 1rem;" onclick="selectIndustry('ecommerce')"><i class="ri-shopping-bag-line"></i> E-Commerce & Retail</button>
        <button class="dash-tab" style="text-align: left; width: 100%; padding: 0.85rem 1rem;" onclick="selectIndustry('education')"><i class="ri-book-open-line"></i> Education & EdTech</button>
        <button class="dash-tab" style="text-align: left; width: 100%; padding: 0.85rem 1rem;" onclick="selectIndustry('realestate')"><i class="ri-building-line"></i> Real Estate</button>
        <button class="dash-tab" style="text-align: left; width: 100%; padding: 0.85rem 1rem;" onclick="selectIndustry('manufacturing')"><i class="ri-tools-line"></i> Manufacturing</button>
        <button class="dash-tab" style="text-align: left; width: 100%; padding: 0.85rem 1rem;" onclick="selectIndustry('startups')"><i class="ri-rocket-line"></i> High-Growth Startups</button>
      </div>

      <!-- Detail Card Display -->
      <div class="glass-card" id="indDetailCard">
        <!-- Content dynamically injected via JS -->
      </div>
    </div>

    <script>
      const industryData = {
        fintech: {
          title: "Finance & FinTech Solutions",
          challenge: "High transaction friction, legacy mainframe latency, rigid compliance demands, and elevated risk of digital fraud.",
          solution: "Sub-50ms automated fraud scoring ML models, open banking API integrations, and secure PCI-DSS compliant web portals.",
          tech: "Python, PyTorch, Node.js, PostgreSQL, Apache Kafka, React",
          results: "99.4% fraud detection accuracy and 4.2x faster loan application processing."
        },
        healthcare: {
          title: "Healthcare & HealthTech Solutions",
          challenge: "Fragmented patient health records, emergency room scheduling delays, and strict HIPAA regulatory barriers.",
          solution: "AI clinical documentation parsing, predictive patient readmission algorithms, and HIPAA-compliant telehealth portals.",
          tech: "Python, TensorFlow, HL7/FHIR API, FastAPI, React Native",
          results: "38% reduction in patient wait times and 100% compliance audit readiness."
        },
        ecommerce: {
          title: "E-Commerce & Retail Solutions",
          challenge: "High shopping cart abandonment rates, slow mobile web rendering, and un-optimized ad spend.",
          solution: "Headless Next.js storefronts, AI product recommendation engines, and full-funnel remarketing campaigns.",
          tech: "React, Next.js, Node.js, MongoDB, Redis, Google Ads",
          results: "45% increase in mobile checkout conversion rate and 3.2x faster page loads."
        },
        education: {
          title: "Education & EdTech Solutions",
          challenge: "Disengaged remote learners, complex LMS administration, and lack of real-time student performance tracking.",
          solution: "Interactive web learning portals, automated grading tools, and gamified student progress analytics.",
          tech: "React, WebSockets, PHP, MySQL, AWS Cloud",
          results: "85% student retention boost and 60% faster assignment evaluation times."
        },
        realestate: {
          title: "Real Estate & PropTech Solutions",
          challenge: "Inaccurate property lead scoring, manual client follow-ups, and static image property listings.",
          solution: "Virtual property tour web apps, AI CRM lead distribution, and automated ad campaign management.",
          tech: "React, WebGL, Node.js, PostgreSQL, Google Maps API",
          results: "3x increase in qualified buyer tours and 40% reduction in sales cycle duration."
        },
        manufacturing: {
          title: "Manufacturing & Industry 4.0 Solutions",
          challenge: "Unplanned equipment downtime, manual inventory tracking, and supply chain visibility gaps.",
          solution: "IoT telemetry analytics dashboards, predictive maintenance algorithms, and mobile fleet management.",
          tech: "Python, Power BI, SQL, React Native, MQTT",
          results: "28% reduction in unexpected equipment maintenance downtime."
        },
        startups: {
          title: "High-Growth Startup MVP Solutions",
          challenge: "Tight investor deadlines, limited capital, and the need to rapidly validate market fit.",
          solution: "Rapid 6-week MVP prototype development, scalable serverless architecture, and growth marketing.",
          tech: "React, Node.js, Firebase, Tailwind, Google Ads",
          results: "Successfully helped 12+ startups raise seed and Series-A funding rounds."
        }
      };

      function selectIndustry(key) {
        const data = industryData[key];
        if (!data) return;

        // Update tab active styling
        const btns = document.querySelectorAll('#indTabContainer button');
        btns.forEach(b => b.classList.remove('active'));
        event.currentTarget.classList.add('active');

        // Update content card
        const card = document.getElementById('indDetailCard');
        card.innerHTML = `
          <h3 style="font-size: 1.6rem; color: var(--cyan); margin-bottom: 1.5rem;">${data.title}</h3>
          
          <div style="margin-bottom: 1.25rem;">
            <strong style="color: #ef4444; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.05em;">The Challenge</strong>
            <p style="color: var(--text-muted); margin-top: 0.25rem;">${data.challenge}</p>
          </div>

          <div style="margin-bottom: 1.25rem;">
            <strong style="color: var(--cyan); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.05em;">Orbitone Solution</strong>
            <p style="color: var(--text-muted); margin-top: 0.25rem;">${data.solution}</p>
          </div>

          <div style="margin-bottom: 1.25rem;">
            <strong style="color: var(--purple); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.05em;">Technologies Used</strong>
            <div style="margin-top: 0.5rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
              ${data.tech.split(', ').map(t => `<span class="eco-tag">${t}</span>`).join('')}
            </div>
          </div>

          <div style="background: rgba(16, 185, 129, 0.1); border: 1px dashed var(--emerald); padding: 1rem; border-radius: 8px;">
            <strong style="color: var(--emerald); text-transform: uppercase; font-size: 0.8rem;">Measurable Impact</strong>
            <div style="color: var(--navy-dark); font-weight: 700; margin-top: 0.25rem;">${data.results}</div>
          </div>
        `;
      }

      // Initialize default
      document.addEventListener('DOMContentLoaded', () => {
        const firstTab = document.querySelector('#indTabContainer button');
        if (firstTab) firstTab.click();
      });
    </script>
  </div>
</section>
