<?php get_header(); ?>

<?php
$term      = get_queried_object();
$term_name = $term ? $term->name : single_tag_title('', false);
$term_desc = $term ? term_description($term->term_id) : '';
?>

<section class="blog-hero">
  <div class="blog-hero-inner">
    <div class="tool-badge">🏷️ Tag</div>
    <h1>#<?php echo esc_html($term_name); ?></h1>
    <?php if ($term_desc) : ?>
      <p><?php echo wp_kses_post($term_desc); ?></p>
    <?php else : ?>
      <p>All posts tagged <?php echo esc_html($term_name); ?>.</p>
    <?php endif; ?>
  </div>
</section>

<?php
$cats = get_categories(['hide_empty' => true]);
?>

<?php if ($cats) : ?>
<div class="blog-filter-bar">
  <div class="blog-filter-inner">
    <a class="blog-cat-chip" href="<?php echo get_permalink(get_option('page_for_posts')); ?>">All</a>
    <?php foreach ($cats as $cat) : ?>
      <a class="blog-cat-chip" href="<?php echo get_category_link($cat->term_id); ?>">
        <?php echo esc_html($cat->name); ?>
      </a>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>

<main class="blog-main">

  <?php if (have_posts()) : ?>

    <div class="blog-grid">

    <?php while (have_posts()) : the_post(); ?>

      <?php
      $cats_list = get_the_category();
      $cat_label = $cats_list ? esc_html($cats_list[0]->name) : '';
      $thumb     = has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'large') : '';
      ?>

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

    <?php endwhile; ?>

    </div><!-- /.blog-grid -->

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
      <div class="blog-empty-icon">📭</div>
      <h2>No posts with this tag</h2>
      <p>Check back soon — content is on the way.</p>
    </div>

  <?php endif; ?>

</main>

<?php get_footer(); ?>
