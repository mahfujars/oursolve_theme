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
</nav>
