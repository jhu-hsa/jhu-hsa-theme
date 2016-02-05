<?php
/*
Template Name: Home
*/
?>

<?php get_header(); ?>
<?php get_template_part( 'part', 'alert-home' ); ?>
<?php if (have_rows('collage')) : ?>
  <div class="collage-wrap">
    <section class="collage">
      <ul>
        <?php while (have_rows('collage')) : the_row(); ?>
          <li>
            <div class="collage__block" style="background-image: url(<?php $image = get_sub_field('image'); echo $image['sizes']['collage']; ?>);">
              <div class="collage__overlay">
                <div class="collage__overlay__content">
                  <h2><?php the_sub_field('title'); ?></h2>
                  <a class="button" href="<?php the_sub_field('button_link'); ?>"<?php if (get_sub_field('button_target')) : ?> target="<?php the_sub_field('button_target'); ?>"<?php endif; ?>><span><?php the_sub_field('button_text'); ?></span></a>
                </div>
              </div>
            </div>
          </li>
        <?php endwhile; ?>
      </ul>
    </section>
  </div>
<?php endif; ?>

<?php if (get_field('community_events') && get_field('homewood_events')) : ?>
  <div class="wrap">
    <hr class="hr--transparent">
    <h1>Events</h1>
    <div class="wrap wrap--flush">
      <div class="split__left">
        <div class="feed-stack">
          <?php $community_events = hub_feed(get_field('community_events'), '3', 'events'); ?>
          <?php if ($community_events) : ?>
            <h4 class="heading--serif">Community Events</h4>
            <ul>
              <?php foreach ($community_events as $event) : ?>
                <li>
                  <div class="feed__item">
                    <p class="feed__date"><?php echo date('F j, Y', strtotime($event->start_date)); ?></p>
                    <h3><?php echo $event->name; ?></h3>
                    <p class="feed__more"><a href="<?php echo $event->url; ?>" target="_blank">Read More...</a></p>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>
      <div class="split__right">
        <div class="detail-list">
          <?php $homewood_events = hub_feed(get_field('homewood_events'), '4', 'events'); ?>
          <?php if ($homewood_events) : ?>
            <h4 class="heading--serif">Homewood Events</h4>
            <ul>
              <?php foreach ($homewood_events as $event) : ?>
                <li>
                  <div class="detail-list__date"><?php echo date('F j, Y', strtotime($event->start_date)); ?></div>
                  <div class="detail-list__title"><a href="<?php echo $event->url; ?>" target="_blank"><?php echo $event->name; ?></a></div>
                  <div class="detail-list__time"><?php echo date('g:i a', strtotime($event->start_time)); ?></div>
                  <div class="detail-list__location"><?php echo $event->_embedded->locations[0]->name; ?></div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>
    </div>
	  <a class="button" href="http://hub.jhu.edu/events" style="display: block; margin: 0 auto 1rem auto; width:21.5%;">View All Upcoming Events</a>
   </div>
<?php endif; ?>

<section class="social">

  <hr class="hr--transparent">
  <h1 class="h1--white">Life at This Moment</h1>

  
  
  <?php
function processURL($url)
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 2
        ));

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    //$tag = 'jhuhsa';
  $userid='self';
    $client_id = get_field('Instagram_token');
   //$url = 'https://api.instagram.com/v1/tags/'.$tag.'/media/recent?client_id='.$client_id;
$url = 'https://api.instagram.com/v1/users/'.$userid.'/feed?access_token='. $client_id.'&count=20';
    //echo $url;
  $all_result  = processURL($url);
    $decoded_results = json_decode($all_result, true);

   //echo '<pre>';
    //print_r($decoded_results);
    //exit;
echo '<div class="social__slider"><ul>';
    //Now parse through the $results array to display your results... 
  $i = 0;
    foreach($decoded_results['data'] as $item){
    
     echo '<li>';
     //  $image_link = $item['images']['thumbnail']['low_resolution']['standard_resolution']['url'];
        $insta_img = $item['images']['low_resolution']['url'];
    $insta_author = $item['caption']['from']['username']; 
    $insta_link = $item['link'];
    $insta_date = $item['created_time'];
    $insta_likes = $item['likes']['count']; 
    $insta_comments = $item['comments']['count'];
  $insta_userlink= 'https://instagram.com';
  $insta_title= $item['user']['full_name'];
  $insta_imagename= $item['caption']['text'];
 
  
   ?>
<div class="social__slider__instagram" style="background-image: url(<?php echo $insta_img; ?>);"></div>
<div class="social__slider__overlay">
                <ul class="social__slider__icons">
                  <li><a class="icon-button icon-button--instagram" href="<?php echo $insta_userlink.'/'.$insta_author; ?>" target="_blank"><span>Instagram</span></a></li>
                  <li><a class="icon-button icon-button--link" href="<?php echo $insta_link; ?>" target="_blank"><span>Link</span></a></li>
                </ul>
                <div class="social__slider__title">
                  <?php echo $insta_title; ?>
                </div>
                <div class="social__slider__detail">
                  <p><?php echo substr($insta_imagename, 0, 75); ?><a href="<?php echo $insta_link; ?>" target="_blank"><nobr>Read More...</nobr></a></p>
                  <p><strong><?php echo date('M j, Y', $insta_date); ?></strong></p>
                  <p><a href="<?php echo $insta_userlink.'/'.$insta_author; ?>" target="_blank">View Feed &raquo;</a></p>
                </div>
              </div>


    <?php
       echo '</li>';
  
   $i++;
    }
 echo '</ul></div>';
