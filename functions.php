<?php
    require_once('shortcodes.php');
//add custom php functions here.


//Allow shortcodes in widget text area
add_filter('widget_text', 'do_shortcode');

/**
* SSL URL fixer
* Fix for broken srcset urls
**/

//wordpress 4.4 srcset ssl fix
function ssl_srcset( $sources ) {
  foreach ( $sources as &$source ) {
    $source['url'] = set_url_scheme( $source['url'] );
  }

  return $sources;
}
add_filter( 'wp_calculate_image_srcset', 'ssl_srcset' );


/**
 * Strings passed to this function will be modified under the assumption that
 * they were outputted by wordpress' the_output filter.  It checks for a handful
 * of things like empty, unnecessary, and unclosed tags.
 *
 * @return string
 * @author Jared Lang
 **/
function cleanup($content){
	# Balance auto paragraphs
	$lines = explode("\n", $content);
	foreach($lines as $key=>$line){
		$null = null;
		$found_closed = preg_match_all('/<\/p>/', $line, $null);
		$found_opened = preg_match_all('/<p[^>]*>/', $line, $null);
		
		$diff = $found_closed - $found_opened;
		# Balanced tags
		if ($diff == 0){continue;}
		
		# missing closed
		if ($diff < 0){
			$lines[$key] = $lines[$key] . str_repeat('</p>', abs($diff));
		}
		
		# missing open
		if ($diff > 0){
			$lines[$key] = str_repeat('<p>', abs($diff)) . $lines[$key];
		}
	}
	$content = implode("\n", $lines);
	
	#Remove incomplete tags at start and end
	$content = preg_replace('/^<\/p>[\s]*/i', '', $content);
	$content = preg_replace('/[\s]*<p>$/i', '', $content);
	$content = preg_replace('/^<br \/>/i', '', $content);
	$content = preg_replace('/<br \/>$/i', '', $content);

	#Remove paragraph and linebreak tags wrapped around shortcodes
	$content = preg_replace('/(<p>|<br \/>)\[/i', '[', $content);
	$content = preg_replace('/\](<\/p>|<br \/>)/i', ']', $content);

	#Remove empty paragraphs
	$content = preg_replace('/<p><\/p>/i', '', $content);

	return $content;
}


//Register all Wordpress menus
//============================
function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'small-header-menu' => __( 'Small Header Menu'),
      'side-menu' => __( 'Side Menu' ),
      'footer-menu' => __( 'Footer Menu' ),
      'footer-menu-small' => __( 'Footer Menu Small' ),
    )
  );
}
add_action( 'init', 'register_my_menus' );


//This section below loads the javascript and css used throughout the entire site
//. ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . 

function wpt_register_js() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js", false, null);
    wp_register_script('jquery.ui', "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js", false, null);
    wp_register_script('jquery.bootstrap.min', "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js", false, null);
    wp_register_script('rss2json', "https://rss2json.com/gfapi.js", false, null);
    wp_register_script('jquery.scripts', get_template_directory_uri(). '/js/scripts.js', 'jquery');

    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery.ui');
    wp_enqueue_script('jquery.bootstrap.min');
    wp_enqueue_script('rss2json');
    wp_enqueue_script('jquery.scripts');
}
add_action( 'init', 'wpt_register_js' );

