<?php

//----------------------------------------------------------------------------------
//	Include all required files
//----------------------------------------------------------------------------------
require_once( trailingslashit( get_template_directory() ) . 'theme-options.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/widgets/post-list.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/comments.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/customizer.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/meta-box-layout.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/meta-box-fi-display.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/review.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/scripts.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/social-icons.php' );

//----------------------------------------------------------------------------------
//	Include review request
//----------------------------------------------------------------------------------
require_once( trailingslashit( get_template_directory() ) . 'dnh/handler.php' );
new WP_Review_Me( array(
		'days_after' => 14,
		'type'       => 'theme',
		'slug'       => 'mission-news',
		'message'    => __( 'Hey! Sorry to interrupt, but you\'ve been using Mission News for a little while now. If you\'re happy with this theme, could you take a minute to leave a review? <i>You won\'t see this notice again after closing it.</i>', 'mission-news' )
	)
);
//----------------------------------------------------------------------------------
//	Set content width variable
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_set_content_width' ) ) ) {
	function ct_mission_news_set_content_width() {
		if ( ! isset( $content_width ) ) {
			$content_width = 569;
		}
	}
}
add_action( 'after_setup_theme', 'ct_mission_news_set_content_width', 0 );

//----------------------------------------------------------------------------------
//	Add theme support for various features, register menus, load text domain
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_theme_setup' ) ) ) {
	function ct_mission_news_theme_setup() {

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		) );
		add_theme_support( 'infinite-scroll', array(
			'container' => 'loop-container',
			'footer'    => 'overflow-container',
			'render'    => 'ct_mission_news_infinite_scroll_render'
		) );
		add_theme_support( 'custom-logo', array(
			'height'      => 120,
			'width'       => 480,
			'flex-height' => true,
			'flex-width'  => true
		) );
		add_theme_support( 'woocommerce' );

		register_nav_menus( array(
			'primary'   => esc_html__( 'Primary', 'mission-news' ),
			'secondary' => esc_html__( 'Secondary', 'mission-news' )
		) );

		load_theme_textdomain( 'mission-news', get_template_directory() . '/languages' );
	}
}
add_action( 'after_setup_theme', 'ct_mission_news_theme_setup' );

