<?php get_header(); ?>
<div id="main">
	<div id="title_bar" class="container">
		<!-- single.php -->
		<div class="row">
			<div class="col-sm-12">
				<header><h1><a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ) ?>">Blog</a></h1></header>
				<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
			</div>
		</div>
	</div>

	<div id="content" class="container">
		<div class="row">
			<div id="sidebar" class="col-sm-3">
				<?php get_sidebar(); ?>
			</div>
			<div id="content_area" class="col-sm-9">
				<div  class="background-color-gray">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php	
						$categories = get_the_category();
						$separator = ', ';
						$output = '';
						if($categories){
							foreach($categories as $category) {
								$output .= '<a href="'.get_category_link( $category->term_id ).'" title="'.esc_attr( sprintf( __( "View all posts in %s" ), $category->name)).'">'.$category->cat_name.'</a>'.$separator;
							}
						}
						?>
						<article>
							<div class="card">
								<div class="news-post-content">
									<div class="news-post-title">
										<header>
											<h2><?php echo get_the_title(); ?></h2>
											<span class="news-post-category"><?php echo trim($output, $separator); ?></span>
											<span class="news-post-date">Posted: <i class="fa fa-calendar"></i> <?php echo get_the_time('F jS, Y'); ?></span>
										</header>
									</div>
									<?php if (has_post_thumbnail()): ?>
										<div class="wp-block-image">
											<figure class="alignleft"><?php the_post_thumbnail('full'); ?></figure>
										</div>
									<?php endif; ?>
									<?php the_content(__('(more...)')); ?>
									<div class="clearfix"></div>
									<p class="post-tags"><?php the_tags( $before, ', ', $after ); ?> </p>
									<?php comments_template( $file, $separate_comments ); ?>
								</div>
							</div>
						</div>
					</article>
				<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
			</div>
		</div>
	</div>
</div>

</div>
<?php get_footer(); ?>