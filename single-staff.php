<?php get_header(); ?>

<?php get_template_part( 'part', 'breadcrumbs' ); ?>

<div class="wrap" role="main">

  <?php get_sidebar('nav'); ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <section class="main">
      <h1><?php the_title(); ?></h1>
      <div class="wrap wrap--flush">
        <div class="main__content">
          <h2><?php the_field('title'); ?></h2>
          <?php the_field('background_information'); ?>
        </div>
        <div class="main__sidebar main__sidebar--media" role="region" aria-label="contact information">
          <div class="sidebar__block sidebar__block--media" style="background-image: url(<?php $image = get_field('image'); echo $image['sizes']['staff']; ?>);"></div>
          <?php if (get_field('phone') || get_field('email') || get_field('linkedin')) : ?>
            <div class="sidebar__block">
              <ul class="sidebar__buttons">
                <?php if (get_field('phone')) : ?>
                  <li><a class="sidebar__buttons__phone">410-516-<?php the_field('phone'); ?><?php if (get_field('phone_ext')) : ?> Ext. <?php the_field('phone_ext'); ?><?php endif; ?></a></li>
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
               <?php
if (get_field('street_address') || get_field('street_address') || get_field('room_number')) : 

 echo '<p>';

        // display a sub field value
    if (get_field('address_title')){ echo '<strong>'.get_field('address_title').'</strong><br />';} else{echo '';}

  echo '<strong>Johns Hopkins University</strong><br />';
  if (get_field('street_address')){ echo get_field('street_address').'<br />';} else{echo '';}
  if (get_field('building')){ echo get_field('building').'<br />';} else{echo '';}
  if (get_field('room_number') ){ echo 'Suite '.get_field('room_number').'<br />';} else{echo '';}
         if (get_field('street_address')){ echo 'Baltimore, MD 21218';} else{echo '';}
 echo '</p>';

endif; 

?>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php endwhile; endif; ?>

  <?php get_sidebar(); ?>

</div>
<div role="complementary" aria-label="other staff">
<?php $query = new WP_Query( array( 'post_type' => 'staff', 'posts_per_page' => '4', 'orderby' => 'rand', 'ignore_custom_sort' => TRUE, 'post__not_in' => array($post->ID) ) ); ?>
<?php if ( $query->have_posts() ) : ?>
  <div class="wrap" >
    <hr>
    <section class="staff" role="application" aria-label="staff slider">
      <h2 class="heading--serif heading--centered">Our Staff</h2>
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
</div>
<?php get_footer(); ?>