?>

  <div class="social__slider social__slider--feed">
    <ul>
      <?php if (have_rows('hub_feeds')) : ?>
        <?php while (have_rows('hub_feeds')) : the_row(); ?>
          <?php $hub = hub_feed(get_sub_field('endpoint'), get_sub_field('number_of_items'), get_sub_field('content_type')); ?>
          <?php if ($hub) : ?>
            <?php foreach ($hub as $item) : ?>
              <li>
                <div class="social__slider--feed__item">
                  <ul class="social__slider__icons">
                    <li><a class="icon-button icon-button--hub" href="http://hub.jhu.edu/"><span>HUB</span></a></li>
                    <li><a class="icon-button icon-button--link" href="<?php echo $item->url; ?>"><span>Link</span></a></li>
                  </ul>
                  <div class="social__slider--feed__content">
                    <div class="social__slider--feed__header">
                      <a href="<?php echo $item->url; ?>">News from the HUB</a> &bull; <?php echo date('F j, Y', $item->publish_date); ?>
                    </div>
                    <p><?php echo $item->excerpt; ?></p>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        <?php endwhile; ?>
      <?php endif; ?>
	  
	  
      <?php if (have_rows('twitter_feeds')) : ?>
        <?php while (have_rows('twitter_feeds')) : the_row(); ?>
          <?php $tweets = twitter_feed(get_sub_field('username'), get_sub_field('number_of_items')); ?>
          <?php if ($tweets) : ?>
            <?php foreach ($tweets as $item) : ?>
              <li>
                <div  class="social__slider--feed__item">
                  <ul class="social__slider__icons">
                    <li><a class="icon-button icon-button--twitter" href="https://twitter.com/<?php echo $item->user->screen_name; ?>" target="_blank"><span>Twitter</span></a></li>
                    <li><a class="icon-button icon-button--link" href="https://twitter.com/statuses/<?php echo $item->id; ?>" target="_blank"><span>Link</span></a></li>
                  </ul>
                  <div class="social__slider--feed__content">
                    <div class="social__slider--feed__header">
                      <img class="social__slider__twitter-profile" src="<?php echo $item->user->profile_image_url; ?>" alt="">
                      <a href="https://twitter.com/<?php echo $item->user->screen_name; ?>"><?php echo $item->user->name; ?></a><br><span>@<?php echo $item->user->screen_name; ?></span>
                    </div>
                    <p><?php echo parse_tweet($item->text); ?></p>
                    <div class="social__slider--feed__meta">
                      <a href="https://twitter.com/intent/favorite?tweet_id=<?php echo $item->id; ?>"><i class="fa fa-star"></i></a>
                      <a href="https://twitter.com/intent/retweet?tweet_id=<?php echo $item->id; ?>"><i class="fa fa-retweet"></i></a>
                      <a href="https://twitter.com/intent/tweet?in-reply-to=<?php echo $item->id; ?>"><i class="fa fa-reply"></i></a>
                      <?php echo time_since(strtotime($item->created_at)); ?>
                    </div>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        <?php endwhile; ?>
      <?php endif; ?>
      <?php if (have_rows('facebook_feeds')) : ?>
        <?php while (have_rows('facebook_feeds')) : the_row(); ?>
          <?php $facebook = facebook_feed(get_sub_field('username'), get_sub_field('number_of_items')); ?>
          <?php if ($facebook) : ?>
            <?php foreach ($facebook as $item) : ?>
              <li>
                <div  class="social__slider--feed__item">
                  <ul class="social__slider__icons">
                    <li><a class="icon-button icon-button--facebook" href="https://facebook.com/profile.php?id=<?php echo $item->from->id; ?>" target="_blank"><span>Facebook</span></a></li>
                    <li><a class="icon-button icon-button--link" href="https://facebook.com/<?php echo str_replace('_', '/posts/', $item->id); ?>" target="_blank"><span>Link</span></a></li>
                  </ul>
                  <div class="social__slider--feed__content">
                    <div class="social__slider--feed__header">
                      <a href="https://facebook.com/profile.php?id=<?php echo $item->from->id; ?>"><?php echo $item->from->name; ?></a>
                    </div>
                    <p><?php echo autolink($item->message); ?></p>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        <?php endwhile; ?>
      <?php endif; ?>
    </ul>
  </div>

</section>

<?php if (have_rows('feature')) : ?>
  <div class="feature">
    <div class="wrap">
      <hr class="hr--transparent">
      <?php if (get_field('feature_heading')) : ?>
        <h1><?php the_field('feature_heading'); ?></h1>
      <?php endif; ?>
      <ul class="feature__slider">
        <?php while (have_rows('feature')) : the_row(); ?>
          <li>
            <div class="feature__slider__image" style="background-image: url(<?php $image = get_sub_field('image'); echo $image['sizes']['feature']; ?>);"></div>
            <div class="feature__slider__info">
              <h2><?php the_sub_field('title'); ?></h2>
              <p><a href="<?php the_sub_field('link'); ?>"<?php if (get_sub_field('link_target')) : ?> target="<?php the_sub_field('link_target'); ?>"<?php endif; ?>><?php the_sub_field('link_text'); ?> &raquo;</a></p>
            </div>
            <div class="feature__slider__links">
              <h5 class="heading--serif"><?php the_sub_field('related_heading'); ?></h5>
              <?php if (have_rows('related_list')) : ?>
                <ul>
                  <?php while (have_rows('related_list')) : the_row(); ?>
                    <li><a href="<?php the_sub_field('link'); ?>"<?php if (get_sub_field('target')) : ?> target="<?php the_sub_field('target'); ?>"<?php endif; ?>><?php the_sub_field('title'); ?></a></li>
                  <?php endwhile; ?>
                </ul>
              <?php endif; ?>
            </div>
          </li>
        <?php endwhile; ?>
      </ul>
    </div>
  </div>
<?php endif; ?>

<?php get_footer(); ?>