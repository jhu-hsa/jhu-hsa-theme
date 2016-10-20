<?php
/*
Template Name: Resource Landing
*/
?>

<?php get_header(); ?>

<?php get_template_part( 'part', 'breadcrumbs' ); ?>

<?php if (get_field('splash_image','option')) : ?>
  <div class="splash-wrap">
    <section class="splash" style="background-image: url(<?php $splash_image = get_field('splash_image','option'); echo $splash_image['sizes']['splash']; ?>);">
      <div class="splash__text">
        <h1><?php the_title(); ?></h1>
      </div>
      <a class="splash__expand"><span>Expand</span></a>
    </section>
  </div>
<?php endif; ?>

<div class="wrap">

  <?php get_sidebar('nav'); ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <section class="main">
      <h1><?php the_title(); ?></h1>
      <div class="wrap wrap--flush">
        <div class="main__content main__content--alt">
          <?php the_content(); ?>
        </div>
        <div class="main__sidebar main__sidebar--alt">
          <div class="sidebar__block">
            <div class="sidebar__info">
			<?php //the_field('additional_information'); ?>
			 		 <h3>Contact Us</h3>
				<?php //the_title('<h3>','</h3>'); ?>
<?php

// check if the repeater field has rows of data
if( have_rows('contact_information') ):

  // loop through the rows of data
    while ( have_rows('contact_information') ) : the_row();
 echo '<p>';

        // display a sub field value
    if (get_sub_field('address_title')){ echo '<strong>'.strip_tags(get_sub_field('address_title')).'</strong><br />';} else{echo '';}

  //echo '<p><strong>Johns Hopkins University</strong><br />';
  if (get_sub_field('street_address')){ echo get_sub_field('street_address').'<br />';} else{echo '';}
  if (get_sub_field('building_name')){ echo get_sub_field('building_name').'<br />';} else{echo '';}
  if (get_sub_field('room_number')){ echo 'Suite '.get_sub_field('room_number').'<br />';} else{echo '';}
         if (get_sub_field('street_address')){ echo 'Baltimore, MD 21218';} else{echo '';}
 echo '</p>';


    endwhile;

else :

    // no rows found

endif;

?>				
<?php

// check if the repeater field has rows of data
if( have_rows('contact_phone_fax') ):
//echo '<h2>Contacts</h2>';
  // loop through the rows of data
    while ( have_rows('contact_phone_fax') ) : the_row();

    echo '<p>';     // display a sub field value
  if (get_sub_field('contact_title')){ echo '<strong>'.strip_tags(get_sub_field('contact_title')).'</strong><br />';} else{echo '';}
 
  if (get_sub_field('phone_number')){ echo '<strong>Tel: </strong>410-516-'.get_sub_field('phone_number').'<br />';} else{echo '';}
  if (get_sub_field('fax_number')){ echo '<strong>Fax: </strong>410-516-'.get_sub_field('fax_number').'<br />';} else{echo '';}
  if (get_sub_field('e_mail')){   echo '<a href="mailto:'.get_sub_field('e_mail').'">'.get_sub_field('e_mail').'</a>';
} else{echo '';}
echo '</p>';
  



    endwhile;

else :

    // no rows found

endif;

?>


