      <footer class="footer" role="contentinfo">
        <div class="wrap">
          <div class="footer__block">
            <a class="footer__logo" href="//www.jhu.edu"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.svg" alt="Johns Hopkins University"></a>
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