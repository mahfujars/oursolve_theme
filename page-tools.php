<?php
/*
 * Template Name: Tools Listing
 */
get_header(); ?>

<div class="blog-hero">
  <div class="tool-badge">🛠 All Tools</div>
  <h1>Free Online Tools</h1>
  <p>Every tool runs in your browser — no sign-up, no tracking, no data sent anywhere.</p>
</div>

<main class="site-main">
  <div class="toolbar">
    <div class="search-wrap">
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>
      </svg>
      <input id="searchInput" class="search-input" type="search" placeholder="Search tools..." autocomplete="off">
    </div>
    <div id="filterChips" class="filter-chips"></div>
  </div>
  <div id="toolsContainer"></div>
</main>

<?php get_footer(); ?>

<script>
const CATEGORY_ORDER = ['Developer','Security','Generator','Encoding','Writing','Islamic'];
const ARROW = '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>';
let TOOLS = [], activeFilter = 'All', searchTerm = '';

fetch('/tool/tools.json')
  .then(r => r.json())
  .then(data => { TOOLS = data; renderChips(); renderTools(); })
  .catch(() => {
    document.getElementById('toolsContainer').innerHTML =
      '<div class="empty-state"><strong>Could not load tools.</strong> Please refresh.</div>';
  });

function cardHTML(t) {
  return `<a class="tool-card" href="/tool/${t.slug}/">
    <div class="tool-card-top">
      <div class="tool-icon ${t.iconClass}">${t.icon}</div>
      <h2>${t.name}</h2>
    </div>
    <span class="tag">${t.category}</span>
    <p class="tool-desc">${t.desc}</p>
    <span class="tool-link">Open tool ${ARROW}</span>
  </a>`;
}

function renderChips() {
  const counts = TOOLS.reduce((a,t) => (a[t.category]=(a[t.category]||0)+1,a), {});
  const cats = ['All', ...CATEGORY_ORDER.filter(c => counts[c])];
  document.getElementById('filterChips').innerHTML = cats.map(c => {
    const n = c==='All' ? TOOLS.length : counts[c];
    return `<button class="chip${c===activeFilter?' active':''}" data-cat="${c}">${c}<span class="count">${n}</span></button>`;
  }).join('');
  document.querySelectorAll('.chip').forEach(b =>
    b.addEventListener('click', () => { activeFilter = b.dataset.cat; renderChips(); renderTools(); })
  );
}

function renderTools() {
  const q = searchTerm.trim().toLowerCase();
  const filtered = TOOLS.filter(t => {
    if (activeFilter !== 'All' && t.category !== activeFilter) return false;
    if (q && !(t.name.toLowerCase().includes(q) || t.desc.toLowerCase().includes(q) || t.category.toLowerCase().includes(q))) return false;
    return true;
  });
  const container = document.getElementById('toolsContainer');
  if (!filtered.length) {
    container.innerHTML = '<div class="empty-state"><strong>No tools match.</strong> Try a different keyword.</div>';
    return;
  }
  if (q || activeFilter !== 'All') {
    container.innerHTML = `<div class="tools-grid">${filtered.map(cardHTML).join('')}</div>`;
    return;
  }
  const groups = {};
  filtered.forEach(t => (groups[t.category]=groups[t.category]||[]).push(t));
  container.innerHTML = CATEGORY_ORDER.filter(c => groups[c]).map(c => `
    <section class="category-section">
      <div class="category-heading"><h3>${c}</h3><span class="count-badge">${groups[c].length}</span></div>
      <div class="tools-grid">${groups[c].map(cardHTML).join('')}</div>
    </section>`).join('');
}

document.getElementById('searchInput').addEventListener('input', e => { searchTerm = e.target.value; renderTools(); });
</script>
