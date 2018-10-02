		<footer>
			<div class="container">
        <nav class="main-footer">
  				<div class="row">
            <div class="col-md-6 col-md-push-3">
              <div class="footer-center">
                <a class="footer-title" href="<?php bloginfo('url')?>"><?php bloginfo('name')?></a>
                <a class="btn btn-primary browse-btn" href="http://stars.library.ucf.edu/diversefamilies/">Browse Collection</a>
              </div>
            </div>
            <div class="col-xs-6 col-md-3 col-md-pull-6">
  					<?php /* Footer Navigation - Small menu */
  						wp_nav_menu( array(
  						  'theme_location'		=> 'footer-menu-small',
  						  'menu' 				=> 'Footer Menu Small',
  						  'depth'				=> 2,
  						  'menu_class' 			=> 'list-unstyled footer-menu-small',
                'container'   => false)
  						);
  					?>
            </div>
            <div class=" col-xs-6 col-md-3">
  					<?php /* Footer Navigation - Categories */
  						wp_nav_menu( array(
  						  'theme_location'		=> 'footer-menu',
  						  'menu' 				=> 'Footer Menu',
  						  'depth'				=> 2,
  						  'menu_class' 			=> 'list-unstyled text-right footer-menu')
  						);
  					?>
  				</div>
        </nav>
			</div>
		</footer>
		<?php wp_footer(); ?>
	</body>
</html>


