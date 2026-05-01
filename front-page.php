<?php get_header(); ?>

<div class="site-hero">
  <div class="logo">
    <div class="logo-icon">🛠</div>
    Oursolve
  </div>
  <h1>Free Tools for Everyday Tasks</h1>
  <p>Simple, fast, and private — all tools run entirely in your browser. No sign-up. No tracking.</p>
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

  <p class="section-title" style="margin-top:48px">From the Blog</p>
  <div id="blogPosts" class="blog-grid"></div>
  <div class="view-all-wrap" id="blogFooter">
    <a href="<?php echo home_url('/blog/'); ?>" class="view-all-btn">
      View all articles
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </a>
  </div>
</main>

<?php get_footer(); ?>

<script>
const CATEGORY_ORDER = ['Developer','Security','Generator','Encoding','Writing','Islamic'];
const ARROW = '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>';
let TOOLS = [], activeFilter = 'All', searchTerm = '';

fetch('/tools/tools.json')
  .then(r => r.json())
  .then(data => { TOOLS = data; renderChips(); renderTools(); })
  .catch(() => {
    document.getElementById('toolsContainer').innerHTML =
      '<div class="empty-state"><strong>Could not load tools.</strong>Please refresh.</div>';
  });

function cardHTML(t) {
  return `<a class="tool-card" href="/tools/${t.slug}/">
    <div class="tool-icon ${t.iconClass}">${t.icon}</div>
    <div><span class="tag">${t.category}</span><h2>${t.name}</h2></div>
    <p>${t.desc}</p>
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
    container.innerHTML = '<div class="empty-state"><strong>No tools match.</strong>Try a different keyword.</div>';
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

// Blog posts from WP REST API
fetch('/wp-json/wp/v2/posts?per_page=3&_embed')
  .then(r => r.json())
  .then(posts => {
    if (!posts.length) { document.getElementById('blogFooter').style.display='none'; return; }
    document.getElementById('blogPosts').innerHTML = posts.map(p => {
      const date = new Date(p.date).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'});
      const cats = p._embedded?.['wp:term']?.[0] || [];
      const badge = cats.length ? `<span class="tag">${cats[0].name}</span>` : '';
      const excerpt = p.excerpt?.rendered?.replace(/<[^>]+>/g,'').replace(/\[&hellip;\]/,'…').trim() || '';
      return `<a class="blog-card" href="${p.link}">
        <div class="post-meta">${badge}<span class="post-date">${date}</span></div>
        <h2>${p.title.rendered}</h2>
        <p class="excerpt">${excerpt}</p>
        <span class="tool-link">Read article ${ARROW}</span>
      </a>`;
    }).join('');
  })
  .catch(() => {
    document.getElementById('blogPosts').style.display = 'none';
    document.getElementById('blogFooter').style.display = 'none';
  });
</script>
