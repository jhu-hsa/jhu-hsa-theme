<?php if ( !(is_post_type_archive( 'resource' ) || is_tax( 'resource_category' )) ) { $bottom = true; } ?>

<?php if ($bottom == true) { echo '<div class="prefooter">'; } ?>
  <div class="wrap" role="navigation" aria-label="resource finder">
    <?php if ($bottom == true) { ?>
      <h1>Looking for something else?</h1>
      <h2 class="heading--serif heading--centered">Resource Finder</h2>
    <?php } else { ?>
      <hr class="hr--transparent">
      <h1>Resource Finder</h1>
    <?php } ?>
    <?php switch_to_blog(1); ?>
      <ul class="resource-finder<?php if ($bottom == true) { echo ' resource-finder--bottom'; } ?>">
        <li><span>Find Resources:</span></li>
        <li>
          <a>Who Are You</a>
          <ul class="resource-finder__dropdown">
            <?php wp_nav_menu(array(
              'menu' => 'who',
              'container' => false,
              'items_wrap' => '%3$s'
            )); ?>
          </ul>
        </li>
        <li>
          <a>What Do You Need</a>
          <ul class="resource-finder__dropdown">
            <?php wp_nav_menu(array(
              'menu' => 'what',
              'container' => false,
              'items_wrap' => '%3$s'
            )); ?>
          </ul>
        </li>
        <li class="resource-finder__search">
          <form role="search" method="get" action="<?php bloginfo('url'); ?>" role="search" aria-label="resource finder">
            <input type="hidden" name="post_type" value="resource"aria-label="Resource query" />
            <label for="search-resources">Search Resources</label>
            <div class="resource-finder__input-wrap">
              <input type="search" id="search-resources" name="s"<?php if (get_search_query()) { echo ' placeholder="' . get_search_query() . '"'; } ; ?> list="resourcedatalist">
            <?php  $args_resource = array(
    'post_type' => 'resource',
	'orderby'        => 'name',
    'order'          => 'ASC',
    'posts_per_page' => -1
    
  );
  //print_r($args_resource);
$query_resource = new WP_Query($args_resource);?>
<datalist id="resourcedatalist">

        <?php while ($query_resource->have_posts()) : $query_resource->the_post(); ?>
          
             <option value="<?php the_title(); ?>">
             
                    <?php endwhile; ?>
                                 

			 
 
</datalist>
			</div>
						 <input type="submit" value="Submit" style="position:absolute;left:-9999px;">

          </form>
        </li>
      </ul>
    <?php restore_current_blog(); ?>
  </div>
<?php if ($bottom == true) { echo '</div>'; } ?>