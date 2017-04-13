<?php get_header(); ?>

<?php get_template_part( 'part', 'breadcrumbs' ); ?>

<div class="wrap" role="main">

  <?php get_sidebar('nav'); ?>

  <section class="main">
  <h1><?php single_cat_title(); ?></h1>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <div class="post-date">
        <?php the_time('F j, Y'); ?>
      </div>
      <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
          <?php the_post_thumbnail('staff-wide'); ?>
        </div>
      <?php endif; ?>
      <?php the_excerpt(); ?>
      <div style="clear: both;"></div>
    <?php endwhile; endif; ?>
    <div class="posts-nav">
      <?php echo paginate_links( $args ); ?>
    </div>
  </section>

  <?php get_sidebar(); ?>

</div>

<?php get_template_part( 'part', 'related-links' ); ?>

<?php get_template_part( 'part', 'resource-finder' ); ?>

<?php get_footer(); ?>