//----------------------------------------------------------------------------------
//	Register widget areas
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_register_widget_areas' ) ) ) {
	function ct_mission_news_register_widget_areas() {

		register_sidebar( array(
			'name'          => esc_html__( 'Left Sidebar', 'mission-news' ),
			'id'            => 'left',
			'description'   => esc_html__( 'Widgets in this area will be shown left of the main post content.', 'mission-news' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Right Sidebar', 'mission-news' ),
			'id'            => 'right',
			'description'   => esc_html__( 'Widgets in this area will be shown right of the main post content.', 'mission-news' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Ad Spot - Below Header', 'mission-news' ),
			'id'            => 'below-header',
			'description'   => esc_html__( 'Widgets in this area will be shown below the header and above the posts and sidebars.', 'mission-news' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Ad Spot - Above Posts', 'mission-news' ),
			'id'            => 'above-main',
			'description'   => esc_html__( 'Widgets in this area will be shown in the center column above the posts.', 'mission-news' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Ad Spot - After Post Content', 'mission-news' ),
			'id'            => 'after-post',
			'description'   => esc_html__( 'Widgets in this area will be shown on post pages after the content.', 'mission-news' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Ad Spot - After Page Content', 'mission-news' ),
			'id'            => 'after-page',
			'description'   => esc_html__( 'Widgets in this area will be shown on pages after the content.', 'mission-news' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Ad Spot - After First Post', 'mission-news' ),
			'id'            => 'after-first-post',
			'description'   => esc_html__( 'Widgets in this area will be shown on the blog after the first post.', 'mission-news' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Footer', 'mission-news' ),
			'id'            => 'site-footer',
			'description'   => esc_html__( 'Widgets in this area will be shown in the footer.', 'mission-news' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
	}
}
add_action( 'widgets_init', 'ct_mission_news_register_widget_areas' );

//----------------------------------------------------------------------------------
//	Output excerpt/content
//  Can't return the_content() so need to use get_the_content()
//  Apply same filter and str_replace() as the_content(): https://developer.wordpress.org/reference/functions/the_content/
//----------------------------------------------------------------------------------
if ( ! function_exists( 'ct_mission_news_excerpt' ) ) {
	function ct_mission_news_excerpt() {
		if ( get_theme_mod( 'full_post' ) == 'yes' ) {		
			$content = get_the_content();
			$content = apply_filters( 'the_content', $content );
			$content = str_replace( ']]>', ']]&gt;', $content );
			return $content;
		} else {
			return wpautop( wp_kses_post( get_the_excerpt() ) );
		}
	}
}

//----------------------------------------------------------------------------------
//	Update excerpt length. Allow user input from Customizer.
//----------------------------------------------------------------------------------
if ( ! function_exists( 'ct_mission_news_custom_excerpt_length' ) ) {
	function ct_mission_news_custom_excerpt_length( $length ) {

		if ( is_admin() ) {
			return $length;
		}
		$new_excerpt_length = get_theme_mod( 'excerpt_length' );

		if ( ! empty( $new_excerpt_length ) && $new_excerpt_length != 25 ) {
			return $new_excerpt_length;
		} elseif ( $new_excerpt_length === 0 ) {
			return 0;
		} else {
			return 25;
		}
	}
}
add_filter( 'excerpt_length', 'ct_mission_news_custom_excerpt_length', 99 );

//----------------------------------------------------------------------------------
// Add plain ellipsis for automatic excerpts ("[...]" => "...")
//----------------------------------------------------------------------------------
if ( ! function_exists( 'ct_mission_news_excerpt_ellipsis' ) ) {
	function ct_mission_news_excerpt_ellipsis() {
		return '&#8230;';
	}
}
add_filter( 'excerpt_more', 'ct_mission_news_excerpt_ellipsis', 10 );

//----------------------------------------------------------------------------------
// Don't scroll to text after clicking a "more tag" link
//----------------------------------------------------------------------------------
if ( ! function_exists( 'ct_mission_news_remove_more_link_scroll' ) ) {
	function ct_mission_news_remove_more_link_scroll( $link ) {
		if ( is_admin() ) {
			return $link;
		}
		$link = preg_replace( '|#more-[0-9]+|', '', $link );
		return $link;
	}
}
add_filter( 'the_content_more_link', 'ct_mission_news_remove_more_link_scroll' );

//----------------------------------------------------------------------------------
// Output the Featured Image
//----------------------------------------------------------------------------------
if ( ! function_exists( 'ct_mission_news_featured_image' ) ) {
	function ct_mission_news_featured_image() {
		$blog_display = apply_filters( 'ct_mission_news_featured_image_display_filter', get_theme_mod( 'featured_image_blog_archives' ) );
		$post_display = apply_filters( 'ct_mission_news_featured_image_display_filter', get_theme_mod( 'featured_image_posts' ) );

		// don't output on archives or post pages when turned off via Customizer setting
		if (
			( (  is_home() || is_archive() || is_search() ) && ($blog_display == 'post' || $blog_display == 'no') )
			|| ( is_singular( 'post' ) && ($post_display == 'blog' || $post_display == 'no' ) )
		) {
			return;
		}

		global $post;
		$featured_image = '';

		if ( has_post_thumbnail( $post->ID ) ) {

			if ( is_singular() ) {
				$featured_image = '<div class="featured-image">' . get_the_post_thumbnail( $post->ID, 'full' ) . '</div>';
			} else {
				$featured_image = '<div class="featured-image"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . get_the_post_thumbnail( $post->ID, 'large' ) . '</a></div>';
			}
		}

		$featured_image = apply_filters( 'ct_mission_news_featured_image', $featured_image );

		if ( $featured_image ) {
			echo $featured_image;
		}
	}
}


/*
 * WP will apply the ".menu-primary-items" class & id to the containing <div> instead of <ul>
 * making styling confusing. This simple wrapper adds a unique class to make styling easier.
 */
if ( ! function_exists( ( 'ct_mission_news_wp_page_menu' ) ) ) {
	function ct_mission_news_wp_page_menu() {
		wp_page_menu( array(
				"menu_class" => "menu-unset",
				"depth"      => - 1
			)
		);
	}
}

//----------------------------------------------------------------------------------
// Add toggle buttons for tier 3+ sub-menus. Used in mobile menu.
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_nav_dropdown_buttons' ) ) ) {
	function ct_mission_news_nav_dropdown_buttons( $item_output, $item, $depth, $args ) {

		if ( $args->theme_location == 'primary' || $args->theme_location == 'secondary' ) {

			if ( in_array( 'menu-item-has-children', $item->classes ) || in_array( 'page_item_has_children', $item->classes ) ) {
				$item_output = str_replace( $args->link_after . '</a>', $args->link_after . '</a><button class="toggle-dropdown" aria-expanded="false" name="toggle-dropdown"><span class="screen-reader-text">' . esc_html_x( "open menu", "verb: open the menu", "mission-news" ) . '</span><i class="fa fa-angle-right"></i></button>', $item_output );
			}
		}

		return $item_output;
	}
}
add_filter( 'walker_nav_menu_start_el', 'ct_mission_news_nav_dropdown_buttons', 10, 4 );

//----------------------------------------------------------------------------------
// Add a label to "sticky" posts on archive pages
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_sticky_post_marker' ) ) ) {
	function ct_mission_news_sticky_post_marker() {

		if ( is_sticky() && !is_archive() && !is_search() ) {
			echo '<div class="sticky-status"><span>' . esc_html__( "Featured", "mission-news" ) . '</span></div>';
		}
	}
}
add_action( 'ct_mission_news_sticky_post_status', 'ct_mission_news_sticky_post_marker' );

//----------------------------------------------------------------------------------
// Reset Customizer settings added by Mission News. Button added in theme-options.php.
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_reset_customizer_options' ) ) ) {
	function ct_mission_news_reset_customizer_options() {

		if ( !isset( $_POST['ct_mission_news_reset_customizer'] ) || 'ct_mission_news_reset_customizer_settings' !== $_POST['ct_mission_news_reset_customizer'] ) {
			return;
		}

		if ( ! wp_verify_nonce( wp_unslash( $_POST['ct_mission_news_reset_customizer_nonce'] ), 'ct_mission_news_reset_customizer_nonce' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		$mods_array = array(
			'layout',
			'date',
			'social_icons_header',
			'tagline_header',
			'search',
			'featured_image_blog_archives',
			'post_author_blog_archives',
			'post_date_blog_archives',
			'archive_title',
			'archive_description',
			'featured_image_posts',
			'post_author_posts',
			'post_date_posts',
			'category_links_posts',
			'tag_links_posts',
			'author_avatar_posts',
			'author_box_posts',
			'more_from_posts',
			'comment_date',
			'author_label',
			'full_post',
			'excerpt_length'
		);

		$social_sites = ct_mission_news_social_array();

		// add social site settings to mods array
		foreach ( $social_sites as $social_site => $value ) {
			$mods_array[] = $social_site;
		}

		$mods_array = apply_filters( 'ct_mission_news_mods_to_remove', $mods_array );

		foreach ( $mods_array as $theme_mod ) {
			remove_theme_mod( $theme_mod );
		}

		$redirect = admin_url( 'themes.php?page=mission-options' );
		$redirect = add_query_arg( 'ct_mission_news_status', 'deleted', $redirect );

		// safely redirect
		wp_safe_redirect( $redirect );
		exit;
	}
}
add_action( 'admin_init', 'ct_mission_news_reset_customizer_options' );

//----------------------------------------------------------------------------------
// Notice to let users know when their Customizer settings have been reset
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_delete_settings_notice' ) ) ) {
	function ct_mission_news_delete_settings_notice() {

		if ( isset( $_GET['ct_mission_news_status'] ) ) {
			?>
			<div class="updated">
				<p><?php esc_html_e( 'Customizer settings deleted', 'mission-news' ); ?>.</p>
			</div>
			<?php
		}
	}
}
add_action( 'admin_notices', 'ct_mission_news_delete_settings_notice' );

//----------------------------------------------------------------------------------
// Add body classes for styling purposes
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_body_class' ) ) ) {
	function ct_mission_news_body_class( $classes ) {

		global $post;
		$full_post   		 				= get_theme_mod( 'full_post' );
		$layout      		 				= get_theme_mod( 'layout' );
		$layout_post 		 				= apply_filters( 'ct_mission_news_layout_filter', get_theme_mod( 'layout_posts' ) );
		$layout_page 		 				= apply_filters( 'ct_mission_news_layout_filter', get_theme_mod( 'layout_pages' ) );
		$layout_archives 				= get_theme_mod( 'layout_archives' );
		$layout_blog 			  		= get_theme_mod( 'layout_blog' );
		$layout_bbpress  				= get_theme_mod( 'layout_bbpress' );
		$layout_woocommerce 		= get_theme_mod( 'layout_woocommerce' );
		$layout_woocommerce_cat = get_theme_mod( 'layout_woocommerce_cat' );

		if ( !function_exists('is_bbpress') ) {
			function is_bbpress() {
				return false;
			}
		}
		if ( !function_exists('is_product') ) {
			function is_product() {
				return false;
			}
			function is_product_category() {
				return false;
			}
		}
		if ( $full_post == 'yes' ) {
			$classes[] = 'full-post';
		} if ( !empty( $layout ) ) {
			$classes[] = 'layout-' . esc_attr( $layout );
		} if ( !empty( $layout_post ) && is_singular('post') && !is_bbpress() ) {
			$classes[] = 'layout-' . esc_attr( $layout_post );
		} if ( !empty( $layout_page ) && is_singular('page') && !is_bbpress() ) {
			$classes[] = 'layout-' . esc_attr( $layout_page );
		} if ( !empty( $layout_archives ) && is_archive() && !is_bbpress() ) {
			$classes[] = 'layout-' . esc_attr( $layout_archives );
		} if ( !empty( $layout_blog ) && is_home() ) {
			$classes[] = 'layout-' . esc_attr( $layout_blog );
		} if ( !empty( $layout_bbpress ) && is_bbpress() ) {
			$classes[] = 'layout-' . esc_attr( $layout_bbpress );
		} if ( !empty( $layout_woocommerce ) && is_product() ) {
			$classes[] = 'layout-' . esc_attr( $layout_woocommerce );
		} if ( !empty( $layout_woocommerce_cat ) && is_product_category() ) {
			$classes[] = 'layout-' . esc_attr( $layout_woocommerce_cat );
		}
		return $classes;
	}
}
add_filter( 'body_class', 'ct_mission_news_body_class' );

//----------------------------------------------------------------------------------
// Add classes to post element for styling purposes
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_post_class' ) ) ) {
	function ct_mission_news_post_class( $classes ) {
		global $wp_query;
		$layout = get_theme_mod( 'layout' );

		// adding a shared class for post divs on archive and single pages
		$classes[] = 'entry';

		if ( !empty( $layout ) && $wp_query->current_post != 0 ) {
			$classes[] = $layout;
		}

		return $classes;
	}
}
add_filter( 'post_class', 'ct_mission_news_post_class' );

//----------------------------------------------------------------------------------
// Used to get messy SVG HTML out of content markup.
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_svg_output' ) ) ) {
	function ct_mission_news_svg_output( $type ) {

		$svg = '';
		if ( $type == 'toggle-navigation' ) {
			$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 18" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-272.000000, -21.000000)" fill="#000000"><g transform="translate(266.000000, 12.000000)"><g transform="translate(6.000000, 9.000000)"><rect class="top-bar" x="0" y="0" width="24" height="2"/><rect class="middle-bar" x="0" y="8" width="24" height="2"/><rect class="bottom-bar" x="0" y="16" width="24" height="2"/></g></g></g></g></svg>';
		} elseif ( $type == 'close' ) {
			$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-17.000000, -12.000000)" fill="#000000"><g transform="translate(17.000000, 12.000000)"><rect transform="translate(10.000000, 10.000000) rotate(45.000000) translate(-10.000000, -10.000000) " x="9" y="-2" width="2" height="24"/><rect transform="translate(10.000000, 10.000000) rotate(-45.000000) translate(-10.000000, -10.000000) " x="9" y="-2" width="2" height="24"/></g></g></g></svg>';
		}

		return $svg;
	}
}

//----------------------------------------------------------------------------------
// Add meta elements for the charset, viewport, and template
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_add_meta_elements' ) ) ) {
	function ct_mission_news_add_meta_elements() {

		$meta_elements = '';

		$meta_elements .= sprintf( '<meta charset="%s" />' . "\n", esc_attr( get_bloginfo( 'charset' ) ) );
		$meta_elements .= '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";

		$theme    = wp_get_theme( get_template() );
		$template = sprintf( '<meta name="template" content="%s %s" />' . "\n", esc_attr( $theme->get( 'Name' ) ), esc_attr( $theme->get( 'Version' ) ) );
		$meta_elements .= $template;

		echo $meta_elements;
	}
}
add_action( 'wp_head', 'ct_mission_news_add_meta_elements', 1 );

//----------------------------------------------------------------------------------
// Get the right template for Jetpack infinite scroll
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_infinite_scroll_render' ) ) ) {
	function ct_mission_news_infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'content', 'archive' );
		}
	}
}