<?php
if( have_rows('single_time_and_hours') && get_field('hours_of_operation')=='Single time and day'){
	echo '<h3>Hours</h3>';
  // loop through the rows of data
    while ( have_rows('single_time_and_hours') && get_field('hours_of_operation')=='Single time and day' ) : the_row();

        // display a sub field value
  if (get_sub_field('hours_title')){ echo '<h4>'.strip_tags(get_sub_field('hours_title')).'</h4>';} else{echo '';}
  echo '<p>';
  if (get_sub_field('sunday_start') && get_sub_field('sunday_end')){ echo '<strong>Sunday: </strong>'.get_sub_field('sunday_start').' - '.get_sub_field('sunday_end').'<br />';} else{echo '';}
  if (get_sub_field('monday_start') && get_sub_field('monday_end')){ echo '<strong>Monday: </strong>'.get_sub_field('monday_start').' - '.get_sub_field('monday_end').'<br />';} else{echo '';}
   
    if (get_sub_field('tuesday_start') && get_sub_field('tuesday_end')){ echo '<strong>Tuesday: </strong>'.get_sub_field('tuesday_start').' - '.get_sub_field('tuesday_end').'<br />';} else{echo '';}
    
	if (get_sub_field('wedensday_start') && get_sub_field('wedensday_end')){ echo '<strong>Wednesday: </strong>'.get_sub_field('wedensday_start').' - '.get_sub_field('wedensday_end').'<br />';} else{echo '';}
    
	if (get_sub_field('thursday_start') && get_sub_field('thursday_end')){ echo '<strong>Thursday: </strong>'.get_sub_field('thursday_start').' - '.get_sub_field('thursday_end').'<br />';} else{echo '';}
    
	if (get_sub_field('friday_start') && get_sub_field('friday_end')){ echo '<strong>Friday: </strong>'.get_sub_field('friday_start').' - '.get_sub_field('friday_end').'<br />';} else{echo '';}
       
	   if (get_sub_field('saturday_start') && get_sub_field('saturday_end')){ echo '<strong>Saturday: </strong>'.get_sub_field('saturday_start').' - '.get_sub_field('saturday_end').'<br />';} else{echo '';}
      
	  if (get_sub_field('time_notes')){ echo '<span style="font-style: italic;color:#003b5d;">'.strip_tags(get_sub_field('time_notes')).'</span>';} else{echo '';}


echo '</p>';
  



    endwhile;
}elseif( have_rows('multiple_days_same_time') && get_field('hours_of_operation')=='Multiple Days same time'){
	echo '<h3>Hours</h3>';
    // loop through the rows of data
    while ( have_rows('multiple_days_same_time') && get_field('hours_of_operation')=='Multiple Days same time' ) : the_row();

        // display a sub field value
  if (get_sub_field('hours_title')){ echo '<h4>'.get_sub_field('hours_title').'</h4>';} else{echo '';}
  echo '<p>';
  if (get_sub_field('first_day') && get_sub_field('last_day')){ echo '<strong>'.get_sub_field('first_day').' - '.get_sub_field('last_day').' : </strong>'.get_sub_field('hours_start').' - '.get_sub_field('hours_end').'<br />';} else{echo '';}
 
   
       
	  if (get_sub_field('time_notes') ){ echo '<span style="font-style: italic;color:#003b5d;">'.strip_tags(get_sub_field('time_notes')).'</span>';} else{echo '';}


echo '</p>';
  



    endwhile;
}else{echo '';}


?> 
			  
              <?php if (get_field('facebook_link') || get_field('twitter_link') || get_field('map_link') || get_field('linkedin_link') || get_field('flickr_link') || get_field('youtube_link') || get_field('instagram_link')) : ?>
                <ul class="icon-list">
                  <?php if (get_field('facebook_link')) : ?>
                    <li><a class="icon-button icon-button--facebook" href="<?php the_field('facebook_link'); ?>" target="_blank"><span>Facebook</span></a></li>
                  <?php endif; ?>
                  <?php if (get_field('twitter_link')) : ?>
                    <li><a class="icon-button icon-button--twitter" href="<?php the_field('twitter_link'); ?>" target="_blank"><span>Twitter</span></a></li>
                  <?php endif; ?>
                  <?php if (get_field('map_link')) : ?>
                    <li><a class="icon-button icon-button--map" href="<?php the_field('map_link'); ?>" target="_blank"><span>Map</span></a></li>
                  <?php endif; ?>
                  <?php if (get_field('linkedin_link')) : ?>
                    <li><a class="icon-button icon-button--linkedin" href="<?php the_field('linkedin_link'); ?>" target="_blank"><span>LinkedIn</span></a></li>
                  <?php endif; ?>
                  <?php if (get_field('flickr_link')) : ?>
                    <li><a class="icon-button icon-button--flickr" href="<?php the_field('flickr_link'); ?>" target="_blank"><span>Flickr</span></a></li>
                  <?php endif; ?>
                  <?php if (get_field('youtube_link')) : ?>
                    <li><a class="icon-button icon-button--youtube" href="<?php the_field('youtube_link'); ?>" target="_blank"><span>YouTube</span></a></li>
                  <?php endif; ?>
                  <?php if (get_field('instagram_link')) : ?>
                    <li><a class="icon-button icon-button--instagram" href="<?php the_field('instagram_link'); ?>" target="_blank"><span>Instagram</span></a></li>
                  <?php endif; ?>
                  <?php if (get_field('vimeo_link')) : ?>
                    <li><a class="icon-button icon-button--vimeo" href="<?php the_field('vimeo_link'); ?>" target="_blank"><span>Vimeo</span></a></li>
                  <?php endif; ?>
				  <?php if (get_field('smug_link')) : ?>
                    <li><a class="icon-button icon-button--smug" href="<?php the_field('smug_link'); ?>" target="_blank"><span>SmugMug</span></a></li>
                  <?php endif; ?>
                </ul>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php endwhile; endif; ?>

  <?php get_sidebar(); ?>

