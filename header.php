<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Primary SEO -->
  <meta name="description" content="<?php
    if (is_singular()) {
      $excerpt = get_the_excerpt();
      echo esc_attr($excerpt ?: get_bloginfo('description'));
    } else {
      echo esc_attr(get_bloginfo('description'));
    }
  ?>">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="<?php echo esc_url(get_permalink() ?: home_url('/')); ?>">

  <!-- Open Graph -->
  <meta property="og:site_name" content="Oursolve">
  <meta property="og:type" content="<?php echo is_singular('post') ? 'article' : 'website'; ?>">
  <meta property="og:url" content="<?php echo esc_url(get_permalink() ?: home_url('/')); ?>">
  <meta property="og:title" content="<?php
    if (is_front_page()) echo 'Oursolve — Free Online Tools';
    elseif (is_singular()) echo esc_attr(get_the_title()) . ' — Oursolve';
    elseif (is_category()) echo 'Category: ' . esc_attr(single_cat_title('', false)) . ' — Oursolve Blog';
    elseif (is_home()) echo 'Blog — Oursolve';
    else echo esc_attr(wp_title('', false)) . ' — Oursolve';
  ?>">
  <meta property="og:description" content="<?php
    if (is_singular()) {
      $excerpt = get_the_excerpt();
      echo esc_attr($excerpt ?: get_bloginfo('description'));
    } else {
      echo esc_attr(get_bloginfo('description'));
    }
  ?>">
  <?php if (is_singular() && has_post_thumbnail()) : ?>
  <meta property="og:image" content="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <?php endif; ?>

  <!-- Twitter Card -->
  <meta name="twitter:card" content="<?php echo (is_singular() && has_post_thumbnail()) ? 'summary_large_image' : 'summary'; ?>">
  <meta name="twitter:title" content="<?php
    if (is_front_page()) echo 'Oursolve — Free Online Tools';
    elseif (is_singular()) echo esc_attr(get_the_title()) . ' — Oursolve';
    else echo 'Oursolve';
  ?>">
  <meta name="twitter:description" content="<?php
    if (is_singular()) {
      $excerpt = get_the_excerpt();
      echo esc_attr($excerpt ?: get_bloginfo('description'));
    } else {
      echo esc_attr(get_bloginfo('description'));
    }
  ?>">
  <?php if (is_singular() && has_post_thumbnail()) : ?>
  <meta name="twitter:image" content="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>">
  <?php endif; ?>

  <!-- Schema.org -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "<?php echo is_singular('post') ? 'Article' : 'WebSite'; ?>",
    <?php if (is_singular('post')) : ?>
    "headline": <?php echo json_encode(get_the_title()); ?>,
    "datePublished": "<?php echo get_the_date('c'); ?>",
    "dateModified": "<?php echo get_the_modified_date('c'); ?>",
    "author": {"@type":"Person","name":<?php echo json_encode(get_the_author()); ?>},
    "publisher": {"@type":"Organization","name":"Oursolve","url":"https://oursolve.com"},
    "description": <?php echo json_encode(strip_tags(get_the_excerpt())); ?>,
    <?php if (has_post_thumbnail()) : ?>
    "image": <?php echo json_encode(get_the_post_thumbnail_url(null, 'large')); ?>,
    <?php endif; ?>
    "mainEntityOfPage": {"@type":"WebPage","@id":<?php echo json_encode(get_permalink()); ?>}
    <?php else : ?>
    "name": "Oursolve",
    "url": "https://oursolve.com",
    "description": <?php echo json_encode(get_bloginfo('description')); ?>,
    "potentialAction": {"@type":"SearchAction","target":{"@type":"EntryPoint","urlTemplate":"https://oursolve.com/?s={search_term_string}"},"query-input":"required name=search_term_string"}
    <?php endif; ?>
  }
  </script>

  <!-- Dark mode init (before paint) -->
  <script>(function(){var t=localStorage.getItem('theme'),d=window.matchMedia('(prefers-color-scheme:dark)').matches;if((t||( d?'dark':'light'))==='dark')document.documentElement.setAttribute('data-theme','dark');})();</script>

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<nav class="site-nav">
  <a href="<?php echo home_url('/'); ?>" class="brand">
    <div class="logo-icon">🛠</div>
    Oursolve
  </a>
  <div class="nav-links">
    <a href="<?php echo home_url('/'); ?>">Home</a>
    <a href="<?php echo home_url('/tools/'); ?>">Tools</a>
    <a href="<?php echo home_url('/blog/'); ?>">Blog</a>
  </div>
  <button id="themeToggle" class="theme-toggle" aria-label="Toggle dark mode" title="Toggle dark mode">🌙</button>
</nav>
<script>
  (function() {
    document.addEventListener('DOMContentLoaded', function() {
      const btn = document.getElementById('themeToggle');
      if (!btn) return;
      btn.textContent = document.documentElement.getAttribute('data-theme') === 'dark' ? '☀️' : '🌙';
      btn.addEventListener('click', function() {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        document.documentElement.setAttribute('data-theme', isDark ? 'light' : 'dark');
        localStorage.setItem('theme', isDark ? 'light' : 'dark');
        btn.textContent = isDark ? '🌙' : '☀️';
      });
    });
  })();
</script>
