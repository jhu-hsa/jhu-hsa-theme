<?php get_header(); ?>

<?php get_template_part( 'part', 'breadcrumbs' ); ?>
<div role="main">
<div class="wrap">

  <?php get_sidebar('nav'); ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <section class="main">
      <h1><?php the_title(); ?></h1>
	   <?php if (has_post_thumbnail()) : ?>
        <div style="text-align:center;">
          <?php the_post_thumbnail('full'); ?>
        </div>
      <?php endif; ?>
      <?php the_content(); ?>
    </section>
  <?php endwhile; endif; ?>

  <?php get_sidebar(); ?>

</div>

<?php get_template_part( 'part', 'related-links' ); ?>

<?php get_template_part( 'part', 'resource-finder' ); ?>
</div>
<?php get_footer(); ?>