//----------------------------------------------------------------------------------
// Template routing function. Setup to follow DRY coding patterns. 
// (Using index.php file only instead of duplicating loop in page.php, post.php, etc.)
//----------------------------------------------------------------------------------
if ( ! function_exists( 'ct_mission_news_get_content_template' ) ) {
	function ct_mission_news_get_content_template() {
		global $wp_query;
		$layout = get_theme_mod( 'layout' );

		// output ad widget area after first post
		if ( is_main_query() && $wp_query->current_post == 1 ) {
			get_sidebar( 'after-first-post' );
		}

		if ( is_home() || is_archive() || is_search() ) {
			if ( !empty( $layout ) && $layout != 'simple' && $wp_query->current_post != 0 ) {
				get_template_part( 'content-archive-' . esc_attr( $layout ), get_post_type() );
			} else {
				get_template_part( 'content-archive', get_post_type() );
			}
		} else {
			get_template_part( 'content', get_post_type() );
		}
	}
}

//----------------------------------------------------------------------------------
// Filters the_archive_title() like this: "Category: Business" => "Business" 
// the_archive_title() is used in content/archive-header.php
//----------------------------------------------------------------------------------
if ( ! function_exists( 'ct_mission_news_modify_archive_titles' ) ) {
	function ct_mission_news_modify_archive_titles( $title ) {

		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = get_the_author();
		} elseif ( is_month() ) {
			$title = single_month_title( ' ' );
		}
		// is_year() and is_day() neglected b/c there is no analogous function for retrieving the page title

		return $title;
	}
}
add_filter( 'get_the_archive_title', 'ct_mission_news_modify_archive_titles' );

