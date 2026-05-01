<?php get_header(); ?>

<section class="blog-hero">
  <div class="blog-hero-inner">
    <div class="tool-badge">✍️ Blog</div>
    <h1>Oursolve Blog</h1>
    <p>Tips, tutorials, and updates to help you work smarter with free tools.</p>
  </div>
</section>

<?php
// Gather all categories that have posts
$cats = get_categories(['hide_empty' => true]);
$current_cat = get_query_var('cat');
?>

<?php if ($cats) : ?>
<div class="blog-filter-bar">
  <div class="blog-filter-inner">
    <a class="blog-cat-chip<?php echo !$current_cat ? ' active' : ''; ?>" href="<?php echo get_permalink(get_option('page_for_posts')); ?>">All</a>
    <?php foreach ($cats as $cat) : ?>
      <a class="blog-cat-chip<?php echo ($current_cat == $cat->term_id) ? ' active' : ''; ?>"
         href="<?php echo get_category_link($cat->term_id); ?>">
        <?php echo esc_html($cat->name); ?>
      </a>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>

<main class="blog-main">

  <?php if (have_posts()) : ?>

    <?php
    // Pull out first post for featured treatment on page 1
    $paged = get_query_var('paged') ?: 1;
    $first = true;
    ?>

    <?php while (have_posts()) : the_post(); ?>

      <?php
      $cats_list = get_the_category();
      $cat_label = $cats_list ? esc_html($cats_list[0]->name) : '';
      $cat_link  = $cats_list ? get_category_link($cats_list[0]->term_id) : '';
      $words     = str_word_count(strip_tags(get_the_content()));
      $read_time = max(1, ceil($words / 200));
      $thumb     = has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'large') : '';
      ?>

      <?php if ($first && $paged === 1) : $first = false; ?>

        <!-- ── Featured post ── -->
        <a class="blog-featured" href="<?php the_permalink(); ?>">
          <?php if ($thumb) : ?>
            <div class="blog-featured-img" style="background-image:url('<?php echo esc_url($thumb); ?>')"></div>
          <?php else : ?>
            <div class="blog-featured-img blog-featured-placeholder">
              <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" opacity=".25"><path d="M4 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5z"/><path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4zM4 20l4-5 3 3.5 4-5L20 20"/></svg>
            </div>
          <?php endif; ?>
          <div class="blog-featured-body">
            <div class="blog-meta-row">
              <?php if ($cat_label) : ?>
                <span class="blog-tag"><?php echo $cat_label; ?></span>
              <?php endif; ?>
              <span class="blog-date"><?php echo get_the_date('M j, Y'); ?></span>
              <span class="blog-read-time"><?php echo $read_time; ?> min read</span>
            </div>
            <h2 class="blog-featured-title"><?php the_title(); ?></h2>
            <p class="blog-featured-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 30, '…'); ?></p>
            <span class="blog-read-link">Read article
              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </span>
          </div>
        </a>

        <?php if (have_posts()) : ?>
          <div class="blog-grid">
        <?php endif; ?>

      <?php else : $first = false; ?>

        <!-- ── Grid card ── -->
        <a class="blog-card" href="<?php the_permalink(); ?>">
          <?php if ($thumb) : ?>
            <div class="blog-card-img" style="background-image:url('<?php echo esc_url($thumb); ?>')"></div>
          <?php endif; ?>
          <div class="blog-card-body">
            <div class="blog-meta-row">
              <?php if ($cat_label) : ?>
                <span class="blog-tag"><?php echo $cat_label; ?></span>
              <?php endif; ?>
              <span class="blog-date"><?php echo get_the_date('M j, Y'); ?></span>
            </div>
            <h2 class="blog-card-title"><?php the_title(); ?></h2>
            <p class="blog-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '…'); ?></p>
            <span class="blog-read-link">
              Read <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </span>
          </div>
        </a>

      <?php endif; ?>

    <?php endwhile; ?>

    <?php if (!$first) : ?>
      </div><!-- /.blog-grid -->
    <?php endif; ?>

    <div class="blog-pagination">
      <?php
      echo paginate_links([
        'prev_text' => '← Prev',
        'next_text' => 'Next →',
        'type'      => 'plain',
      ]);
      ?>
    </div>

  <?php else : ?>

    <div class="blog-empty">
      <div class="blog-empty-icon">📝</div>
      <h2>No posts yet</h2>
      <p>Check back soon — content is on the way.</p>
    </div>

  <?php endif; ?>

</main>

<?php get_footer(); ?>
