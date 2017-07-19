<section class="sidebar" role="region" aria-label="main nav">
  <div class="sidebar__block">
    <a class="sidebar__nav__toggle">In this section...</a>
  <?php wp_nav_menu(array(
	'menu' => 'Main Navigation',
	'container' => 'ul',
	'menu_class' => 'sidebar__nav'  ));	  ?>
  </div>
</section>