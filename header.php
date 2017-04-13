<!DOCTYPE html>
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title><?php wp_title(''); ?></title>

<?php wp_head(); ?>
	<?php global $current_user;
      get_currentuserinfo();
if ( is_super_admin() || is_admin() || $current_user->user_level=='3') {
echo '';	
}
else{
?>
<script type="text/javascript">
setTimeout(function(){var a=document.createElement("script");
var b=document.getElementsByTagName("script")[0];
a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0044/9740.js?"+Math.floor(new Date().getTime()/3600000);
a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
</script>


<?php }?>
  
  </head>
  <body>
    <div class="body">
 <?php get_template_part( 'part', 'logo-title' ); ?>
	 <?php get_template_part( 'part', 'menu-search' );  ?>
	 
