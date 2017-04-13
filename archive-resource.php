<?php get_header(); ?>
<div role="main">
<?php get_template_part( 'part', 'alert-home' ); ?>
<?php get_template_part('part', 'resource-finder'); ?>

<?php if (have_posts()) : ?>
  <div class="wrap">
    <hr class="hr--transparent">
    <?php if (is_tax( 'resource_category' )) : ?>
      <?php $term = 'resource_category_' . $wp_query->get_queried_object_id(); ?>
      <?php if (get_field('image', $term) && get_field('quotation', $term) && get_field('quotation_source', $term)) : ?>
        <div class="resource-feature">
          <img src="<?php $image = get_field('image', $term); echo $image['sizes']['resource-category']; ?>" alt="Resource Featured image">
          <div class="resource-feature__content">
            <?php the_field('quotation', $term); ?>
            <p class="resource-feature__source"><?php the_field('quotation_source', $term); ?></p>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>
    <section class="list-grid">
      <ul>
        <?php while (have_posts()) : the_post(); ?>
          <li>
            <div class="list-grid__toggle">
			<?php 
			$event_cat=get_field('event_cat');
			$event_action=get_field('event_action');
			$event_label_rf=get_field('event_label_rf');
			$event_label_ro=get_field('event_label_ro');
			$event_value=get_field('event_value');
			$event_bounce_rate=get_field('event_bounce_rate');
				  //echo $event_cat_link;?>
              <a onClick='ga("send", "event", "<?php if ($event_cat){ echo $event_cat;} else{}?>", "<?php if ($event_action){ echo $event_action;} else{}?>", "<?php if ($event_label_rf){ echo $event_label_rf;} else{}?>"<?php if ($event_value!=0){?>, <?php echo $event_value;} else{}?>);'><span><?php the_title(); ?></span></a>
              <ul class="list-grid__toggle__icons">
                <li><a class="icon-button icon-button--map" href="<?php the_field('map_link'); ?>" target="_blank"><span>Map</span></a></li>
                <li><a class="icon-button icon-button--link" href="<?php the_field('link'); ?>" onClick='ga("send", "event", "<?php if ($event_cat){ echo $event_cat;} else{}?>", "<?php if ($event_action){ echo $event_action;} else{}?>", "<?php if ($event_label_ro){ echo $event_label_ro;} else{}?>"<?php if ($event_value!=0){?>, <?php echo $event_value;} else{}?>);'><span>Link</span></a></li>
              </ul>
              <div class="list-grid__toggle__content">
                <div class="list-grid__toggle__content__info">
                  <?php the_field('description'); ?>
                </div>
                <div class="list-grid__toggle__content__detail">
                  <?php the_field('additional_information'); ?>
                </div>
              </div>
              <div class="list-grid__toggle__image" style="background-image: url(<?php $image = get_field('image'); echo $image['sizes']['resource']; ?>);">
                <a class="list-grid__toggle__close"><span>Close</span></a>
              </div>
              <?php if (have_rows('related_links')) : ?>
                <div class="list-grid__toggle__links">
                  <span>Related Links:</span>                
                  <ul>
                    <?php while (have_rows('related_links')) : the_row(); ?>
                      <li><a href="<?php the_sub_field('link'); ?>"<?php if (get_sub_field('target')) : ?> target="<?php the_sub_field('target'); ?>"<?php endif; ?>><?php the_sub_field('link_text'); ?></a></li>
                    <?php endwhile; ?>
                  </ul>                
                </div>
              <?php endif; ?>
            </div>
          </li>
        <?php endwhile; ?>
      </ul>
    </section>
  </div>
<?php else : ?>
  <div class="wrap">
    <hr class="hr--transparent">
    <h2>Nothing found</h2>
    <hr class="hr--transparent">
  </div>
<?php endif; ?>
</div>
<?php get_footer(); ?>