<?php get_header(); ?>

<?php get_template_part( 'part', 'breadcrumbs' ); ?>

<div class="wrap">

  <?php get_sidebar('nav'); ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <section class="main">
      <h1><?php the_title(); ?></h1>
      <div class="post-date">
        Posted: <?php the_time('F j, Y'); ?>
      </div>
	   <?php if (has_post_thumbnail()) : ?>
        <div style="text-align:center;">
          <?php the_post_thumbnail('post-header'); ?>
        </div>
      <?php endif; ?>
      <?php the_content(); ?>
      <?php the_tags(); ?>
    </section>
  <?php endwhile; endif; ?>

  <?php get_sidebar(); ?>

</div>

<?php get_template_part( 'part', 'related-links' ); ?>

<?php get_template_part( 'part', 'resource-finder' ); ?>

<?php get_footer(); ?>