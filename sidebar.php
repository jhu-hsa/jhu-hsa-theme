<section class="sidebar" role="region" aria-label="Action Items">
  <div class="sidebar__block">
    <?php wp_nav_menu(array(
      'menu' => 'Task Navigation',
      'container' => false,
      'menu_class' => 'sidebar__nav sidebar__nav--check'
    )); ?>
  </div>
  <?php if (!is_archive()) : ?>
    <?php if (have_rows('sidebar_buttons')) : ?>
      <div class="sidebar__block">
        <ul class="sidebar__buttons">
          <?php while (have_rows('sidebar_buttons')) : the_row(); ?>
            <li><a href="<?php the_sub_field('button_link'); ?>"<?php if (get_sub_field('target')) : ?> target="<?php the_sub_field('target'); ?>"<?php endif; ?>><?php the_sub_field('button_text'); ?></a></li>
          <?php endwhile; ?>
        </ul>
      </div>
    <?php endif; ?>
  <?php endif; ?>
  <?php if (get_post_type() == 'post'): ?>
    <div class="sidebar__block">
      <div class="tag-cloud">
        <?php wp_tag_cloud(); ?>
      </div>
    </div>
  <?php endif; ?>
</section>