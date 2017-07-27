<?php

require_once( trailingslashit( get_template_directory() ) . 'theme-options.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/widgets/post-list.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/scripts.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/customizer.php' );
//foreach ( glob( trailingslashit( get_template_directory() ) . 'inc/*' ) as $filename ) {
//	include $filename;
//}

if ( ! function_exists( ( 'ct_mission_set_content_width' ) ) ) {
	function ct_mission_set_content_width() {
		if ( ! isset( $content_width ) ) {
			$content_width = 780;
		}
	}
}
add_action( 'after_setup_theme', 'ct_mission_set_content_width', 0 );

if ( ! function_exists( ( 'ct_mission_theme_setup' ) ) ) {
	function ct_mission_theme_setup() {

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		) );
		add_theme_support( 'infinite-scroll', array(
			'container' => 'loop-container',
			'footer'    => 'overflow-container',
			'render'    => 'ct_mission_infinite_scroll_render'
		) );
		add_theme_support( 'custom-logo', array(
			'height'      => 120,
			'width'       => 480,
			'flex-height' => true,
			'flex-width'  => true
		) );

		register_nav_menus( array(
			'primary'   => esc_html__( 'Primary', 'mission' ),
			'secondary' => esc_html__( 'Secondary', 'mission' )
		) );

		load_theme_textdomain( 'mission', get_template_directory() . '/languages' );
	}
}
add_action( 'after_setup_theme', 'ct_mission_theme_setup' );

