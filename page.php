<?php get_header(); the_post(); ?>
<div class="blog-hero">
  <h1><?php the_title(); ?></h1>
</div>
<main class="post-main">
  <article class="post-body"><?php the_content(); ?></article>
</main>
<?php get_footer(); ?>
