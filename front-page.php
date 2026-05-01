<?php get_header(); ?>

<div class="site-hero">
  <div class="hero-inner">
    <div class="hero-badge">🛠 Free Online Tools</div>
    <h1>Simple Tools for<br>Everyday Tasks</h1>
    <p>Fast, private, and free — every tool runs entirely in your browser. No sign-up. No tracking.</p>
    <div class="hero-actions">
      <a href="<?php echo home_url('/tools/'); ?>" class="btn-primary">Browse All Tools</a>
      <a href="<?php echo home_url('/blog/'); ?>" class="btn-ghost">Read the Blog</a>
    </div>
  </div>
</div>

<main class="site-main">

  <div class="section-header">
    <p class="section-title">Popular Tools</p>
    <a href="<?php echo home_url('/tools/'); ?>" class="section-link">
      View all tools
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </a>
  </div>
  <div id="featuredTools" class="tools-grid"></div>

  <div class="section-header" style="margin-top:56px">
    <p class="section-title">From the Blog</p>
    <a href="<?php echo home_url('/blog/'); ?>" class="section-link">
      View all articles
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </a>
  </div>
  <div id="blogPosts" class="blog-grid"></div>

</main>

<?php get_footer(); ?>

<script>
const ARROW = '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>';
const FEATURED = ['qr-generator','password-generator','hash-generator','json-formatter','markdown-to-html','muslim-names'];

fetch('/tool/tools.json')
  .then(r => r.json())
  .then(tools => {
    const featured = FEATURED.map(slug => tools.find(t => t.slug === slug)).filter(Boolean);
    document.getElementById('featuredTools').innerHTML = featured.map(t =>
      `<a class="tool-card" href="/tool/${t.slug}/">
        <div class="tool-icon ${t.iconClass}">${t.icon}</div>
        <div><span class="tag">${t.category}</span><h2>${t.name}</h2></div>
        <p>${t.desc}</p>
        <span class="tool-link">Open tool ${ARROW}</span>
      </a>`
    ).join('');
  })
  .catch(() => {
    document.getElementById('featuredTools').innerHTML =
      '<div class="empty-state"><strong>Could not load tools.</strong> Please refresh.</div>';
  });

fetch('/wp-json/wp/v2/posts?per_page=3&_embed')
  .then(r => r.json())
  .then(posts => {
    if (!posts.length) { document.getElementById('blogPosts').innerHTML = ''; return; }
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
  .catch(() => { document.getElementById('blogPosts').innerHTML = ''; });
</script>
