<?php
/*
The template for displaying 404 pages (Not Found)
*/

get_header(); ?>
<?php get_template_part( 'part', 'breadcrumbs' ); ?>
<div class="wrap">

  <?php get_sidebar('nav'); ?>
 <?php $blog_admin = get_bloginfo('admin_email'); ?>
  <section class="main">
	<h1>Sorry, we can't find it</h1>

<p>This is somewhat embarrassing, isn&rsquo;t it? Perhaps we can help:</p>
    <ul>
	<li>Did you use the Johns Hopkins University search? It's located at the top right of every single page on the site. Chances are you'll find what you're looking for there.<//li>
    <li>Are you looking for information about a particular school? You can <a href="https://www.jhu.edu/schools/">start here</a>.</li>
    <li>If you're trying to find information about a course of study, try <a href="https://www.jhu.edu/academics/">this section</a>.</li>
    <li>The JHU undergraduate admissions site <a href="http://apply.jhu.edu/">is here</a>.</li>
    <li>Still stuck? We're happy to help. Please <a href="mailto:<?php echo $blog_admin;?>">e-mail</a> us and we'll do our best to get you pointed in the right direction.</li></ul>

<p>The mission of The Johns Hopkins University is to educate its students and cultivate their capacity for life-long learning, to foster independent and original research, and to bring the benefits of discovery to the world.</p>

 </section>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