function wpt_register_css() {
    wp_register_style( 'normalize', get_stylesheet_directory_uri() . '/css/normalize.css', array(), '1', 'all' );
    wp_register_style( 'jquery.ui.css', "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css");
    wp_register_style( 'bootstrap.min', "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");
    wp_register_style( 'font-awesome.min.css', "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
    wp_register_style( 'style', get_stylesheet_directory_uri() . '/style.css', array(), '1', 'all' );

    wp_enqueue_style( 'normalize');
    wp_enqueue_style( 'jquery.ui.css');
    wp_enqueue_style( 'bootstrap.min' );
    wp_enqueue_style( 'font-awesome.min.css' );
    wp_enqueue_style( 'style');
 //   wp_enqueue_style( 'gravity-bootstrap');
}
add_action( 'wp_enqueue_scripts', 'wpt_register_css' );

// Add sidebar
//==============================
function theme_slug_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Main Sidebar', 'theme-slug' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
        'before_widget' => '<div class="sidebar-collapse">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<h4 class="widget-title"><a class="menu-toggle" data-toggle="collapse" aria-expanded="true" aria-controls="collapseExample"><span class="glyphicon glyphicon-minus-sign" style="float:right"></span>',
        'after_title'   => '</a></h4><div class="collapse in">',
    ) );
}
add_action( 'widgets_init', 'theme_slug_widgets_init' );


/**
* Modfied term list
* Allows you to exclude an array of terms from the list.
*
* Example: <?php echo get_modified_term_list( $post->ID, 'subject', '', ', ', '', array(term) ); ?>
*
**/

function get_modified_term_list( $id = 0, $taxonomy, $before = '', $sep = '', $after = '', $exclude = array() ) {
    $terms = get_the_terms( $id, $taxonomy );

    if ( is_wp_error( $terms ) )
        return $terms;

    if ( empty( $terms ) )
        return false;

    foreach ( $terms as $term ) {

        if(!in_array($term->slug,$exclude)) {
            $link = get_term_link( $term, $taxonomy );
            if ( is_wp_error( $link ) )
                return $link;
            $term_links[] = '<a href="' . $link . '" rel="tag">' . $term->name . '</a>';
        }
    }

    if( !isset( $term_links ) )
        return false;

    return $before . join( $sep, $term_links ) . $after;
}


/**
* Staff Directory Custom Post Type & Taxonomies
**/

function register_cpt_staff_entities() {

  //Staff Custom Post Type
    $staff_labels = array(
      'name' => _x( 'Staff', 'staff' ),
      'singular_name' => _x( 'Staff', 'staff' ),
      'add_new' => _x( 'Add New', 'staff' ),
      'add_new_item' => _x( 'Add New Staff Member', 'staff' ),
      'edit_item' => _x( 'Edit Staff Member', 'staff' ),
      'new_item' => _x( 'New Staff Member', 'staff' ),
      'view_item' => _x( 'View Staff Member', 'staff' ),
      'search_items' => _x( 'Search Staff', 'staff' ),
      'not_found' => _x( 'No staff found', 'staff' ),
      'not_found_in_trash' => _x( 'No staff found in Trash', 'staff' ),
      'parent_item_colon' => _x( 'Parent Staff:', 'staff' ),
      'menu_name' => _x( 'Staff', 'staff' ),
    );

    $staff_args = array(
      'labels' => $staff_labels,
      'hierarchical' => true,
      'description' => 'Staff names and descriptions',
      'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions' ),
      'taxonomies' => array( 'department', 'unit-group', 'subject' ),
      'public' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_icon' => 'dashicons-id',
      'menu_position' => 20,
      'show_in_nav_menus' => true,
      'publicly_queryable' => true,
      'exclude_from_search' => false,
      'has_archive' => true,
      'query_var' => true,
      'can_export' => true,
      'rewrite' => array( 'with_front' => false ),
      'capability_type' => 'post'
    );
    register_post_type( 'staff', $staff_args );

  // Roll Taxonomy
    $roll_labels = array(
      'name' => _x( 'Roll', 'taxonomy general name' ),
      'singular_name' => _x( 'Roll', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Rolls' ),
      'all_items' => __( 'All Rolls' ),
      'parent_item' => __( 'Parent Roll' ),
      'parent_item_colon' => __( 'Parent Roll:' ),
      'edit_item' => __( 'Edit Roll' ),
      'update_item' => __( 'Update Roll' ),
      'add_new_item' => __( 'Add New Roll' ),
      'new_item_name' => __( 'New Roll Name' ),
      'menu_name' => __( 'Roll' ),
    );
  
    $roll_args = array(
      'hierarchical' => true,
      'labels' => $department_labels,
      'show_ui' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'rewrite' => array( 'slug' => 'staff', 'with_front' => false ),
    );
    register_taxonomy('roll',array('staff'), $roll_args );
}

