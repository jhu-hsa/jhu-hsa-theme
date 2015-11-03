<?php get_header(); ?>

<?php get_template_part( 'part', 'breadcrumbs' ); ?>

<div class="wrap">

  <?php get_sidebar('nav'); ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <section class="main">
      <h1><?php the_title(); ?></h1>
      <div class="wrap wrap--flush">
        <div class="main__content">
          <h2><?php the_field('title'); ?></h2>
          <?php the_field('background_information'); ?>
        </div>
        <div class="main__sidebar main__sidebar--media">
          <div class="sidebar__block sidebar__block--media" style="background-image: url(<?php $image = get_field('image'); echo $image['sizes']['staff']; ?>);"></div>
          <?php if (get_field('phone') || get_field('email') || get_field('linkedin')) : ?>
            <div class="sidebar__block">
              <ul class="sidebar__buttons">
                <?php if (get_field('phone')) : ?>
                  <li><a class="sidebar__buttons__phone"><?php the_field('phone'); ?></a></li>
                <?php endif; ?>
                <?php if (get_field('email')) : ?>
                  <li><a class="sidebar__buttons__email" href="mailto:<?php the_field('email'); ?>"><?php the_field('email'); ?></a></li>
                <?php endif; ?>
                <?php if (get_field('linkedin')) : ?>
                  <li><a class="sidebar__buttons__linkedin" href="<?php the_field('linkedin'); ?>">Connect on LinkedIn</a></li>
                <?php endif; ?>
              </ul>
            </div>
          <?php endif; ?>
          <div class="sidebar__block">
            <div class="sidebar__info">
              <?php the_field('contact_information'); ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php endwhile; endif; ?>

  <?php get_sidebar(); ?>

</div>

<?php $query = new WP_Query( array( 'post_type' => 'staff', 'posts_per_page' => '4', 'orderby' => 'rand', 'ignore_custom_sort' => TRUE, 'post__not_in' => array($post->ID) ) ); ?>
<?php if ( $query->have_posts() ) : ?>
  <div class="wrap">
    <hr>
    <section class="staff">
      <h4 class="heading--serif heading--centered">Our Staff</h4>
      <ul>
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
          <li>
            <a href="<?php the_permalink(); ?>">
			<!--Aaron Madhavan removed staff-wide and replaced with staff for the image-->
              <img src="<?php $image = get_field('image'); echo $image['sizes']['staff']; ?>" alt="<?php the_title(); ?>">
              <div class="staff__info">
                <div class="staff__info__name">
                  <h5><?php the_title(); ?></h5>
                  <p><?php the_field('title'); ?></p>
                </div>
              </div>
            </a>
          </li>
        <?php endwhile; ?>
      </ul>
    </section>
  </div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php get_template_part( 'part', 'resource-finder' ); ?>

<?php get_footer(); ?>