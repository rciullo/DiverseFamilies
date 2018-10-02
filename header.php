<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Diverse Families 
 * @since Diverse Families Theme
 */
?><!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php wp_title( '', true, 'right' ); ?></title>
		<meta name="viewport" content="width=device-width">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<?php wp_head(); ?> 
	</head>
	<body>
	    <header class="site-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-push-3">
            <a class="site-title" href="<?php bloginfo('url')?>"><?php bloginfo('name')?></a>
          </div><!-- col-md-3 -->
          <div class="col-md-3 col-md-pull-6">
            <nav role="navigation">
	            <?php /* Primary navigation */
								wp_nav_menu( array(
								  'menu' 				=> 'Small Header Menu',
								  'theme_location' => 'small-header-menu',
								  'depth'				=> 2,
								  'menu_class' 	=> 'list-unstyled list-inline text-center small-menu'
								  )
								);
							?>
            </nav>
          </div><!-- col-md-3 -->
          <div class="col-md-3">
            <div class="site-search">
            	<?php get_search_form(); ?>
            </div><!-- site-search -->
          </div><!-- col-md-3 -->
        </div><!-- row -->
        <div class="row">
        	<div class="col-md-12">
            <nav role="navigation">
	            <?php /* Primary navigation */
								wp_nav_menu( array(
								  'menu' 				=> 'Header Menu',
								  'theme_location' => 'header-menu',
								  'depth'				=> 2,
								  'menu_class' 	=> 'list-unstyled list-inline text-center main-menu'
								  )
								);
							?>
            </nav>
          </div>
        </div>
      </div><!-- container -->
    </header>

