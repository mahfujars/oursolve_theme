<?php get_header(); the_post(); ?>

<div class="post-hero">
  <?php $cats = get_the_category(); if ($cats) echo '<div class="tool-badge">' . esc_html($cats[0]->name) . '</div>'; ?>
  <h1><?php the_title(); ?></h1>
  <div class="post-meta">
    <span><?php echo get_the_date('M j, Y'); ?></span>
    <span>By <?php the_author(); ?></span>
    <span><?php echo get_the_reading_time(); ?></span>
  </div>
</div>

<main class="post-main">
  <a class="back-link" href="<?php echo home_url('/blog/'); ?>">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    All articles
  </a>
  <article class="post-body">
    <?php the_content(); ?>
  </article>
</main>

<?php get_footer(); ?>

<?php
function get_the_reading_time() {
  $content = get_the_content();
  $word_count = str_word_count(strip_tags($content));
  $minutes = max(1, ceil($word_count / 200));
  return $minutes . ' min read';
}
?>
