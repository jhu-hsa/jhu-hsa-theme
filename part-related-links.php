<?php if (have_rows('related_links')) : ?>
  <div class="wrap">
    <hr>
    <section class="list-grid">
      <h4 class="heading--serif heading--centered">Related Links</h4>
      <ul>
        <?php while (have_rows('related_links')) : the_row(); ?>
          <li><a href="<?php the_sub_field('link'); ?>"<?php if (get_sub_field('target')) : ?> target="<?php the_sub_field('target'); ?>"<?php endif; ?>><span><?php the_sub_field('link_text'); ?></span></a></li>
        <?php endwhile; ?>
      </ul>
    </section>
  </div>
<?php endif; ?>