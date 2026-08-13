<!-- Orbitone Tech Solutions - Blog / Insights Page -->
<?php
$db = getDB();
$stmt = $db->query("SELECT * FROM blog_posts ORDER BY published_at DESC");
$blogs = $stmt->fetchAll();
?>

<section class="section" style="padding-top: 3.5rem;">
  <div class="container">
    <div class="section-title">
      <span class="badge">Thought Leadership</span>
      <h2>Ideas, Insights & <span class="gradient-text">Technology</span></h2>
      <p>Perspectives from our engineers and strategists on AI architecture, data engineering, and digital growth.</p>
    </div>

    <!-- Search Bar & Filters -->
    <div style="max-width: 600px; margin: 0 auto 3rem auto;">
      <div style="position: relative;">
        <input type="text" id="blogSearchInput" class="form-control" placeholder="Search articles by keyword or topic..." style="padding-left: 3.2rem; font-size: 1rem; border-radius: 9999px; height: 52px; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
        <i class="ri-search-line" style="position: absolute; left: 1.35rem; top: 50%; transform: translateY(-50%); color: var(--gold-dark); font-size: 1.25rem;"></i>
      </div>
    </div>

    <div class="blog-grid" id="blogGrid">
      <?php foreach ($blogs as $b): ?>
        <div class="blog-card" data-category="<?= htmlspecialchars($b['category']) ?>" data-title="<?= htmlspecialchars(strtolower($b['title'])) ?>">
          <img src="<?= htmlspecialchars($b['image_url']) ?>" alt="<?= htmlspecialchars($b['title']) ?>" class="blog-img" loading="lazy">
          <div class="blog-content">
            <div class="blog-meta">
              <span style="color: var(--gold-dark); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;"><?= htmlspecialchars($b['category']) ?></span>
              <span><?= htmlspecialchars($b['read_time']) ?></span>
            </div>
            <h3 style="font-size: 1.2rem; margin-bottom: 0.75rem; color: var(--navy-dark);"><?= htmlspecialchars($b['title']) ?></h3>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.25rem; flex-grow: 1;"><?= htmlspecialchars($b['snippet']) ?></p>

            <button class="learn-more-link" style="background: none; border: none; cursor: pointer; padding: 0;" onclick="openBlogModal(<?= htmlspecialchars(json_encode($b)) ?>)">
              <span>Read Article</span>
              <i class="ri-arrow-right-line"></i>
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<script>
  // Live Blog Search Listener
  document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('blogSearchInput');
    const cards = document.querySelectorAll('.blog-card');

    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        cards.forEach(card => {
          const title = card.dataset.title || '';
          const category = (card.dataset.category || '').toLowerCase();
          if (title.includes(query) || category.includes(query)) {
            card.style.display = 'flex';
          } else {
            card.style.display = 'none';
          }
        });
      });
    }
  });

  function openBlogModal(b) {
    showModal(b.title, `
      <div style="margin-bottom: 1rem;">
        <img src="${b.image_url}" style="width: 100%; height: 220px; object-fit: cover; border-radius: 12px; margin-bottom: 1rem;">
        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--gold-dark); margin-bottom: 1rem; font-weight: 700;">
          <span>${b.category}</span>
          <span>Published: ${b.published_at} • ${b.read_time}</span>
        </div>
        <div style="color: var(--navy-dark); font-size: 0.95rem; line-height: 1.8; white-space: pre-line;">
          ${b.content || b.snippet}
        </div>
      </div>
    `);
  }
</script>