//----------------------------------------------------------------------------------
// Add paragraph tags for author bio displayed in content/archive-header.php.
// the_archive_description includes paragraph tags for tag and category descriptions, but not the author bio. 
//----------------------------------------------------------------------------------
if ( ! function_exists( 'ct_mission_news_modify_archive_descriptions' ) ) {
	function ct_mission_news_modify_archive_descriptions( $description ) {

		if ( is_author() ) {
			$description = wpautop( $description );
		}
		return $description;
	}
}
add_filter( 'get_the_archive_description', 'ct_mission_news_modify_archive_descriptions' );

//----------------------------------------------------------------------------------
// Output the post byline. Used in content-archive.php and inc/widgets/post-list.php
// Using function instead of template part so widget can pass in variables 
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_post_byline' ) ) ) {
	function ct_mission_news_post_byline( $author, $date ) {

		if ( $author == 'no' && $date == 'no' ) {
			return;
		}
		$post_author = get_the_author();
		// add compatibility when used in header before loop
		if ( empty( $post_author ) ) {
			global $post;
			$post_author = get_the_author_meta( 'display_name', $post->post_author );
		}
		$post_date = date_i18n( get_option( 'date_format' ), strtotime( get_the_date('r') ) );

		echo '<div class="post-byline">';
		if ( $author == 'no' ) {
			echo esc_html( $post_date );
		} elseif ( $date == 'no' ) {
			// translators: %s = the author who published the post
			printf( esc_html_x( 'By %s', 'This blog post was published by some author', 'mission-news' ), esc_html( $post_author ) );
		} else {
			// translators: %1$s = the author who published the post. %2$s = the date it was published
			printf( esc_html_x( 'By %1$s on %2$s', 'This blog post was published by some author on some date ', 'mission-news' ), esc_html( $post_author ), esc_html( $post_date ) );
		}
		echo '</div>';
	}
}