</div>

<?php if (get_field('upcoming_events')) : ?>
  <?php $events = hub_feed(get_field('upcoming_events'), '3', 'events'); ?>
  <?php if ($events) : ?>
    <section class="feed">
      <div class="wrap">
        <hr>
        <h2 class="heading--serif heading--centered">Upcoming Events</h2>
        <ul>
          <?php foreach ($events as $event) : ?>
            <li>
              <div class="feed__item">
                <a class="feed__icon icon-button icon-button--hub" href="http://hub.jhu.edu/"><span>HUB</span></a>
                <p class="feed__date"><?php echo date('F j, Y', strtotime($event->start_date)); ?></p>
                <h3><?php echo $event->name; ?></h3>
                <p class="feed__more"><a href="<?php echo $event->url; ?>">Read More...</a></p>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
		<a class="button button--blue"" href="http://hub.jhu.edu/<?php if (get_field('see_more_events')) : the_field('see_more_events'); endif; ?>" style="display: block; margin: 0 auto 2rem auto; width:22%; text-align:center; min-width:180px;">View All Upcoming Events</a>
		      </div>
			  
    </section>
 
  <?php endif; ?>
<?php endif; ?>

<section class="feed feed--gray">
  <div class="wrap">
    <hr class="hr--transparent">
    <h2 class="heading--serif heading--centered">News &amp; Announcements</h2>
    <ul>
      <?php $query = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => '6', 'category__not_in' => array(get_category_by_slug('archived')->term_id),  'category__in' => array(1,3) ) ); ?>
      <?php $count = $query->post_count; $hub_count = 6 - $count; ?>
      <?php if ( $query->have_posts() ) : ?>
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
          <li>
            <div class="feed__item feed__item--info">
              <?php if (has_post_thumbnail()) : ?>
                <div class="feed__image" style="background-image: url(<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-preview')[0]; ?>);"></div>
              <?php endif; ?>
              <div class="feed__item__content">
                <h4><?php the_title(); ?></h4>
                <?php if (in_category('announcements')) : ?>
                  <?php the_content(); ?>
                <?php else : ?>
                  <?php the_excerpt(); ?>
                <?php endif; ?>
                <?php if (in_category('news')) : ?>
                  <p class="feed__more"><a href="<?php the_permalink(); ?>">Read More...</a></p>
                <?php endif; ?>
              </div>
            </div>
          </li>
        <?php endwhile; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
      <?php if (get_field('news_&_announcements') && $hub_count > 0) : ?>
        <?php $news = hub_feed(get_field('news_&_announcements'), '6', 'articles'); ?>
        <?php if ($news) : ?>
          <?php $hub_items = 0; ?>
          <?php foreach ($news as $article) : ?>
            <?php if ($hub_items < $hub_count) : ?>
            <?php $image = $article->_embedded->image_thumbnail; ?>
              <li>
                <div class="feed__item <?php if ($image !== null) { echo 'feed__item--media'; } else { echo 'feed__item--gray'; }; ?>">
                  <a class="feed__icon icon-button icon-button--hub" href="http://hub.jhu.edu/"><span>HUB</span></a>
                  <?php if ($image !== null) : ?>
                    <div class="feed__image" style="background-image: url(<?php echo $article->_embedded->image_thumbnail[0]->sizes->landscape; ?>);"></div>
                  <?php endif; ?>
                  <div class="feed__item__content">
                    <h4><?php echo $article->alt_headline; ?></h4>
                    <p><?php echo $article->excerpt; ?></p>
                    <p class="feed__more"><a href="<?php echo $article->url; ?>">Read More...</a></p>
                  </div>
                </div>
              </li>
              <?php $hub_items++; ?>
          <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      <?php endif; ?>
    </ul>
  </div>
</section>

<?php get_template_part( 'part', 'related-links' ); ?>

<?php get_template_part( 'part', 'resource-finder' ); ?>

<?php get_footer(); ?>