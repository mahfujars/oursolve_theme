<?php get_header(); ?>

<div class="blog-hero">
  <div class="tool-badge">📝 Blog</div>
  <h1>Oursolve Blog</h1>
  <p>Tips, guides, and updates from the Oursolve team.</p>
</div>

<main class="blog-main">
  <?php if (have_posts()) : ?>
    <div class="blog-grid">
      <?php while (have_posts()) : the_post(); ?>
        <?php
          $cats = get_the_category();
          $badge = $cats ? '<span class="tag">' . esc_html($cats[0]->name) . '</span>' : '';
        ?>
        <a class="blog-card" href="<?php the_permalink(); ?>">
          <div class="post-meta">
            <?php echo $badge; ?>
            <span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
          </div>
          <h2><?php the_title(); ?></h2>
          <p class="excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25, '…'); ?></p>
          <span class="tool-link">Read article
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </span>
        </a>
      <?php endwhile; ?>
    </div>

    <div class="pagination">
      <?php echo paginate_links(['prev_text'=>'← Prev','next_text'=>'Next →','type'=>'plain']); ?>
    </div>

  <?php else : ?>
    <div class="empty-state">
      <strong>No posts yet.</strong>Check back soon.
    </div>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
