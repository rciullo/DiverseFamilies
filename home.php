<?php get_header(); ?>

<div id="main">
	<div id="title_bar" class="container">
	<!-- home.php -->
				<header><h1>Blog</h1></header>
	</div>

		<div id="content" class="container">
			<div class="row">
				<div id="sidebar" class="col-sm-3">
					<?php get_sidebar(); ?>
				</div>
				<div id="content_area" class="col-sm-9">
					<div class="background-color-gray">
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
					          <h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
					          <span class="news-post-category"><?php echo trim($output, $separator); ?></span>
                		<span class="news-post-date">Posted: <i class="fa fa-calendar"></i> <?php echo get_the_time('F jS, Y'); ?></span>
                	</header>
								</div>
								<?php the_content(__('(more...)')); ?>
					 			<?php comments_template( $file, $separate_comments ); ?>
              </div>
				    </div>
				  </article>
					<?php endwhile; else: ?>
					</div>
					<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
					<?php wpbeginner_numeric_posts_nav(); ?>
					</div>
				</div>
			</div>
		</div>
</div>
<?php get_footer(); ?>