<?php
/*
Template Name: Special No Sidebar
*/
?>
<?php get_header(); ?>

<?php get_template_part( 'part', 'breadcrumbs' ); ?>

<div class="wrap" role="main">



  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <section class="nosb">
      <h1><?php the_title(); ?></h1>
   <?php if (has_post_thumbnail()) : ?>
        <div style="text-align:center;">
          <?php the_post_thumbnail('full'); ?>
        </div>
      <?php endif; ?>
      <?php the_content(); ?>
    </section>
  <?php endwhile; endif; ?>

  

</div>



<?php get_template_part( 'part', 'resource-finder' ); ?>

<?php get_footer(); ?>