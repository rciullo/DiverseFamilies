<?php
/*
Template Name: No sidebar
Description: This page template does not have a sidebar.
*/
?>

<?php get_header(); ?>
<div id="main">
	<div id="title_bar" class="container">
	<!-- no_sidebar -->
		<div class="row">
			<div class="col-sm-12">
				<header><h1><?php the_title(); ?></h1></header>
			</div>
		</div>
	</div>
	<div id="content" class="container">
		<div class="row">
			<div class="col-sm-12">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<article>
				<?php the_content(__('(more...)')); ?>
				</article>
				<hr> <?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>