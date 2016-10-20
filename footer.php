      <footer class="footer">
        <div class="wrap">
          <div class="footer__block">
            <a class="footer__logo" href="//www.jhu.edu"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="Johns Hopkins University"></a>
          </div>
          <?php switch_to_blog(1); ?>
            <?php wp_nav_menu(array(
              'menu' => 'footer',
              'container' => false,
              'menu_class' => 'footer__menu'
            )); ?>
          <?php restore_current_blog(); ?>
          <div class="footer__block footer__block--copyright">
            <p>&copy; Johns Hopkins University<br>Baltimore, Maryland 410-516-8000<br>All rights reserved</p>
          </div>
        </div>
      </footer>
    </div>


    <?php wp_footer(); ?>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  //JHU Student Affairs Account
  ga('create', 'UA-64979302-1', 'auto');

  //JHU Global Account
  ga('create', 'UA-82200180-1', 'auto', 'jhuGlobal', {'allowLinker' : true});
  ga('require', 'linker');
  ga('jhuGlobal.linker:autoLink', ['johnshopkins.edu', 'jh.edu']);

  ga('send', 'pageview');
  ga('jhuGlobal.send', 'pageview');

</script>
		<script type="text/javascript">
/*<![CDATA[*/
(function() {
var sz = document.createElement('script'); sz.type = 'text/javascript'; sz.async = true;
sz.src = '//siteimproveanalytics.com/js/siteanalyze_6059671.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sz, s);
})();
/*]]>*/
</script>
  </body>
</html>