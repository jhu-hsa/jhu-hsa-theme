<?php get_template_part( 'part', 'alert-home' ); ?>
<div class="breadcrumbs" role="navigation" aria-label="page breadcrumbs">
  <div class="wrap">
    <?php if ( function_exists('yoast_breadcrumb') ) {
      yoast_breadcrumb();
    } ?>
  </div>
</div>