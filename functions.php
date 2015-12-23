<?php

// load wp tlc transients
require_once( 'wp-tlc-transients/tlc-transients.php' );

// load twitter oauth
require_once( 'twitteroauth/autoload.php' );
use Abraham\TwitterOAuth\TwitterOAuth;

// theme css
function theme_css() {
  wp_enqueue_style( 'bower', get_template_directory_uri() . '/css/style-bower.css' );
  wp_enqueue_style( 'theme', get_template_directory_uri() . '/css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'theme_css' );

// theme js
function theme_js() {
  wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5shiv.js' );
  wp_enqueue_script( 'bower', get_template_directory_uri() . '/js/script-bower.js' );
  wp_enqueue_script( 'theme', get_template_directory_uri() . '/js/script.js' );
}
add_action( 'wp_enqueue_scripts', 'theme_js' );

// enable menus
add_theme_support( 'menus' );

// custom image sizes
add_image_size( 'collage', 1080, 648, true );
add_image_size( 'feature', 800, 600, true );
add_image_size( 'resource', 1024, 576, true );
add_image_size( 'resource-category', 740, 370, true );
add_image_size( 'splash', 1920, 1080, true );
add_image_size( 'staff', 480, 480, true );
add_image_size( 'staff-small', 62, 62, true );
add_image_size( 'staff-wide', 480, 340, true );

// use resource archive for resource category taxonomy
function taxonomy_resource_category_template( $template ) {
  if (is_tax( 'resource_category' )) {
    $new_template = locate_template( array( 'archive-resource.php' ));
    if ('' != $new_template) {
      return $new_template;
    }
  }
  return $template;
}
add_filter( 'template_include', 'taxonomy_resource_category_template', 99 );

// disable tablepress css
add_filter( 'tablepress_use_default_css', '__return_false' );

// change seo module position priority
function seo_position_priority() {
  return 'low';
}
add_filter( 'wpseo_metabox_prio', 'seo_position_priority');

// accordion shortcode
function shortcode_accordion( $atts, $content = null ) {
  return '<ul class="list-accordion">' . do_shortcode( $content ) . '</ul>';
}
add_shortcode( 'accordion', 'shortcode_accordion' );

// accordion item shortcode
function shortcode_accordion_item( $atts, $content = null ) {
  extract(shortcode_atts(array(
    'heading' => null
  ), $atts));
  return '<li><a class="list-accordion__toggle">' . $heading . '</a><div class="list-accordion__content">' . $content . '</div></li>';
}
add_shortcode( 'accordion-item', 'shortcode_accordion_item' );

// remove p tags around shortcodes
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop', 99 );
add_filter( 'the_content', 'shortcode_unautop', 100 );

// remove extra width from captions
function remove_caption_padding( $width ) {
  return $width - 10;
}
add_filter( 'img_caption_shortcode_width', 'remove_caption_padding' );

// add featured image support
add_theme_support( 'post-thumbnails' );

// hub feed get
function hub_feed_get($endpoint, $count, $type) {
  $feed = wp_remote_get('http://api.hub.jhu.edu/' . $endpoint . '?key=d236e014e2132cb20fc698e823a06020db0e426e&v=0&per_page='. $count, array( 'timeout' => 15 ));
  if (!is_wp_error( $feed )) {
    $feed_json = json_decode(wp_remote_retrieve_body($feed));
    $items = $feed_json->_embedded->$type;
    return $items;
  }
}

// hub feed
function hub_feed($endpoint, $count, $type) {
  $transient_name = 'hub_feed_' . $endpoint . '_' . $count;
  return tlc_transient( $transient_name )
    ->updates_with( 'hub_feed_get', array( $endpoint, $count, $type ) )
    ->expires_in( 900 )
    ->background_only()
    ->get();
}

// flickr feed get
function flickr_feed_get($user_id, $type) {
  $feed = wp_remote_get('https://api.flickr.com/services/feeds/' . $type . '.gne?id=' . $user_id . '&format=json&nojsoncallback=1', array( 'timeout' => 15 ));
  if (!is_wp_error( $feed )) {
    $feed_json = json_decode(wp_remote_retrieve_body($feed));
    $items = $feed_json;
    return $items;
  }
}

// flickr feed
function flickr_feed($user_id, $type) {
  $transient_name = 'flickr_feed_' . $user_id . '_' . $type;
  return tlc_transient( $transient_name )
    ->updates_with( 'flickr_feed_get', array( $user_id, $type ) )
    ->expires_in( 900 )
    ->background_only()
    ->get();
}

// facebook feed get
function facebook_feed_get($user, $count) {
  $feed = wp_remote_get('https://graph.facebook.com/' . $user . '/feed?limit=' . $count . '&access_token=1578006619148757|1c99860a672b4b1582564c559eaf4450', array( 'timeout' => 15 ));
  if (!is_wp_error( $feed )) {
    $feed_json = json_decode(wp_remote_retrieve_body($feed));
    $items = $feed_json->data;
    return $items;
  }
}

// facebook feed
function facebook_feed($user, $count) {
  $transient_name = 'facebook_feed_' . $user . '_' . $count;
  return tlc_transient( $transient_name )
    ->updates_with( 'facebook_feed_get', array( $user, $count ) )
    ->expires_in( 900 )
    ->background_only()
    ->get();
}

// twitter connection
function twitter_connection($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}

// twitter feed get
function twitter_feed_get($user, $count) {
  $consumer_key = 'nX5bqRmoun0jBj8tgtXjupkQv';
  $consumer_secret = 'n92YnMMmRqOoKHJ64of88sDPvHsh3YtUtM3ZXJ4U9IkB570xre';
  $access_token = '16601933-1as3tt5p5BNQxzMkQl0UuwsVGhJC44qUxPEqPrD3G';
  $access_token_secret = 'xLqogvXMrcXqIHu0KJL9uaCKKnb7L52sseVMvQwCWmeWL';
  $connection = twitter_connection($consumer_key, $consumer_secret, $access_token, $access_token_secret);
  $tweets = $connection->get( 'statuses/user_timeline', array( 'screen_name' => $user, 'count' => $count ));
  return $tweets;
}

// twitter feed
function twitter_feed($user, $count) {
  $transient_name = 'twitter_feed_' . $user . '_' . $count;
  return tlc_transient( $transient_name )
    ->updates_with( 'twitter_feed_get', array( $user, $count ) )
    ->expires_in( 900 )
    ->background_only()
    ->get();
}

// autolink
function autolink($str, $attributes=array()) {
  $attrs = '';
  foreach ($attributes as $attribute => $value) {
    $attrs .= " {$attribute}=\"{$value}\"";
  }

  $str = ' ' . $str;
  $str = preg_replace(
    '`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.)])`i',
    '$1<a href="$2"'.$attrs.'>$2</a>',
    $str
  );
  $str = substr($str, 1);
  
  return $str;
}

// parse tweet text to links
function parse_tweet($text){ 
  //links
  $text = preg_replace(
          '@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@',
           '<a href="$1">$1</a>',
          $text); 
  //users
  $text = preg_replace(
          '/@(\w+)/',
          '<a href="https://twitter.com/$1">@$1</a>',
          $text); 
  //hashtags
  $text = preg_replace(
          '/#(\w+)/',
          '<a href="https://twitter.com/hashtag/$1?src=hashtag">#$1</a>',
          $text); 
  return $text;
}

// time since
function time_since($time) {
  $time = time() - $time; // to get the time since that moment
  $tokens = array (
    31536000 => 'year',
    2592000 => 'month',
    604800 => 'week',
    86400 => 'day',
    3600 => 'hour',
    60 => 'minute',
    1 => 'second'
  );
  foreach ($tokens as $unit => $text) {
    if ($time < $unit) continue;
    $numberOfUnits = floor($time / $unit);
    return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'').' ago';
  }
}

////////////////////////////////////////////////////////////////////////////////////////////////////

// Register Custom Taxonomy
function taxonomy_resource_category() {

  $labels = array(
    'name'                       => 'Categories',
    'singular_name'              => 'Category',
    'menu_name'                  => 'Categories',
    'all_items'                  => 'All Categories',
    'parent_item'                => 'Parent Category',
    'parent_item_colon'          => 'Parent Category:',
    'new_item_name'              => 'New Category Name',
    'add_new_item'               => 'Add New Category',
    'edit_item'                  => 'Edit Category',
    'update_item'                => 'Update Category',
    'separate_items_with_commas' => 'Separate Categories with commas',
    'search_items'               => 'Search Categories',
    'add_or_remove_items'        => 'Add or remove Categories',
    'choose_from_most_used'      => 'Choose from the most used Categories',
    'not_found'                  => 'Not Found',
  );
  $rewrite = array(
    'slug'                       => 'resources/categories',
    'with_front'                 => false,
    'hierarchical'               => true,
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
    'rewrite'                    => $rewrite,
  );
  register_taxonomy( 'resource_category', array( 'resource' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'taxonomy_resource_category', 0 );

// Register Custom Post Type
function post_type_resource() {

  $labels = array(
    'name'                => 'Resources',
    'singular_name'       => 'Resource',
    'menu_name'           => 'Resources',
    'parent_item_colon'   => 'Parent Resource:',
    'all_items'           => 'All Resources',
    'view_item'           => 'View Resource',
    'add_new_item'        => 'Add New Resource',
    'add_new'             => 'Add New',
    'edit_item'           => 'Edit Resource',
    'update_item'         => 'Update Resource',
    'search_items'        => 'Search Resources',
    'not_found'           => 'Not found',
    'not_found_in_trash'  => 'Not found in Trash',
  );
  $rewrite = array(
    'slug'                => 'resources',
    'with_front'          => false,
    'pages'               => true,
    'feeds'               => true,
  );
  $args = array(
    'labels'              => $labels,
    'supports'            => array( 'title', ),
    'taxonomies'          => array( 'resource_category' ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_admin_bar'   => true,
    'show_in_nav_menus'   => true,
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'             => $rewrite,
    'capability_type'     => 'post',
  );
  register_post_type( 'resource', $args );

}

// Hook into the 'init' action
add_action( 'init', 'post_type_resource', 0 );

// Register Custom Post Type
function post_type_staff() {

  $labels = array(
    'name'                => 'Staff',
    'singular_name'       => 'Staff Member',
    'menu_name'           => 'Staff',
    'parent_item_colon'   => 'Parent Staff Member:',
    'all_items'           => 'All Staff',
    'view_item'           => 'View Staff Member',
    'add_new_item'        => 'Add New Staff Member',
    'add_new'             => 'Add New',
    'edit_item'           => 'Edit Staff Member',
    'update_item'         => 'Update Staff Member',
    'search_items'        => 'Search Staff',
    'not_found'           => 'Not found',
    'not_found_in_trash'  => 'Not found in Trash',
  );
  $rewrite = array(
    'slug'                => 'staff',
    'with_front'          => false,
    'pages'               => true,
    'feeds'               => true,
  );
  $args = array(
    'labels'              => $labels,
    'supports'            => array( 'title', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_admin_bar'   => true,
    'show_in_nav_menus'   => true,
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'             => $rewrite,
    'capability_type'     => 'post',
  );
  register_post_type( 'staff', $args );

}

// Hook into the 'init' action
add_action( 'init', 'post_type_staff', 0 );

// hide acf menu item
function hide_acf() {
  remove_menu_page('edit.php?post_type=acf-field-group');
}
add_action('admin_menu', 'hide_acf');

// hide staff menu item on main site
function hide_staff() {
  if (is_main_site()) {
    remove_menu_page('edit.php?post_type=staff');
  }
}
add_action('admin_menu', 'hide_staff');

//hide theme and customize on admin bar and backend for anyone that is not an admin
if ( !is_super_admin() ) {
add_action( 'wp_before_admin_bar_render', 'admin_bar_hide' ); 
add_action('admin_menu', 'customize_admin_menu_hide', 999);
add_action( 'wp_before_admin_bar_render', 'wpse200296_before_admin_bar_render' ); 

}
function admin_bar_hide()
{
    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('customize');
	$wp_admin_bar->remove_node( 'themes' );
}

function customize_admin_menu_hide(){
	
global $submenu;
// Appearance customize Menu
unset($submenu['themes.php'][6]);	
	
}
//hide the customize on admin bar
function wpse200296_before_admin_bar_render()
{
    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('customize');
}
$the_current_site = get_bloginfo('name');
if($the_current_site == 'Student Employment Services' || is_super_admin() ){echo '';}
else{add_filter('tiny_mce_before_init', 'myformatTinyMCE');  
}
  // only show p h2 h3 h4 and preformatted in wysiwyg 
   function myformatTinyMCE($in){
$in['block_formats'] = "Paragraph=p;Header 2=h2;Header 3=h3;Header 4=h4;Preformatted=pre";
return $in;
}
// hide resources menu item on sub site
function hide_resource() {
  if (!is_main_site()) {
    remove_menu_page('edit.php?post_type=resource');
  }
}
add_action('admin_menu', 'hide_resource');

// set posts per archive page
function set_posts_per_archive_page() {
  if ( is_post_type_archive('resource') || is_post_type_archive('staff') || is_search() ) {
    $limit = -1;
  } else {
    $limit = get_option('posts_per_page');
  }
  set_query_var('posts_per_archive_page', $limit);
}
add_filter('pre_get_posts', 'set_posts_per_archive_page');
//add options page
if( function_exists('acf_add_options_page') && is_super_admin() && !is_main_site() ) {
	
	acf_add_options_page('Splash');
	
}
add_filter( 'soliloquy_defaults', 'tgm_soliloquy_set_defaults', 100, 2 );
function tgm_soliloquy_set_defaults( $defaults, $post_id ) {
     	
		 $defaults['slider_theme']  = 'classic';
        // You can easily set default values here. See the get_config_defaults method in the includes/global/common.php file for all available defaults to modify (around L250).
        // In this example, we will modify the default slider size to 1000 x 500.
        $defaults['slider_width']  = 1000;
        $defaults['slider_height'] = 500;
		 
	
     
        // Return the modified defaults.
        return $defaults;
     
}
      add_action( 'soliloquy_api_after_transition', 'tgm_soliloquy_force_auto' );
    function tgm_soliloquy_force_auto( $data ) {
    	
    	ob_start();
    	?>
    	soliloquy_slider['<?php echo $data['id']; ?>'].startAuto();
    	<?php
    	echo ob_get_clean();
    	
    }

	add_action( 'init', 'tgm_soliloquy_restrict_admin_access', -1 );
function tgm_soliloquy_restrict_admin_access() {
 
	if ( ! is_admin() ) {
		return;
	}
 
if ( class_exists( 'Soliloquy_Lite' ) ) {
	if ( ! current_user_can( 'update_core' ) ) {
		remove_action( 'init', array( Soliloquy_Lite::get_instance(), 'init' ), 0 );
		remove_action( 'widgets_init', array( Soliloquy_Lite::get_instance(), 'widget' ) );
	}
}

}
add_filter( 'wp_feed_cache_transient_lifetime', 
   create_function('$a', 'return 60;') );


