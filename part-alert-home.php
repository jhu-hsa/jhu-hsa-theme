
<?php
if ( is_page_template( 'template-home.php' ) ) {
	
$args = array( 'posts_per_page' => 1, 'category_name' => 'site-emergency-alerts' );

$myposts = get_posts( $args );
foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
	<div class="emergency-alert-site">
	<?php echo '<h2><a href="'.get_permalink().'" >'.get_the_title().'</a></h2>';
			echo '<p>'.get_the_content().'</p>';?>
	</div>
<?php endforeach; 
wp_reset_postdata();
} else {?>
<?php // Get RSS Feed(s)
include_once( ABSPATH . WPINC . '/feed.php' );

// Get a SimplePie feed object from the specified feed source.
$rss = fetch_feed( 'http://studentaffairs.jhu.edu/feed/?cat=27' );

if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

    // Figure out how many total items there are, but limit it to 5. 
    $maxitems = $rss->get_item_quantity( 1 ); 

    // Build an array of all the items, starting with element 0 (first element).
    $rss_items = $rss->get_items( 0, $maxitems );

endif;
?>


    <?php if ( $maxitems == 0 ) : ?>
       
    <?php else : ?>
        <?php // Loop through each feed item and display each item as a hyperlink. ?>
        <?php foreach ( $rss_items as $item ) : ?>
            <div class="emergency-alert-site">
                <a href="<?php echo esc_url( $item->get_permalink() ); ?>">
                    <?php echo '<h2>'.esc_html( $item->get_title() ).'</h2>'; ?>
					<?php echo $item->get_content(); ?>
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; 
}
?>

<?php
include_once(ABSPATH.WPINC.'/rss.php'); // path to include script ?>




<?php $feed_rd = fetch_rss('http://www.getrave.com/rss/jhu/channel2'); // specify feed url
$items_rd = array_slice($feed_rd->items, 0, 1); // specify first and last item
if (!empty($items_rd)) : ?>

<?php foreach ($items_rd as $item_rd) : ?>
<?php if($item_rd['description']=='NO ALERT'){echo '';}else{ ?>
<div class="emergency-alert">
	<div class="emergency-alert-global-rd">
<h2><?php echo $item_rd['title']; ?></h2>
<p><?php echo $item_rd['description']; ?></p>
	</div>
</div>
<?php }
endforeach; ?>

<?php endif; ?>
<?php $feed_yl = fetch_rss('http://www.getrave.com/rss/jhu/channel5'); // specify feed url
$items_yl = array_slice($feed_yl->items, 0, 1); // specify first and last item
if (!empty($items_yl)) : ?>

<?php foreach ($items_yl as $item_yl) : ?>
<?php if($item_yl['description']=='NO ALERT'){echo '';}else{ ?>
<div class="emergency-alert">
	<div class="emergency-alert-global-yl">
<h2><?php echo $item_yl['title']; ?></h2>
<p><?php echo $item_yl['description']; ?></p>
	</div>
</div>
<?php }
 endforeach; ?>

<?php endif; ?>
<?php $feed_gr = fetch_rss('http://www.getrave.com/rss/jhu/channel4'); // specify feed url
$items_gr = array_slice($feed_gr->items, 0, 1); // specify first and last item
if (!empty($items_gr)) : ?>

<?php foreach ($items_gr as $item_gr) : ?>
<?php if($item_gr['description']=='NO ALERT'){echo '';}else{ ?>
<div class="emergency-alert">
	<div class="emergency-alert-global-gr">
<h2><?php echo $item_gr['title']; ?></h2>
<p><?php echo $item_gr['description']; ?></p>
	</div>
</div>
<?php }
endforeach; ?>

<?php endif; ?>