add_action( 'init', 'register_cpt_staff_entities' );


// Slug rewrite for staff custom post type and taxonomies
function generate_staff_taxonomy_rewrite_rules( $wp_rewrite ) {
  $rules = array();
  $post_types = get_post_types( array( 'name' => 'staff', 'public' => true, '_builtin' => false ), 'objects' );
  $taxonomies = get_taxonomies( array( 'name' => 'roll', 'public' => true, '_builtin' => false ), 'objects' );

  foreach ( $post_types as $post_type ) {
    $post_type_name = $post_type->name; // 'developer'
    $post_type_slug = $post_type->rewrite['slug']; // 'developers'

    foreach ( $taxonomies as $taxonomy ) {
      if ( $taxonomy->object_type[0] == $post_type_name ) {
        $terms = get_categories( array( 'type' => $post_type_name, 'taxonomy' => $taxonomy->name, 'hide_empty' => 0 ) );
        foreach ( $terms as $term ) {
          $rules[$post_type_slug . '/' . $term->slug . '/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug;
        }
      }
    }
  }
  $wp_rewrite->rules = $rules + $wp_rewrite->rules;
}
add_action('generate_rewrite_rules', 'generate_staff_taxonomy_rewrite_rules');



//Adding in Featured image feature
if ( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size( 150, 150, true ); // default Post Thumbnail dimensions (cropped)

  // additional image sizes
  // delete the next line if you do not need additional image sizes
  add_image_size( 'staff-thumbnail', 300, 9999 ); //300 pixels wide (and unlimited height)
  add_image_size( 'homepage-thumbnail', 100, 100, true );

}


/**
* Pagination
* Adds pagination to archive pages.
*
* <?php wpbeginner_numeric_posts_nav(); ?>
*
**/
function wpbeginner_numeric_posts_nav() {

    if( is_singular() )
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<nav><ul class="pagination pagination-sm">' . "\n";

    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link() );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li><span>…</span></li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li><span>…</span></li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link() );

    echo '</ul></nav>' . "\n";

}

/**
* Allow html 
* This will allow defined html 5 data attributes to html tags
*
**/
function mawaha_filter_allowed_html($allowed, $context){
 
    if (is_array($context))
    {
        return $allowed;
    }
 
    if ($context === 'post')
    {
            // Example case
        $allowed['a']['data-toggle'] = true;
        $allowed['a']['data-dismiss'] = true;
        $allowed['a']['data-parent'] = true;
        $allowed['a']['data-placement'] = true;
        $allowed['a']['data-target'] = true;
        $allowed['a']['aria-controls'] = true;
        $allowed['a']['aria-expanded'] = true;
        $allowed['a']['aria-label'] = true;
        $allowed['a']['aria-labelledby'] = true;
        $allowed['a']['aria-hidden'] = true;
        $allowed['button']['data-toggle'] = true;
        $allowed['button']['data-dismiss'] = true;
        $allowed['button']['data-placement'] = true;
        $allowed['button']['data-target'] = true;
        $allowed['button']['aria-label'] = true;
        $allowed['button']['aria-labelledby'] = true;
        $allowed['button']['aria-hidden'] = true;
        $allowed['div']['data-placement'] = true;   
        $allowed['div']['aria-labelledby'] = true;
        $allowed['div']['aria-hidden'] = true;
        $allowed['div']['aria-multiselectable'] = true;
        $allowed['span']['aria-hidden'] = true;

    }
 
    return $allowed;
}
add_filter('wp_kses_allowed_html', 'mawaha_filter_allowed_html', 10, 2);

?>