//----------------------------------------------------------------------------------
// Providing a fallback title on the off-chance a post is untitled so it remains clickable on the blog.
// Copying "(title)" which WordPress uses in the admin dashboard.
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_no_missing_titles' ) ) ) {
	function ct_mission_news_no_missing_titles( $title, $id = null ) {
		if ( $title == '' ) {
			$title = esc_html__( '(title)', 'mission-news' );
		}

		return $title;
	}
}
add_filter( 'the_title', 'ct_mission_news_no_missing_titles', 10, 2 );


//----------------------------------------------------------------------------------
// Allow individual posts to override the global layout (via meta box) set in the Customizer 
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_filter_layout' ) ) ) {
	function ct_mission_news_filter_layout( $layout ) {

		if ( is_singular( 'post' ) || is_singular( 'page' ) ) {
			global $post;
			$single_layout = get_post_meta( $post->ID, 'ct_mission_news_post_layout_key', true );

			if ( ! empty( $single_layout ) && $single_layout != 'default' ) {
				$layout = $single_layout;
			}
		}

		return $layout;
	}
}
add_filter( 'ct_mission_news_layout_filter', 'ct_mission_news_filter_layout' );

//----------------------------------------------------------------------------------
// Allow individual posts to override the global Featured Image display setting
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_filter_featured_image_display' ) ) ) {
	function ct_mission_news_filter_featured_image_display( $display ) {

			global $post;
			$single_display = get_post_meta( $post->ID, 'ct_mission_news_featured_image_display', true );

			if ( ! empty( $single_display ) && $single_display != 'default' ) {
				$display = $single_display;
			}

		return $display;
	}
}
add_filter( 'ct_mission_news_featured_image_display_filter', 'ct_mission_news_filter_featured_image_display' );

