<?php get_header(); ?>

<?php get_template_part('part', 'breadcrumbs'); ?>

<div class="wrap">

  <?php get_sidebar('nav'); ?>

  <?php if (have_posts()) : ?>
    <section class="main">
      <div class="wrap">
        <hr class="hr--transparent">
        <h1>Staff</h1>
        <section class="list-grid">
          <ul>
            <?php while (have_posts()) : the_post(); ?>
              <li class="list-grid__item--staff">
                <a href="<?php the_permalink(); ?>">
                  <span class="list-grid__item__image" style="background-image: url(<?php $image = get_field('image'); echo $image['sizes']['staff-small']; ?>);"></span>
                  <span class="list-grid__name"><?php the_title(); ?></span>
                  <span class="list-grid__title"><?php the_field('title'); ?></span>
                </a>
              </li>
            <?php endwhile; ?>
          </ul>
        </section>
      </div>
    </section>
  <?php endif; ?>

  <?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>