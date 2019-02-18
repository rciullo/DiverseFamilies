
<?php get_header(); ?>
<div id="main">
	<div id="title_bar" class="container">
	<!-- tag.php -->
		<div class="row">
			<div class="col-sm-12">
				<header><h1><a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ) ?>">News &amp; Blog</a></h1></header>
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
					<h2 class="subpage-title"><?php single_cat_title('Posts Tagged: '); ?></h2>
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
						<?php if (has_post_thumbnail()): ?>
							<div class="post-header-img"><a href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a></div>
						<?php endif; ?>
							<div class="news-post-content">
								<div class="news-post-title">
									<header>
					                  <h2><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
					                  <span class="news-post-category"><?php echo trim($output, $separator); ?></span>
                					  <span class="news-post-date">Posted: <i class="fa fa-calendar"></i> <?php echo get_the_time('F jS, Y'); ?></span>
                					</header>
								</div>
								<p><?php the_content(__('(more...)')); ?></p>
								<p><?php comments_template( $file, $separate_comments ); ?></p>
							</div>
						</div>
					</article>
					<?php endwhile; else: ?>
					<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
					<?php wpbeginner_numeric_posts_nav(); ?>					
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
