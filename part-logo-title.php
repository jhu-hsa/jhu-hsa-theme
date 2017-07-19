<header class="header"  role="banner">
        <a class="header__logo" href="//www.jhu.edu"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.svg" alt="Johns Hopkins University"></a>
        <div class="header__title">
          <?php switch_to_blog(1); $network_site_title = get_bloginfo('name'); restore_current_blog(); ?>
          <a class="header__title__main" href="<?php echo network_site_url(); ?>"><?php echo $network_site_title; ?></a>
          <?php if (!is_main_site()) : ?>
            <br>
            <a class="header__title__sub" href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a>
          <?php endif; ?>
        </div>
</header>
	  