//----------------------------------------------------------------------------------
// Allows site title to display in Customizer preview when logo is removed
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_logo_refresh' ) ) ) {
	function ct_mission_news_logo_refresh($wp_customize) {
		$wp_customize->get_setting( 'custom_logo' )->transport = 'refresh';
	}
}
add_action( 'customize_register', 'ct_mission_news_logo_refresh', 20 );

//----------------------------------------------------------------------------------
// Add dismissible Mission News Pro admin notice
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_pro_admin_notice' ) ) ) {
	function ct_mission_news_pro_admin_notice() {
		if ( function_exists( ( 'dnh_register_notice' ) ) ) {
			dnh_register_notice( 'ct_mission_news_pro_notice', 'updated', sprintf( __( 'Mission News Pro is now available! <a href="%s" target="_blank">Click here for screenshots & videos</a>.', 'mission-news' ), 'https://www.competethemes.com/mission-news-pro/?utm_source=admin-notice&utm_medium=dashboards' ) );
		}
	}
}
add_action( 'admin_init', 'ct_mission_news_pro_admin_notice' );
	
//----------------------------------------------------------------------------------
// Output styles for widget alignment
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_widget_styles' ) ) ) {
	function ct_mission_news_widget_styles() {
		$css = '';
		$below_header 			= get_theme_mod('ct_mission_widget_styles_below_header_alignment');
		$above_posts  			= get_theme_mod('ct_mission_widget_styles_above_posts_alignment');
		$after_first_post 	= get_theme_mod('ct_mission_widget_styles_after_first_post_alignment');
		$after_post_content = get_theme_mod('ct_mission_widget_styles_after_post_content_alignment');
		$after_page_content = get_theme_mod('ct_mission_widget_styles_after_page_content_alignment');
		$footer 						= get_theme_mod('ct_mission_widget_styles_footer_alignment');
		
		if ( !empty($below_header) ) {
			$css .= ".widget-area-below-header {text-align: $below_header;}";
		}
		if ( !empty($above_posts) ) {
			$css .= ".widget-area-above-main {text-align: $above_posts;}";
		}
		if ( !empty($after_first_post) ) {
			$css .= ".widget-area-after-first-post {text-align: $after_first_post;}";
		}
		if ( !empty($after_post_content) ) {
			$css .= ".widget-area-after-post {text-align: $after_post_content;}";
		}
		if ( !empty($after_page_content) ) {
			$css .= ".widget-area-after-page {text-align: $after_page_content;}";
		}
		if ( !empty($footer) ) {
			$css .= ".widget-area-site-footer {text-align: $footer;}";
		}
		if ( !empty( $css ) ) {
			$css = ct_mission_news_sanitize_css($css);
			wp_add_inline_style( 'ct-mission-news-style', $css );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'ct_mission_news_widget_styles', 99 );

//----------------------------------------------------------------------------------
// Sanitize CSS
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_sanitize_css' ) ) ) {
	function ct_mission_news_sanitize_css( $css ) {
		$css = wp_kses( $css, array( '\'', '\"' ) );
		$css = str_replace( '&gt;', '>', $css );

		return $css;
	}
}