if ( ! function_exists( ( 'ct_mission_register_widget_areas' ) ) ) {
	function ct_mission_register_widget_areas() {

		register_sidebar( array(
			'name'          => esc_html__( 'Left Sidebar', 'mission' ),
			'id'            => 'left',
			'description'   => esc_html__( 'Widgets in this area will be shown left of the main post content.', 'mission' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Right Sidebar', 'mission' ),
			'id'            => 'right',
			'description'   => esc_html__( 'Widgets in this area will be shown right of the main post content.', 'mission' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Ad Spot - Below Header', 'mission' ),
			'id'            => 'below-header',
			'description'   => esc_html__( 'Widgets in this area will be shown below the header and above the posts and sidebars.', 'mission' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Ad Spot - Above Posts', 'mission' ),
			'id'            => 'above-main',
			'description'   => esc_html__( 'Widgets in this area will be shown in the center column above the posts.', 'mission' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Ad Spot - After Post Content', 'mission' ),
			'id'            => 'after-post',
			'description'   => esc_html__( 'Widgets in this area will be shown on post pages after the content.', 'mission' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Ad Spot - After Page Content', 'mission' ),
			'id'            => 'after-page',
			'description'   => esc_html__( 'Widgets in this area will be shown on pages after the content.', 'mission' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Ad Spot - After First Post', 'mission' ),
			'id'            => 'after-first-post',
			'description'   => esc_html__( 'Widgets in this area will be shown on the blog after the first post.', 'mission' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
	}
}
add_action( 'widgets_init', 'ct_mission_register_widget_areas' );

if ( ! function_exists( ( 'ct_mission_customize_comments' ) ) ) {
	function ct_mission_customize_comments( $comment, $args, $depth ) { ?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-author">
				<?php
				echo get_avatar( get_comment_author_email(), 36, '', get_comment_author() );
				?>
				<span class="author-name"><?php comment_author_link(); ?></span>
				<span class="comment-date">
					<?php
					global $post;
					if ( $comment->user_id === $post->post_author && get_theme_mod( 'author_label' ) != 'no' ) {
						echo '<span>' . esc_html__( 'Post author', 'mission' ) . '</span>';
						if ( get_theme_mod( 'comment_date' ) != 'no' ) {
							echo ' | ';
						}
					}
					if ( get_theme_mod( 'comment_date' ) != 'no' ) {
						comment_date();
					}
					?>
				</span>
			</div>
			<div class="comment-content">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php esc_html_e( 'Your comment is awaiting moderation.', 'mission' ) ?></em>
					<br/>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
			<div class="comment-footer">
				<?php comment_reply_link( array_merge( $args, array(
					'reply_text' => esc_html__( 'Reply', 'mission' ),
					'depth'      => $depth,
					'max_depth'  => $args['max_depth']
				) ) ); ?>
				<?php edit_comment_link( esc_html__( 'Edit', 'mission' ) ); ?>
			</div>
		</article>
		<?php
	}
}

if ( ! function_exists( 'ct_mission_update_fields' ) ) {
	function ct_mission_update_fields( $fields ) {

		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$label     = $req ? '*' : ' ' . esc_html__( '(optional)', 'mission' );
		$aria_req  = $req ? "aria-required='true'" : '';

		$fields['author'] =
			'<p class="comment-form-author">
	            <label for="author">' . esc_html__( "Name", "mission" ) . esc_html( $label ) . '</label>
	            <input id="author" name="author" type="text" placeholder="' . esc_attr__( "Jane Doe", "mission" ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
			'" size="30" ' . esc_html( $aria_req ) . ' />
	        </p>';

		$fields['email'] =
			'<p class="comment-form-email">
	            <label for="email">' . esc_html__( "Email", "mission" ) . esc_html( $label ) . '</label>
	            <input id="email" name="email" type="email" placeholder="' . esc_attr__( "name@email.com", "mission" ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) .
			'" size="30" ' . esc_html( $aria_req ) . ' />
	        </p>';

		$fields['url'] =
			'<p class="comment-form-url">
	            <label for="url">' . esc_html__( "Website", "mission" ) . '</label>
	            <input id="url" name="url" type="url" placeholder="http://google.com" value="' . esc_attr( $commenter['comment_author_url'] ) .
			'" size="30" />
	            </p>';

		return $fields;
	}
}
add_filter( 'comment_form_default_fields', 'ct_mission_update_fields' );

if ( ! function_exists( 'ct_mission_update_comment_field' ) ) {
	function ct_mission_update_comment_field( $comment_field ) {

		$comment_field =
			'<p class="comment-form-comment">
	            <label for="comment">' . esc_html__( "Comment", "mission" ) . '</label>
	            <textarea required id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
	        </p>';

		return $comment_field;
	}
}
add_filter( 'comment_form_field_comment', 'ct_mission_update_comment_field' );

if ( ! function_exists( 'ct_mission_remove_comments_notes_after' ) ) {
	function ct_mission_remove_comments_notes_after( $defaults ) {
		$defaults['comment_notes_after'] = '';
		return $defaults;
	}
}
add_action( 'comment_form_defaults', 'ct_mission_remove_comments_notes_after' );

if ( ! function_exists( 'ct_mission_excerpt' ) ) {
	function ct_mission_excerpt() {
		if ( get_theme_mod( 'full_post' ) == 'yes' ) {
			return wpautop( get_the_content() );
		} else {
			return wpautop( get_the_excerpt() );
		}
	}
}

if ( ! function_exists( 'ct_mission_custom_excerpt_length' ) ) {
	function ct_mission_custom_excerpt_length( $length ) {

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
add_filter( 'excerpt_length', 'ct_mission_custom_excerpt_length', 99 );

// add plain ellipsis for automatic excerpts (removes [])
if ( ! function_exists( 'ct_mission_excerpt_ellipsis' ) ) {
	function ct_mission_excerpt_ellipsis() {
		return '&#8230;';
	}
}
add_filter( 'excerpt_more', 'ct_mission_excerpt_ellipsis', 10 );

if ( ! function_exists( 'ct_mission_remove_more_link_scroll' ) ) {
	function ct_mission_remove_more_link_scroll( $link ) {
		$link = preg_replace( '|#more-[0-9]+|', '', $link );
		return $link;
	}
}
add_filter( 'the_content_more_link', 'ct_mission_remove_more_link_scroll' );

if ( ! function_exists( 'ct_mission_featured_image' ) ) {
	function ct_mission_featured_image() {

		// don't output on archives or post pages when turned off via Customizer setting
		if (
			( (  is_home() || is_archive() || is_search() ) && get_theme_mod( 'featured_image_blog_archives' ) == 'no' )
			|| ( is_singular( 'post' ) && get_theme_mod( 'featured_image_posts' ) == 'no' )
		) {
			return;
		}

		global $post;
		$featured_image = '';

		if ( has_post_thumbnail( $post->ID ) ) {

			if ( is_singular() ) {
				$featured_image = '<div class="featured-image">' . get_the_post_thumbnail( $post->ID, 'full' ) . '</div>';
			} else {
				$featured_image = '<div class="featured-image"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . get_the_post_thumbnail( $post->ID, 'full' ) . '</a></div>';
			}
		}

		$featured_image = apply_filters( 'ct_mission_featured_image', $featured_image );

		if ( $featured_image ) {
			echo $featured_image;
		}
	}
}

if ( ! function_exists( 'ct_mission_social_array' ) ) {
	function ct_mission_social_array() {

		$social_sites = array(
			'twitter'       => 'ct_mission_twitter_profile',
			'facebook'      => 'ct_mission_facebook_profile',
			'instagram'     => 'ct_mission_instagram_profile',
			'linkedin'      => 'ct_mission_linkedin_profile',
			'pinterest'     => 'ct_mission_pinterest_profile',
			'google-plus'   => 'ct_mission_googleplus_profile',
			'youtube'       => 'ct_mission_youtube_profile',
			'email'         => 'ct_mission_email_profile',
			'email-form'    => 'ct_mission_email_form_profile',
			'500px'         => 'ct_mission_500px_profile',
			'amazon'        => 'ct_mission_amazon_profile',
			'bandcamp'      => 'ct_mission_bandcamp_profile',
			'behance'       => 'ct_mission_behance_profile',
			'codepen'       => 'ct_mission_codepen_profile',
			'delicious'     => 'ct_mission_delicious_profile',
			'deviantart'    => 'ct_mission_deviantart_profile',
			'digg'          => 'ct_mission_digg_profile',
			'dribbble'      => 'ct_mission_dribbble_profile',
			'etsy'          => 'ct_mission_etsy_profile',
			'flickr'        => 'ct_mission_flickr_profile',
			'foursquare'    => 'ct_mission_foursquare_profile',
			'github'        => 'ct_mission_github_profile',
			'google-wallet' => 'ct_mission_google_wallet_profile',
			'hacker-news'   => 'ct_mission_hacker-news_profile',
			'meetup'        => 'ct_mission_meetup_profile',
			'paypal'        => 'ct_mission_paypal_profile',
			'podcast'       => 'ct_mission_podcast_profile',
			'quora'         => 'ct_mission_quora_profile',
			'qq'            => 'ct_mission_qq_profile',
			'ravelry'       => 'ct_mission_ravelry_profile',
			'reddit'        => 'ct_mission_reddit_profile',
			'rss'           => 'ct_mission_rss_profile',
			'skype'         => 'ct_mission_skype_profile',
			'slack'         => 'ct_mission_slack_profile',
			'slideshare'    => 'ct_mission_slideshare_profile',
			'snapchat'      => 'ct_mission_snapchat_profile',
			'soundcloud'    => 'ct_mission_soundcloud_profile',
			'spotify'       => 'ct_mission_spotify_profile',
			'steam'         => 'ct_mission_steam_profile',
			'stumbleupon'   => 'ct_mission_stumbleupon_profile',
			'telegram'      => 'ct_mission_telegram_profile',
			'tencent-weibo' => 'ct_mission_tencent_weibo_profile',
			'tumblr'        => 'ct_mission_tumblr_profile',
			'twitch'        => 'ct_mission_twitch_profile',
			'vimeo'         => 'ct_mission_vimeo_profile',
			'vine'          => 'ct_mission_vine_profile',
			'vk'            => 'ct_mission_vk_profile',
			'wechat'        => 'ct_mission_wechat_profile',
			'weibo'         => 'ct_mission_weibo_profile',
			'whatsapp'      => 'ct_mission_whatsapp_profile',
			'xing'          => 'ct_mission_xing_profile',
			'yahoo'         => 'ct_mission_yahoo_profile',
			'yelp'          => 'ct_mission_yelp_profile'
		);

		return apply_filters( 'ct_mission_social_array_filter', $social_sites );
	}
}

if ( ! function_exists( 'ct_mission_social_icons_output' ) ) {
	function ct_mission_social_icons_output( $source = 'header' ) {

		if ( $source == 'header' && get_theme_mod( 'social_icons_header' ) == 'no' ) {
			return;
		}
		
		$social_sites = ct_mission_social_array();

		// store the site name and url
		foreach ( $social_sites as $social_site => $profile ) {

			if ( $source == 'header' ) {
				if ( strlen( get_theme_mod( $social_site ) ) > 0 ) {
					$active_sites[ $social_site ] = $social_site;
				}
			} elseif ( $source == 'author' ) {
				if ( strlen( get_the_author_meta( $profile ) ) > 0 ) {
					$active_sites[ $profile ] = $social_site;
				}
			}
		}

		if ( ! empty( $active_sites ) ) {

			echo "<ul id='social-media-icons' class='social-media-icons'>";

			foreach ( $active_sites as $key => $active_site ) {

				if ( $active_site == 'email-form' ) {
					$class = 'fa fa-envelope-o';
				} else {
					$class = 'fa fa-' . $active_site;
				}

				echo '<li>';
				if ( $active_site == 'email' ) { ?>
					<a class="email" target="_blank"
					   href="mailto:<?php echo antispambot( is_email( get_theme_mod( $key ) ) ); ?>">
						<i class="fa fa-envelope" title="<?php esc_attr_e( 'email', 'mission' ); ?>"></i>
					</a>
				<?php } elseif ( $active_site == 'skype' ) { ?>
					<a class="<?php echo esc_attr( $active_site ); ?>" target="_blank"
					   href="<?php echo esc_url( get_theme_mod( $key ), array( 'http', 'https', 'skype' ) ); ?>">
						<i class="<?php echo esc_attr( $class ); ?>"
						   title="<?php echo esc_attr( $active_site ); ?>"></i>
					</a>
				<?php } else { ?>
					<a class="<?php echo esc_attr( $active_site ); ?>" target="_blank"
					   href="<?php echo esc_url( get_theme_mod( $key ) ); ?>">
						<i class="<?php echo esc_attr( $class ); ?>"
						   title="<?php echo esc_attr( $active_site ); ?>"></i>
					</a>
					<?php
				}
				echo '</li>';
			}
			echo "</ul>";
		}
	}
}

/*
 * WP will apply the ".menu-primary-items" class & id to the containing <div> instead of <ul>
 * making styling difficult and confusing. Using this wrapper to add a unique class to make styling easier.
 */
if ( ! function_exists( ( 'ct_mission_wp_page_menu' ) ) ) {
	function ct_mission_wp_page_menu() {
		wp_page_menu( array(
				"menu_class" => "menu-unset",
				"depth"      => - 1
			)
		);
	}
}

if ( ! function_exists( ( 'ct_mission_nav_dropdown_buttons' ) ) ) {
	function ct_mission_nav_dropdown_buttons( $item_output, $item, $depth, $args ) {

		if ( $args->theme_location == 'primary' || $args->theme_location == 'secondary' ) {

			if ( in_array( 'menu-item-has-children', $item->classes ) || in_array( 'page_item_has_children', $item->classes ) ) {
				$item_output = str_replace( $args->link_after . '</a>', $args->link_after . '</a><button class="toggle-dropdown" aria-expanded="false" name="toggle-dropdown"><span class="screen-reader-text">' . esc_html_x( "open menu", "verb: open the menu", "mission" ) . '</span><i class="fa fa-angle-right"></i></button>', $item_output );
			}
		}

		return $item_output;
	}
}
add_filter( 'walker_nav_menu_start_el', 'ct_mission_nav_dropdown_buttons', 10, 4 );

if ( ! function_exists( ( 'ct_mission_sticky_post_marker' ) ) ) {
	function ct_mission_sticky_post_marker() {

		if ( is_sticky() && !is_archive() && !is_search() ) {
			echo '<div class="sticky-status"><span>' . esc_html__( "Featured", "mission" ) . '</span></div>';
		}
	}
}
add_action( 'ct_mission_sticky_post_status', 'ct_mission_sticky_post_marker' );

if ( ! function_exists( ( 'ct_mission_reset_customizer_options' ) ) ) {
	function ct_mission_reset_customizer_options() {

		if ( !isset( $_POST['mission_reset_customizer'] ) || 'mission_reset_customizer_settings' !== $_POST['mission_reset_customizer'] ) {
			return;
		}

		if ( ! wp_verify_nonce( wp_unslash( $_POST['ct_mission_reset_customizer_nonce'] ), 'ct_mission_reset_customizer_nonce' ) ) {
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

		$social_sites = ct_mission_social_array();

		// add social site settings to mods array
		foreach ( $social_sites as $social_site => $value ) {
			$mods_array[] = $social_site;
		}

		$mods_array = apply_filters( 'ct_mission_mods_to_remove', $mods_array );

		foreach ( $mods_array as $theme_mod ) {
			remove_theme_mod( $theme_mod );
		}

		$redirect = admin_url( 'themes.php?page=mission-options' );
		$redirect = add_query_arg( 'ct_mission_status', 'deleted', $redirect );

		// safely redirect
		wp_safe_redirect( $redirect );
		exit;
	}
}
add_action( 'admin_init', 'ct_mission_reset_customizer_options' );

if ( ! function_exists( ( 'ct_mission_delete_settings_notice' ) ) ) {
	function ct_mission_delete_settings_notice() {

		if ( isset( $_GET['ct_mission_status'] ) ) {
			?>
			<div class="updated">
				<p><?php esc_html_e( 'Customizer settings deleted', 'mission' ); ?>.</p>
			</div>
			<?php
		}
	}
}
add_action( 'admin_notices', 'ct_mission_delete_settings_notice' );

if ( ! function_exists( ( 'ct_mission_body_class' ) ) ) {
	function ct_mission_body_class( $classes ) {

		global $post;
		$full_post = get_theme_mod( 'full_post' );
		$layout = get_theme_mod( 'layout' );

		if ( $full_post == 'yes' ) {
			$classes[] = 'full-post';
		} if ( !empty( $layout ) ) {
			$classes[] = 'layout-' . $layout;
		}

		return $classes;
	}
}
add_filter( 'body_class', 'ct_mission_body_class' );

if ( ! function_exists( ( 'ct_mission_post_class' ) ) ) {
	function ct_mission_post_class( $classes ) {
		global $wp_query;
		$layout = get_theme_mod( 'layout' );

		// add a shared class for post divs on archive and single pages
		$classes[] = 'entry';

		if ( !empty( $layout ) && $wp_query->current_post != 0 ) {
			$classes[] = $layout;
		}

		return $classes;
	}
}
add_filter( 'post_class', 'ct_mission_post_class' );

if ( ! function_exists( ( 'ct_mission_svg_output' ) ) ) {
	function ct_mission_svg_output( $type ) {

		$svg = '';
		if ( $type == 'toggle-navigation' ) {
			$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 18" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-272.000000, -21.000000)" fill="#000000"><g transform="translate(266.000000, 12.000000)"><g transform="translate(6.000000, 9.000000)"><rect class="top-bar" x="0" y="0" width="24" height="2"/><rect class="middle-bar" x="0" y="8" width="24" height="2"/><rect class="bottom-bar" x="0" y="16" width="24" height="2"/></g></g></g></g></svg>';
		} elseif ( $type == 'close' ) {
			$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-17.000000, -12.000000)" fill="#000000"><g transform="translate(17.000000, 12.000000)"><rect transform="translate(10.000000, 10.000000) rotate(45.000000) translate(-10.000000, -10.000000) " x="9" y="-2" width="2" height="24"/><rect transform="translate(10.000000, 10.000000) rotate(-45.000000) translate(-10.000000, -10.000000) " x="9" y="-2" width="2" height="24"/></g></g></g></svg>';
		}

		return $svg;
	}
}

if ( ! function_exists( ( 'ct_mission_add_meta_elements' ) ) ) {
	function ct_mission_add_meta_elements() {

		$meta_elements = '';

		$meta_elements .= sprintf( '<meta charset="%s" />' . "\n", esc_attr( get_bloginfo( 'charset' ) ) );
		$meta_elements .= '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";

		$theme    = wp_get_theme( get_template() );
		$template = sprintf( '<meta name="template" content="%s %s" />' . "\n", esc_attr( $theme->get( 'Name' ) ), esc_attr( $theme->get( 'Version' ) ) );
		$meta_elements .= $template;

		echo $meta_elements;
	}
}
add_action( 'wp_head', 'ct_mission_add_meta_elements', 1 );

if ( ! function_exists( ( 'ct_mission_infinite_scroll_render' ) ) ) {
	function ct_mission_infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'content', 'archive' );
		}
	}
}

/* Routing templates this way to follow DRY coding patterns
* (using index.php file only instead of duplicating loop in page.php, post.php, etc.)
*/
if ( ! function_exists( 'ct_mission_get_content_template' ) ) {
	function ct_mission_get_content_template() {
		global $wp_query;
		$layout = get_theme_mod( 'layout' );

		// output ad widget area after first post
		if ( is_main_query() && $wp_query->current_post == 1 ) {
			get_sidebar( 'after-first-post' );
		}

		if ( is_home() || is_archive() || is_search() ) {
			if ( !empty( $layout ) && $layout != 'simple' && $wp_query->current_post != 0 ) {
				get_template_part( 'content-archive-' . $layout, get_post_type() );
			} else {
				get_template_part( 'content-archive', get_post_type() );
			}
		} else {
			get_template_part( 'content', get_post_type() );
		}
	}
}

// allow skype URIs to be used
if ( ! function_exists( 'ct_mission_allow_skype_protocol' ) ) {
	function ct_mission_allow_skype_protocol( $protocols ) {
		$protocols[] = 'skype';

		return $protocols;
	}
}
add_filter( 'kses_allowed_protocols' , 'ct_mission_allow_skype_protocol' );

// Remove label that can't be edited with the_archive_title() e.g. "Category: Business" => "Business"
if ( ! function_exists( 'ct_mission_modify_archive_titles' ) ) {
	function ct_mission_modify_archive_titles( $title ) {

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
add_filter( 'get_the_archive_title', 'ct_mission_modify_archive_titles' );

// add paragraph tags for author bio (the_archive_description) includes them for category & tag descriptions
if ( ! function_exists( 'ct_mission_modify_archive_descriptions' ) ) {
	function ct_mission_modify_archive_descriptions( $description ) {

		if ( is_author() ) {
			$description = wpautop( $description );
		}
		return $description;
	}
}
add_filter( 'get_the_archive_description', 'ct_mission_modify_archive_descriptions' );

// sanitize CSS and convert HTML character codes back into ">" character so direct descendant CSS selectors work
if ( ! function_exists( 'ct_mission_sanitize_css' ) ) {
	function ct_mission_sanitize_css( $css ) {
		$css = wp_kses( $css, '' );
		$css = str_replace( '&gt;', '>', $css );

		return $css;
	}
}

// Note: using function instead of template part b/c widget needs to pass in variables
function ct_mission_post_byline( $author, $date ) {

	if ( $author == 'no' && $date == 'no' ) {
		return;
	}
	$post_author = get_the_author();
	// add compatibility when used in header before loop
	if ( empty( $post_author ) ) {
		global $post;
		$post_author = get_the_author_meta( 'display_name', $post->post_author );
	}
	$post_date = date_i18n( get_option( 'date_format' ), strtotime( get_the_date() ) );

	echo '<div class="post-byline">';
		if ( $author == 'no' ) {
			echo esc_html( $post_date );
		} elseif ( $date == 'no' ) {
			// translators: %s = the author who published the post
			printf( esc_html_x( 'By %s', 'This blog post was published by some author', 'mission' ), esc_html( $post_author ) );
		} else {
			// translators: %1$s = the author who published the post. %2$s = the date it was published
			printf( esc_html_x( 'By %1$s on %2$s', 'This blog post was published by some author on some date ', 'mission' ), esc_html( $post_author ), esc_html( $post_date ) );
		}
	echo '</div>';
}

// provide a fallback title on the off-chance a post is untitled so it remains clickable on the blog
function ct_mission_no_missing_titles( $title, $id = null ) {
	if ( $title == '' ) {
		$title = esc_html__( '(title)', 'startup-blog' );
	}
	return $title;
}
add_filter( 'the_title', 'ct_mission_no_missing_titles', 10, 2 );