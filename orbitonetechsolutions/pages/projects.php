<!-- Orbitone Tech Solutions - Projects / Portfolio Page -->
<?php
$db = getDB();
$stmt = $db->query("SELECT * FROM projects ORDER BY featured DESC, id DESC");
$projects = $stmt->fetchAll();
?>

<section class="section" style="padding-top: 3.5rem;">
  <div class="container">
    <div class="section-title">
      <span class="badge">Case Studies</span>
      <h2>Ideas We've Turned Into <span class="gradient-text">Digital Experiences</span></h2>
      <p>Explore a selection of high-impact software applications, AI models, and performance marketing campaigns we've engineered.</p>
    </div>

    <!-- Category Filters -->
    <div class="filter-tabs">
      <button class="filter-btn active" data-filter="all">All Projects</button>
      <button class="filter-btn" data-filter="Web">Web Development</button>
      <button class="filter-btn" data-filter="Applications">Applications</button>
      <button class="filter-btn" data-filter="AI">AI Solutions</button>
      <button class="filter-btn" data-filter="Analytics">Data Analytics</button>
      <button class="filter-btn" data-filter="Digital Marketing">Digital Marketing</button>
    </div>

    <!-- Portfolio Grid -->
    <div class="portfolio-grid">
      <?php foreach ($projects as $p): ?>
        <div class="portfolio-card" data-category="<?= htmlspecialchars($p['category']) ?>">
          <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" class="portfolio-img" loading="lazy">
          <div class="portfolio-body">
            <div class="portfolio-cat"><?= htmlspecialchars($p['category']) ?></div>
            <h3 class="portfolio-title"><?= htmlspecialchars($p['title']) ?></h3>
            <p class="portfolio-desc"><?= htmlspecialchars($p['description']) ?></p>

            <div style="margin-bottom: 1.25rem;">
              <div style="font-size: 0.75rem; color: var(--text-dim); text-transform: uppercase; margin-bottom: 0.35rem; font-weight: 700;">Tech Stack</div>
              <div style="font-size: 0.85rem; color: var(--gold-dark); font-weight: 700;">
                <?= htmlspecialchars($p['tech_stack']) ?>
              </div>
            </div>

            <button class="btn btn-secondary btn-sm btn-full" onclick="openProjectModal(<?= htmlspecialchars(json_encode($p)) ?>)">
              <span>View Case Study</span>
              <i class="ri-arrow-right-line"></i>
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<script>
  function openProjectModal(p) {
    showModal(p.title, `
      <div style="margin-bottom: 1.5rem;">
        <img src="${p.image_url}" style="width: 100%; height: 240px; object-fit: cover; border-radius: 12px; margin-bottom: 1.5rem;">
        <span class="badge">${p.category}</span>
        
        <div style="margin: 1.25rem 0;">
          <h4 style="color: #d97706; text-transform: uppercase; font-size: 0.8rem; font-weight: 800;">The Challenge</h4>
          <p style="color: var(--text-muted); margin-top: 0.25rem;">${p.challenge || 'High operational friction and delayed data processing.'}</p>
        </div>

        <div style="margin-bottom: 1.25rem;">
          <h4 style="color: var(--navy-dark); text-transform: uppercase; font-size: 0.8rem; font-weight: 800;">Orbitone Solution</h4>
          <p style="color: var(--text-muted); margin-top: 0.25rem;">${p.solution || 'Architected scalable software pipeline.'}</p>
        </div>

        <div style="margin-bottom: 1.25rem;">
          <h4 style="color: var(--purple); text-transform: uppercase; font-size: 0.8rem; font-weight: 800;">Technologies Used</h4>
          <p style="color: var(--gold-dark); font-weight: 700; margin-top: 0.25rem;">${p.tech_stack}</p>
        </div>

        <div style="background: rgba(16, 185, 129, 0.1); border: 1px dashed var(--emerald); padding: 1rem; border-radius: 8px;">
          <h4 style="color: var(--emerald); text-transform: uppercase; font-size: 0.8rem; font-weight: 800;">Measurable Results</h4>
          <p style="color: var(--navy-dark); font-weight: 700; margin-top: 0.25rem;">${p.results || '99%+ efficiency boost.'}</p>
        </div>
      </div>
    `);
  }
</script>