//----------------------------------------------------------------------------------
// Add Recent Posts Extended widgets with same settings as in the demo site and screenshot
// Only runs upon theme activation and if both sidebars are empty
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_set_default_widgets' ) ) ) {
	function ct_mission_news_set_default_widgets() {

		// get active widgets in sidebars
		$active_widgets = get_option( 'sidebars_widgets' );
		
		// if both sidebars are empty
		if ( empty( $active_widgets['left'] ) && empty( $active_widgets['right'] ) ) {
			// prepare counter
			$counter = 1;
			// add new instance of Recent Posts Extended to left sidebar
			$active_widgets['left'][0] = 'ct_mission_news_post_list-' . absint($counter);
			// set default options for the widget
			$widget_options[$counter] = array(
				'title' 				  => __('Latest Posts', 'mission-news'),
				'use_category' 	  => 'yes',
				'category'     	  => 1,
				'use_tag' 			  => 'no',
				'tag'          	  => 1,
				'relationship' 	  => 'AND',
				'author'       	  => 'yes',
				'date'         	  => 'no',
				'image'        	  => 'no',
				'excerpt'     	  => 'yes',
				'excerpt_length'  => 25,
				'comments'     	  => 'yes',
				'post_category'   => 'no',
				'exclude_current' => 'no',
				'post_count'   	 	=> 5,
				'style'        	 	=> 1
			);
			// increment for next widget
			$counter++;
			// add new instance of Recent Posts Extended to right sidebar
			$active_widgets['right'][0] = 'ct_mission_news_post_list-' . absint($counter);
			// set default options for the widget
			$widget_options[$counter] = array(
				'title' 				 	=> __('Latest Posts', 'mission-news'),
				'use_category' 	 	=> 'yes',
				'category'     	 	=> 1,
				'use_tag' 			 	=> 'no',
				'tag'          	 	=> 1,
				'relationship' 	 	=> 'AND',
				'author'       	 	=> 'no',
				'date'         	 	=> 'yes',
				'image'        	 	=> 'yes',
				'excerpt'     	 	=> 'no',
				'excerpt_length' 	=> 25,
				'comments'     	 	=> 'no',
				'post_category'   => 'no',
				'exclude_current' => 'no',
				'post_count'   	 	=> 5,
				'style'        	 	=> 2
			);
			// save settings for both widgets
			update_option( 'widget_ct_mission_news_post_list', $widget_options );
			// save widgets to sidebars
			update_option( 'sidebars_widgets', $active_widgets );
		}
	}
}
add_action( 'after_switch_theme', 'ct_mission_news_set_default_widgets' );

if ( ! function_exists( ( 'ct_mission_news_site_width_css' ) ) ) {
	function ct_mission_news_site_width_css() {
		$site_width = get_theme_mod( 'site_width');
		$css = '';

		if ( !empty($site_width) && $site_width != 1280 ) {
			$css .= '.max-width { max-width: '. absint($site_width) .'px;}';	
			$css .= '.is-sticky .site-header { max-width: '. absint($site_width) .'px !important;}';	
		}
		if ( !empty( $css ) ) {
			$css = ct_mission_news_sanitize_css($css);
			wp_add_inline_style( 'ct-mission-news-style', $css );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'ct_mission_news_site_width_css', 99 );