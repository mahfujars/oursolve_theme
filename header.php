<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    const saved = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const theme = saved || (prefersDark ? 'dark' : 'light');
    if (theme === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
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
