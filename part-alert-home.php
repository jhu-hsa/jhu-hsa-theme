
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
$rss = fetch_feed( 'http://studentaffairs.jhu.edu/feed/?cat=27&now=12ag4oSduq344' );

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
include_once(ABSPATH.WPINC.'/rss.php'); // path to include script
$feed = fetch_rss('http://www.getrave.com/rss/jhu/channel6&now=12ag4oSduq344'); // specify feed url
$items = array_slice($feed->items, 0, 1); // specify first and last item
?>

<?php if (!empty($items)) : ?>

<?php foreach ($items as $item) : ?>
<div class="emergency-alert-global">
<h2><?php echo $item['title']; ?></h2>
<p><?php echo $item['description']; ?></p>
</div>
<?php endforeach; ?>

<?php endif; ?>