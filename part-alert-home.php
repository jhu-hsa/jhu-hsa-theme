
<?php // Get RSS Feed(s)
include_once( ABSPATH . WPINC . '/feed.php' );

// Get a SimplePie feed object from the specified feed source.
$rss = fetch_feed(array('http://studentaffairs.jhu.edu/feed/?cat=27','http://www.getrave.com/rss/jhu/channel2', 'http://www.getrave.com/rss/jhu/channel4', 'http://www.getrave.com/rss/jhu/channel5'));

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
	<?php if($item->get_content()=='NO ALERT'){echo '';}else{ 
	
	if ($item->get_feed()->get_title()=='JHU.edu website alert: RED'){
	echo '<div class="rave-alert red" role="alert">';
	  echo '<a href="https://www.jhu.edu/alert">'.esc_html( $item->get_description()). '</a>';
		echo '</div>';
	}
	elseif($item->get_feed()->get_title() == 'JHU.edu website alert: YELLOW'){
	echo '<div class="rave-alert yellow" role="alert">';
	  echo '<a href="https://www.jhu.edu/alert">'.esc_html( $item->get_description()). '</a>';
		echo '</div>';
		}
		elseif($item->get_feed()->get_title() == 'JHU.edu website alert: GREEN'){
		echo '<div class="rave-alert green" role="alert">';
		  echo '<a href="https://www.jhu.edu/alert">'.esc_html( $item->get_description()). '</a>';
		echo '</div>';
		}
		elseif($item->get_feed()->get_title() == 'Site Emergency Alerts – Homewood Student Affairs'){
		echo '<div class="rave-alert site" role="alert">';
		  echo '<a href="'.esc_url( $item->get_permalink() ).'">'.esc_html( $item->get_title() ).'</a>';
		echo '</div>';
		}
		
		 /*<div class="rave-alert site">
                <a href="<?php echo esc_url( $item->get_permalink() ); ?>">
                    <?php echo esc_html( $item->get_title() ); ?>
				
                </a>
		</div>*/
		
		else{
			echo '';
		}
	
	  

	}

	
	?>
	
	
	
	
	
		
		
	<?php endforeach; ?>
<?php endif; 

?>