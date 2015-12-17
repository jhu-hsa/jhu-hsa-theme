<?php get_header(); ?>
<?php get_template_part( 'part', 'alert-home' ); ?>
<?php get_template_part('part', 'resource-finder'); ?>

<?php if (have_posts()) : ?>
  <div class="wrap">
    <hr class="hr--transparent">
    <?php if (is_tax( 'resource_category' )) : ?>
      <?php $term = 'resource_category_' . $wp_query->get_queried_object_id(); ?>
      <?php if (get_field('image', $term) && get_field('quotation', $term) && get_field('quotation_source', $term)) : ?>
        <div class="resource-feature">
          <img src="<?php $image = get_field('image', $term); echo $image['sizes']['resource-category']; ?>" alt="">
          <div class="resource-feature__content">
            <?php the_field('quotation', $term); ?>
            <p class="resource-feature__source">&mdash; <?php the_field('quotation_source', $term); ?></p>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>
    <section class="list-grid">
      <ul>
        <?php while (have_posts()) : the_post(); ?>
          <li>
            <div class="list-grid__toggle">
              <a><span><?php the_title(); ?></span></a>
              <ul class="list-grid__toggle__icons">
                <li><a class="icon-button icon-button--map" href="<?php the_field('map_link'); ?>" target="_blank"><span>Map</span></a></li>
                <li><a class="icon-button icon-button--link" href="<?php the_field('link'); ?>"><span>Link</span></a></li>
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

<?php get_footer(); ?>