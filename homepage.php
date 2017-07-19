<?php
/*
Template Name: Home Page
Description: A Template for the Website homepage.
*/

add_filter( 'wp_title', 'baw_hack_wp_title_for_home' );
function baw_hack_wp_title_for_home( $title )
{
  if( empty( $title ) && ( is_home() || is_front_page() ) ) {
    return __( 'Home', 'theme_domain' );
  }
  return $title;
}
?>


<?php get_header(); ?>
<h1 class="sr-only"><?php echo get_the_title(); ?></h1>
<div id="main">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

  		<?php the_content(__('(more...)')); ?>
		<?php endwhile; else: ?>
		<?php _e('Sorry, no posts matched your criteria.'); ?><?php endif; ?>
  </div>
<script type="text/javascript">

<?php get_footer(); ?>