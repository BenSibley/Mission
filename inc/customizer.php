<?php

/* Add customizer panels, sections, settings, and controls */
add_action( 'customize_register', 'ct_mission_news_add_customizer_content' );

function ct_mission_news_add_customizer_content( $wp_customize ) {

	//----------------------------------------------------------------------------------
	// Reorder default sections
	//----------------------------------------------------------------------------------
	$wp_customize->get_section( 'title_tagline' )->priority = 2;

	//----------------------------------------------------------------------------------
	// Make sure Front Page setting exists before moving. (Doesn't show if user has no published pages)
	//----------------------------------------------------------------------------------
	if ( is_object( $wp_customize->get_section( 'static_front_page' ) ) ) {
		$wp_customize->get_section( 'static_front_page' )->priority = 5;
		$wp_customize->get_section( 'static_front_page' )->title    = __( 'Front Page', 'mission-news' );
	}

	//----------------------------------------------------------------------------------
	// Add postMessage support for site title and tagline
	//----------------------------------------------------------------------------------
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	//----------------------------------------------------------------------------------
	// Mission News Pro advertisement section
	//----------------------------------------------------------------------------------
	class ct_mission_news_pro_ad extends WP_Customize_Control {
		public function render_content() {
			$link = 'https://www.competethemes.com/mission-news-pro/';
			echo "<a href='" . $link . "' target='_blank'><img src='" . trailingslashit(get_template_directory_uri()) . "assets/images/mission-news-pro.gif' /></a>";
			echo "<p class='bold'>" . sprintf( __('<a target="_blank" href="%1$s">%2$s Pro</a> is the plugin that makes advanced customization simple!', 'mission-news'), $link, wp_get_theme( get_template() ) ) . "</p>";
			echo "<p>" . sprintf( __('%1$s Pro adds the following features to %1$s:', 'mission-news'), wp_get_theme( get_template() ) ) . "</p>";
			echo "<ul>
					<li>" . __('Breaking news ticker', 'mission-news') . "</li>
					<li>" . __('"Featured Videos"', 'mission-news') . "</li>
					<li>" . __('Responsive slider', 'mission-news') . "</li>
					<li>" . __('+ 5 more awesome features', 'mission-news') . "</li>
				  </ul>";
			echo "<p class='button-wrapper'><a target=\"_blank\" class='mission-news-pro-button' href='" . $link . "'>" . sprintf( __('View %s Pro', 'mission-news'), wp_get_theme( get_template() ) ) . "</a></p>";
		}
	}

	//----------------------------------------------------------------------------------
	// Add panels
	//----------------------------------------------------------------------------------
	
	if ( method_exists( 'WP_Customize_Manager', 'add_panel' ) ) {

		$wp_customize->add_panel( 'ct_mission_news_layout_panel', array(
			'priority'    => 25,
			'title'       => __( 'Layout', 'mission-news' ),
			'description' => __( 'Change the layout of the main content and posts.', 'mission-news' )
		) );
		$wp_customize->add_panel( 'ct_mission_news_widget_styles_panel', array(
			'priority'    => 27,
			'title'       => __( 'Widget Styles', 'mission-news' ),
			'description' => __( 'Customize the widget layouts and styles.', 'mission-news' )
		) );
		$wp_customize->add_panel( 'ct_mission_news_show_hide_panel', array(
			'priority'    => 30,
			'title'       => __( 'Show/Hide Elements', 'mission-news' ),
			'description' => __( 'Choose which elements you want displayed on the site.', 'mission-news' )
		) );
	}
	

	//----------------------------------------------------------------------------------
	// Mission News Pro section
	//----------------------------------------------------------------------------------

	// don't add if Mission News Pro is active
	if ( !function_exists( 'ct_mission_news_pro_activation_notice' ) ) {
		// section
		$wp_customize->add_section( 'ct_mission_news_pro', array(
			'title'    => sprintf( __( '%s Pro', 'mission-news' ), wp_get_theme( get_template() ) ),
			'priority' => 1
		) );
		// Upload - setting
		$wp_customize->add_setting( 'mission_news_pro', array(
			'sanitize_callback' => 'absint'
		) );
		// Upload - control
		$wp_customize->add_control( new ct_mission_news_pro_ad(
			$wp_customize, 'mission_news_pro', array(
				'section'  => 'ct_mission_news_pro',
				'settings' => 'mission_news_pro'
			)
		) );
	}
	
	//----------------------------------------------------------------------------------
	// Section: Layout
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_news_layout', array(
		'title'    => __( 'Post Previews', 'mission-news' ),
		'panel'    => 'ct_mission_news_layout_panel',
		'priority' => 1
	) );
	// setting
	$wp_customize->add_setting( 'layout', array(
		'default'           => 'simple',
		'sanitize_callback' => 'ct_mission_news_sanitize_layout'
	) );
	// control
	$wp_customize->add_control( 'layout', array(
		'label'    		=> __( 'Post preview layout', 'mission-news' ),
		'description' => __( 'Change the layout of the posts listed on the blog and archives.', 'mission-news' ),
		'section'  		=> 'ct_mission_news_layout',
		'settings' 		=> 'layout',
		'type'     		=> 'radio',
		'choices'  		=> array(
			'simple'       => __( 'Simple', 'mission-news' ),
			'double'       => __( 'Double', 'mission-news' ),
			'rows'         => __( 'Rows', 'mission-news' ),
			'rows-excerpt' => __( 'Rows with excerpts', 'mission-news' )
		)
	) );
	// section
	$wp_customize->add_section( 'ct_mission_news_layout_posts', array(
		'title'    => __( 'Posts', 'mission-news' ),
		'panel'    => 'ct_mission_news_layout_panel',
		'priority' => 2
	) );
	// setting
	$wp_customize->add_setting( 'layout_posts', array(
		'default'           => 'double-sidebar',
		'sanitize_callback' => 'ct_mission_news_sanitize_layout_posts'
	) );
	// control
	$wp_customize->add_control( 'layout_posts', array(
		'label'       => __( 'Post layout', 'mission-news' ),
		'description' => __( 'Layouts can be changed for individual posts in the post editor.', 'mission-news' ),
		'section'     => 'ct_mission_news_layout_posts',
		'settings'    => 'layout_posts',
		'type'        => 'radio',
		'choices'     => array(
			'double-sidebar'     => __( 'Double sidebar', 'mission-news' ),
			'left-sidebar'       => __( 'Left sidebar', 'mission-news' ),
			'left-sidebar-wide'  => __( 'Left sidebar - wide', 'mission-news' ),
			'right-sidebar'      => __( 'Right sidebar', 'mission-news' ),
			'right-sidebar-wide' => __( 'Right sidebar - wide', 'mission-news' ),
			'no-sidebar'         => __( 'No sidebar', 'mission-news' ),
			'no-sidebar-wide'    => __( 'No sidebar - wide', 'mission-news' )
		)
	) );
	// section - Pages
	$wp_customize->add_section( 'ct_mission_news_layout_pages', array(
		'title'    => __( 'Pages', 'mission-news' ),
		'panel'    => 'ct_mission_news_layout_panel',
		'priority' => 3
	) );
	// setting
	$wp_customize->add_setting( 'layout_pages', array(
		'default'           => 'double-sidebar',
		'sanitize_callback' => 'ct_mission_news_sanitize_layout_posts'
	) );
	// control
	$wp_customize->add_control( 'layout_pages', array(
		'label'       => __( 'Page layout', 'mission-news' ),
		'description' => __( 'Layouts can be changed for individual pages in the page editor.', 'mission-news' ),
		'section'     => 'ct_mission_news_layout_pages',
		'settings'    => 'layout_pages',
		'type'        => 'radio',
		'choices'     => array(
			'double-sidebar'     => __( 'Double sidebar', 'mission-news' ),
			'left-sidebar'       => __( 'Left sidebar', 'mission-news' ),
			'left-sidebar-wide'  => __( 'Left sidebar - wide', 'mission-news' ),
			'right-sidebar'      => __( 'Right sidebar', 'mission-news' ),
			'right-sidebar-wide' => __( 'Right sidebar - wide', 'mission-news' ),
			'no-sidebar'         => __( 'No sidebar', 'mission-news' ),
			'no-sidebar-wide'    => __( 'No sidebar - wide', 'mission-news' )
		)
	) );
	// section - Blog
	$wp_customize->add_section( 'ct_mission_news_layout_blog', array(
		'title'    => __( 'Blog', 'mission-news' ),
		'panel'    => 'ct_mission_news_layout_panel',
		'priority' => 4
	) );
	// setting
	$wp_customize->add_setting( 'layout_blog', array(
		'default'           => 'double-sidebar',
		'sanitize_callback' => 'ct_mission_news_sanitize_layout_posts'
	) );
	// control
	$wp_customize->add_control( 'layout_blog', array(
		'label'       => __( 'Blog layout', 'mission-news' ),
		'section'     => 'ct_mission_news_layout_blog',
		'settings'    => 'layout_blog',
		'type'        => 'radio',
		'choices'     => array(
			'double-sidebar'     => __( 'Double sidebar', 'mission-news' ),
			'left-sidebar'       => __( 'Left sidebar', 'mission-news' ),
			'left-sidebar-wide'  => __( 'Left sidebar - wide', 'mission-news' ),
			'right-sidebar'      => __( 'Right sidebar', 'mission-news' ),
			'right-sidebar-wide' => __( 'Right sidebar - wide', 'mission-news' ),
			'no-sidebar'         => __( 'No sidebar', 'mission-news' ),
			'no-sidebar-wide'    => __( 'No sidebar - wide', 'mission-news' )
		)
	) );
	// section - Archives
	$wp_customize->add_section( 'ct_mission_news_layout_archive', array(
		'title'    => __( 'Archives', 'mission-news' ),
		'panel'    => 'ct_mission_news_layout_panel',
		'priority' => 5
	) );
	// setting
	$wp_customize->add_setting( 'layout_archives', array(
		'default'           => 'double-sidebar',
		'sanitize_callback' => 'ct_mission_news_sanitize_layout_posts'
	) );
	// control
	$wp_customize->add_control( 'layout_archives', array(
		'label'       => __( 'Archive layout', 'mission-news' ),
		'description' => __( 'Change the layout for category, tag, date, and author archives.', 'mission-news' ),
		'section'     => 'ct_mission_news_layout_archive',
		'settings'    => 'layout_archives',
		'type'        => 'radio',
		'choices'     => array(
			'double-sidebar'     => __( 'Double sidebar', 'mission-news' ),
			'left-sidebar'       => __( 'Left sidebar', 'mission-news' ),
			'left-sidebar-wide'  => __( 'Left sidebar - wide', 'mission-news' ),
			'right-sidebar'      => __( 'Right sidebar', 'mission-news' ),
			'right-sidebar-wide' => __( 'Right sidebar - wide', 'mission-news' ),
			'no-sidebar'         => __( 'No sidebar', 'mission-news' ),
			'no-sidebar-wide'    => __( 'No sidebar - wide', 'mission-news' )
		)
	) );
	if ( function_exists('is_bbpress') ) {
		// section - bbPress
		$wp_customize->add_section( 'ct_mission_news_layout_bbpress', array(
			'title'    => __( 'bbPress', 'mission-news' ),
			'panel'    => 'ct_mission_news_layout_panel',
			'priority' => 5
		) );
		// setting
		$wp_customize->add_setting( 'layout_bbpress', array(
			'default'           => 'double-sidebar',
			'sanitize_callback' => 'ct_mission_news_sanitize_layout_posts'
		) );
		// control
		$wp_customize->add_control( 'layout_bbpress', array(
			'label'       => __( 'Forums layout', 'mission-news' ),
			'description' => __( 'Change the layout for all bbPress forum pages.', 'mission-news' ),
			'section'     => 'ct_mission_news_layout_bbpress',
			'settings'    => 'layout_bbpress',
			'type'        => 'radio',
			'choices'     => array(
				'double-sidebar'     => __( 'Double sidebar', 'mission-news' ),
				'left-sidebar'       => __( 'Left sidebar', 'mission-news' ),
				'left-sidebar-wide'  => __( 'Left sidebar - wide', 'mission-news' ),
				'right-sidebar'      => __( 'Right sidebar', 'mission-news' ),
				'right-sidebar-wide' => __( 'Right sidebar - wide', 'mission-news' ),
				'no-sidebar'         => __( 'No sidebar', 'mission-news' ),
				'no-sidebar-wide'    => __( 'No sidebar - wide', 'mission-news' )
			)
		) );
	}
	if ( function_exists('is_woocommerce') ) {
		// section - WooCommerce Product
		$wp_customize->add_section( 'ct_mission_news_layout_woocommerce', array(
			'title'    => __( 'WooCommerce - Products', 'mission-news' ),
			'panel'    => 'ct_mission_news_layout_panel',
			'priority' => 6
		) );
		// setting - WooCommerce Product
		$wp_customize->add_setting( 'layout_woocommerce', array(
			'default'           => 'double-sidebar',
			'sanitize_callback' => 'ct_mission_news_sanitize_layout_posts'
		) );
		// control - WooCommerce Product
		$wp_customize->add_control( 'layout_woocommerce', array(
			'label'       => __( 'Product layout', 'mission-news' ),
			'description' => __( 'Change the layout for all WooCommerce product pages.', 'mission-news' ),
			'section'     => 'ct_mission_news_layout_woocommerce',
			'settings'    => 'layout_woocommerce',
			'type'        => 'radio',
			'choices'     => array(
				'double-sidebar'     => __( 'Double sidebar', 'mission-news' ),
				'left-sidebar'       => __( 'Left sidebar', 'mission-news' ),
				'left-sidebar-wide'  => __( 'Left sidebar - wide', 'mission-news' ),
				'right-sidebar'      => __( 'Right sidebar', 'mission-news' ),
				'right-sidebar-wide' => __( 'Right sidebar - wide', 'mission-news' ),
				'no-sidebar'         => __( 'No sidebar', 'mission-news' ),
				'no-sidebar-wide'    => __( 'No sidebar - wide', 'mission-news' )
			)
		) );
		// section - WooCommerce Category
		$wp_customize->add_section( 'ct_mission_news_layout_woocommerce_cat', array(
			'title'    => __( 'WooCommerce - Categories', 'mission-news' ),
			'panel'    => 'ct_mission_news_layout_panel',
			'priority' => 6
		) );
		// setting - WooCommerce Category
		$wp_customize->add_setting( 'layout_woocommerce_cat', array(
			'default'           => 'double-sidebar',
			'sanitize_callback' => 'ct_mission_news_sanitize_layout_posts'
		) );
		// control - WooCommerce Category
		$wp_customize->add_control( 'layout_woocommerce_cat', array(
			'label'       => __( 'Product layout', 'mission-news' ),
			'description' => __( 'Change the layout for all WooCommerce product categories.', 'mission-news' ),
			'section'     => 'ct_mission_news_layout_woocommerce_cat',
			'settings'    => 'layout_woocommerce_cat',
			'type'        => 'radio',
			'choices'     => array(
				'double-sidebar'     => __( 'Double sidebar', 'mission-news' ),
				'left-sidebar'       => __( 'Left sidebar', 'mission-news' ),
				'left-sidebar-wide'  => __( 'Left sidebar - wide', 'mission-news' ),
				'right-sidebar'      => __( 'Right sidebar', 'mission-news' ),
				'right-sidebar-wide' => __( 'Right sidebar - wide', 'mission-news' ),
				'no-sidebar'         => __( 'No sidebar', 'mission-news' ),
				'no-sidebar-wide'    => __( 'No sidebar - wide', 'mission-news' )
			)
		) );
	}
	// section - Site Width
	$wp_customize->add_section( 'ct_mission_news_layout_site_width', array(
		'title'    => __( 'Site Width', 'mission-news' ),
		'panel'    => 'ct_mission_news_layout_panel'
	) );
	// setting
	$wp_customize->add_setting( 'site_width', array(
		'default'           => 1280,
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( 'site_width', array(
		'label'       => __( 'Maximum site width', 'mission-news' ),
		'description' => __( 'Control the widest the site will get on large screens. Default is 1280px', 'mission-news' ),
		'section'     => 'ct_mission_news_layout_site_width',
		'settings'    => 'site_width',
		'type'        => 'number'
	) );

	//----------------------------------------------------------------------------------
	// Section: Widget Styles - Below Header
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_news_widget_styles_below_header', array(
		'title'    => __( 'Below Header', 'mission-news' ),
		'panel'    => 'ct_mission_news_widget_styles_panel'
	) );
	// setting
	$wp_customize->add_setting( 'ct_mission_widget_styles_below_header_layout', array(
		'default'           => 'row',
		'sanitize_callback' => 'ct_mission_news_sanitize_widget_styles_layout'
	) );
	// control
	$wp_customize->add_control( 'ct_mission_widget_styles_below_header_layout', array(
		'label'       => __( 'Display widgets in a row or column?', 'mission-news' ),
		'section'     => 'ct_mission_news_widget_styles_below_header',
		'settings'    => 'ct_mission_widget_styles_below_header_layout',
		'type'        => 'radio',
		'choices'     => array(
			'row'    => __( 'Row', 'mission-news' ),
			'column' => __( 'Column', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'ct_mission_widget_styles_below_header_alignment', array(
		'default'           => 'center',
		'sanitize_callback' => 'ct_mission_news_sanitize_widget_styles_alignment'
	) );
	// control
	$wp_customize->add_control( 'ct_mission_widget_styles_below_header_alignment', array(
		'label'       => __( 'Widget text alignment', 'mission-news' ),
		'section'     => 'ct_mission_news_widget_styles_below_header',
		'settings'    => 'ct_mission_widget_styles_below_header_alignment',
		'type'        => 'radio',
		'choices'     => array(
			'left'   => __( 'Left', 'mission-news' ),
			'center' => __( 'Center', 'mission-news' ),
			'right'  => __( 'Right', 'mission-news' )
		)
	) );
	//----------------------------------------------------------------------------------
	// Section: Widget Styles - Above Posts
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_news_widget_styles_above_posts', array(
		'title'    => __( 'Above Posts', 'mission-news' ),
		'panel'    => 'ct_mission_news_widget_styles_panel'
	) );
	// setting
	$wp_customize->add_setting( 'ct_mission_widget_styles_above_posts_layout', array(
		'default'           => 'row',
		'sanitize_callback' => 'ct_mission_news_sanitize_widget_styles_layout'
	) );
	// control
	$wp_customize->add_control( 'ct_mission_widget_styles_above_posts_layout', array(
		'label'       => __( 'Display widgets in a row or column?', 'mission-news' ),
		'section'     => 'ct_mission_news_widget_styles_above_posts',
		'settings'    => 'ct_mission_widget_styles_above_posts_layout',
		'type'        => 'radio',
		'choices'     => array(
			'row'    => __( 'Row', 'mission-news' ),
			'column' => __( 'Column', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'ct_mission_widget_styles_above_posts_alignment', array(
		'default'           => 'center',
		'sanitize_callback' => 'ct_mission_news_sanitize_widget_styles_alignment'
	) );
	// control
	$wp_customize->add_control( 'ct_mission_widget_styles_above_posts_alignment', array(
		'label'       => __( 'Widget text alignment', 'mission-news' ),
		'section'     => 'ct_mission_news_widget_styles_above_posts',
		'settings'    => 'ct_mission_widget_styles_above_posts_alignment',
		'type'        => 'radio',
		'choices'     => array(
			'left'   => __( 'Left', 'mission-news' ),
			'center' => __( 'Center', 'mission-news' ),
			'right'  => __( 'Right', 'mission-news' )
		)
	) );

	//----------------------------------------------------------------------------------
	// Section: Widget Styles - After First Post
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_news_widget_styles_after_first_post', array(
		'title'    => __( 'After First Post', 'mission-news' ),
		'panel'    => 'ct_mission_news_widget_styles_panel'
	) );
	// setting
	$wp_customize->add_setting( 'ct_mission_widget_styles_after_first_post_layout', array(
		'default'           => 'row',
		'sanitize_callback' => 'ct_mission_news_sanitize_widget_styles_layout'
	) );
	// control
	$wp_customize->add_control( 'ct_mission_widget_styles_after_first_post_layout', array(
		'label'       => __( 'Display widgets in a row or column?', 'mission-news' ),
		'section'     => 'ct_mission_news_widget_styles_after_first_post',
		'settings'    => 'ct_mission_widget_styles_after_first_post_layout',
		'type'        => 'radio',
		'choices'     => array(
			'row'    => __( 'Row', 'mission-news' ),
			'column' => __( 'Column', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'ct_mission_widget_styles_after_first_post_alignment', array(
		'default'           => 'center',
		'sanitize_callback' => 'ct_mission_news_sanitize_widget_styles_alignment'
	) );
	// control
	$wp_customize->add_control( 'ct_mission_widget_styles_after_first_post_alignment', array(
		'label'       => __( 'Widget text alignment', 'mission-news' ),
		'section'     => 'ct_mission_news_widget_styles_after_first_post',
		'settings'    => 'ct_mission_widget_styles_after_first_post_alignment',
		'type'        => 'radio',
		'choices'     => array(
			'left'   => __( 'Left', 'mission-news' ),
			'center' => __( 'Center', 'mission-news' ),
			'right'  => __( 'Right', 'mission-news' )
		)
	) );

	//----------------------------------------------------------------------------------
	// Section: Widget Styles - After Post Content
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_news_widget_styles_after_post_content', array(
		'title'    => __( 'After Post Content', 'mission-news' ),
		'panel'    => 'ct_mission_news_widget_styles_panel'
	) );
	// setting
	$wp_customize->add_setting( 'ct_mission_widget_styles_after_post_content_layout', array(
		'default'           => 'row',
		'sanitize_callback' => 'ct_mission_news_sanitize_widget_styles_layout'
	) );
	// control
	$wp_customize->add_control( 'ct_mission_widget_styles_after_post_content_layout', array(
		'label'       => __( 'Display widgets in a row or column?', 'mission-news' ),
		'section'     => 'ct_mission_news_widget_styles_after_post_content',
		'settings'    => 'ct_mission_widget_styles_after_post_content_layout',
		'type'        => 'radio',
		'choices'     => array(
			'row'    => __( 'Row', 'mission-news' ),
			'column' => __( 'Column', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'ct_mission_widget_styles_after_post_content_alignment', array(
		'default'           => 'center',
		'sanitize_callback' => 'ct_mission_news_sanitize_widget_styles_alignment'
	) );
	// control
	$wp_customize->add_control( 'ct_mission_widget_styles_after_post_content_alignment', array(
		'label'       => __( 'Widget text alignment', 'mission-news' ),
		'section'     => 'ct_mission_news_widget_styles_after_post_content',
		'settings'    => 'ct_mission_widget_styles_after_post_content_alignment',
		'type'        => 'radio',
		'choices'     => array(
			'left'   => __( 'Left', 'mission-news' ),
			'center' => __( 'Center', 'mission-news' ),
			'right'  => __( 'Right', 'mission-news' )
		)
	) );

	//----------------------------------------------------------------------------------
	// Section: Widget Styles - After Page Content
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_news_widget_styles_after_page_content', array(
		'title'    => __( 'After Page Content', 'mission-news' ),
		'panel'    => 'ct_mission_news_widget_styles_panel'
	) );
	// setting
	$wp_customize->add_setting( 'ct_mission_widget_styles_after_page_content_layout', array(
		'default'           => 'row',
		'sanitize_callback' => 'ct_mission_news_sanitize_widget_styles_layout'
	) );
	// control
	$wp_customize->add_control( 'ct_mission_widget_styles_after_page_content_layout', array(
		'label'       => __( 'Display widgets in a row or column?', 'mission-news' ),
		'section'     => 'ct_mission_news_widget_styles_after_page_content',
		'settings'    => 'ct_mission_widget_styles_after_page_content_layout',
		'type'        => 'radio',
		'choices'     => array(
			'row'    => __( 'Row', 'mission-news' ),
			'column' => __( 'Column', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'ct_mission_widget_styles_after_page_content_alignment', array(
		'default'           => 'center',
		'sanitize_callback' => 'ct_mission_news_sanitize_widget_styles_alignment'
	) );
	// control
	$wp_customize->add_control( 'ct_mission_widget_styles_after_page_content_alignment', array(
		'label'       => __( 'Widget text alignment', 'mission-news' ),
		'section'     => 'ct_mission_news_widget_styles_after_page_content',
		'settings'    => 'ct_mission_widget_styles_after_page_content_alignment',
		'type'        => 'radio',
		'choices'     => array(
			'left'   => __( 'Left', 'mission-news' ),
			'center' => __( 'Center', 'mission-news' ),
			'right'  => __( 'Right', 'mission-news' )
		)
	) );

	//----------------------------------------------------------------------------------
	// Section: Widget Styles - Footer
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_news_widget_styles_footer', array(
		'title'    => __( 'Footer', 'mission-news' ),
		'panel'    => 'ct_mission_news_widget_styles_panel'
	) );
	// setting
	$wp_customize->add_setting( 'ct_mission_widget_styles_footer_layout', array(
		'default'           => 'row',
		'sanitize_callback' => 'ct_mission_news_sanitize_widget_styles_layout'
	) );
	// control
	$wp_customize->add_control( 'ct_mission_widget_styles_footer_layout', array(
		'label'       => __( 'Display widgets in a row or column?', 'mission-news' ),
		'section'     => 'ct_mission_news_widget_styles_footer',
		'settings'    => 'ct_mission_widget_styles_footer_layout',
		'type'        => 'radio',
		'choices'     => array(
			'row'    => __( 'Row', 'mission-news' ),
			'column' => __( 'Column', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'ct_mission_widget_styles_footer_alignment', array(
		'default'           => 'center',
		'sanitize_callback' => 'ct_mission_news_sanitize_widget_styles_alignment'
	) );
	// control
	$wp_customize->add_control( 'ct_mission_widget_styles_footer_alignment', array(
		'label'       => __( 'Widget text alignment', 'mission-news' ),
		'section'     => 'ct_mission_news_widget_styles_footer',
		'settings'    => 'ct_mission_widget_styles_footer_alignment',
		'type'        => 'radio',
		'choices'     => array(
			'left'   => __( 'Left', 'mission-news' ),
			'center' => __( 'Center', 'mission-news' ),
			'right'  => __( 'Right', 'mission-news' )
		)
	) );

	//----------------------------------------------------------------------------------
	// Section: Social Media Icons
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_news_social_media_icons', array(
		'title'       => __( 'Social Media Icons', 'mission-news' ),
		'priority'    => 20,
		'description' => __( 'Add the URL for each of your social profiles.', 'mission-news' )
	) );

	// get the social sites array
	$social_sites = ct_mission_news_social_array();

	// set a priority used to order the social sites
	$priority = 5;

	// create a setting and control for each social site
	foreach ( $social_sites as $social_site => $value ) {
		// if email icon
		if ( $social_site == 'email' ) {
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'ct_mission_news_sanitize_email'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'    => __( 'Email Address', 'mission-news' ),
				'section'  => 'ct_mission_news_social_media_icons',
				'priority' => $priority
			) );
		} else {

			$label = ucfirst( $social_site );

			if ( $social_site == 'google-plus' ) {
				$label = __('Google Plus', 'mission-news');
			} elseif ( $social_site == 'rss' ) {
				$label = __('RSS', 'mission-news');
			} elseif ( $social_site == 'soundcloud' ) {
				$label = __('SoundCloud', 'mission-news');;
			} elseif ( $social_site == 'slideshare' ) {
				$label = __('SlideShare', 'mission-news');
			} elseif ( $social_site == 'codepen' ) {
				$label = __('CodePen', 'mission-news');
			} elseif ( $social_site == 'stumbleupon' ) {
				$label = __('StumbleUpon', 'mission-news');
			} elseif ( $social_site == 'deviantart' ) {
				$label = __('DeviantArt', 'mission-news');
			} elseif ( $social_site == 'hacker-news' ) {
				$label = __('Hacker News', 'mission-news');
			} elseif ( $social_site == 'whatsapp' ) {
				$label = __('WhatsApp', 'mission-news');
			} elseif ( $social_site == 'qq' ) {
				$label = __('QQ', 'mission-news');
			} elseif ( $social_site == 'vk' ) {
				$label = __('VK', 'mission-news');
			} elseif ( $social_site == 'wechat' ) {
				$label = __('WeChat', 'mission-news');
			} elseif ( $social_site == 'tencent-weibo' ) {
				$label = __('Tencent Weibo', 'mission-news');
			} elseif ( $social_site == 'paypal' ) {
				$label = __('PayPal', 'mission-news');
			} elseif ( $social_site == 'email-form' ) {
				$label = __('Contact Form', 'mission-news');
			} elseif ( $social_site == 'google-wallet' ) {
				$label = __('Google Wallet', 'mission-news');
			} elseif ( $social_site == 'ok-ru' ) {
				$label = __('OK.ru', 'mission-news');
			}
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'esc_url_raw'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'type'     => 'url',
				'label'    => $label,
				'section'  => 'ct_mission_news_social_media_icons',
				'priority' => $priority
			) );
		}
		// increment the priority for next site
		$priority = $priority + 5;
	}

	//----------------------------------------------------------------------------------
	// Panel: Show/Hide Elements. Section: Header
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_news_show_hide_header', array(
		'title'    => __( 'Header', 'mission-news' ),
		'panel'    => 'ct_mission_news_show_hide_panel',
		'priority' => 1
	) );
	// setting
	$wp_customize->add_setting( 'date', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'date', array(
		'label'    => __( 'Show today\'s date?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_header',
		'settings' => 'date',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'social_icons_header', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'social_icons_header', array(
		'label'    => __( 'Show the social icons?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_header',
		'settings' => 'social_icons_header',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'tagline_header', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'tagline_header', array(
		'label'    => __( 'Show the tagline?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_header',
		'settings' => 'tagline_header',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'search', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'search', array(
		'label'    => __( 'Show the search bar?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_header',
		'settings' => 'search',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	//----------------------------------------------------------------------------------
	// Panel: Show/Hide Elements. Section: Blog & Archives
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_news_show_hide_blog_archives', array(
		'title'    => __( 'Blog & Archives', 'mission-news' ),
		'description' => __( 'These settings apply to the main posts page and all archives.', 'mission-news' ),
		'panel'    => 'ct_mission_news_show_hide_panel',
		'priority' => 2
	) );
	// setting
	$wp_customize->add_setting( 'featured_image_blog_archives', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'featured_image_blog_archives', array(
		'label'    => __( 'Show the Featured Images?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_blog_archives',
		'settings' => 'featured_image_blog_archives',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'post_author_blog_archives', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_author_blog_archives', array(
		'label'    => __( 'Show the post author?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_blog_archives',
		'settings' => 'post_author_blog_archives',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'post_date_blog_archives', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_date_blog_archives', array(
		'label'    => __( 'Show the post date?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_blog_archives',
		'settings' => 'post_date_blog_archives',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	//----------------------------------------------------------------------------------
	// Panel: Show/Hide Elements. Section: Archivess
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_news_show_hide_archives', array(
		'title'    => __( 'Archives', 'mission-news' ),
		'description' => __( 'These settings apply to the category, tag, date, and author archives.', 'mission-news' ),
		'panel'    => 'ct_mission_news_show_hide_panel',
		'priority' => 3
	) );
	// setting
	$wp_customize->add_setting( 'archive_title', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'archive_title', array(
		'label'    => __( 'Show the archive title?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_archives',
		'settings' => 'archive_title',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'archive_description', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'archive_description', array(
		'label'    => __( 'Show the archive description?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_archives',
		'settings' => 'archive_description',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	//----------------------------------------------------------------------------------
	// Panel: Show/Hide Elements. Section: Posts
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_news_show_hide_posts', array(
		'title'    => __( 'Posts', 'mission-news' ),
		'description' => __( 'These settings apply to individual post pages.', 'mission-news' ),
		'panel'    => 'ct_mission_news_show_hide_panel',
		'priority' => 4
	) );
	// setting
	$wp_customize->add_setting( 'featured_image_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'featured_image_posts', array(
		'label'    => __( 'Show the Featured Image?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_posts',
		'settings' => 'featured_image_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'post_author_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_author_posts', array(
		'label'    => __( 'Show the post author?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_posts',
		'settings' => 'post_author_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'post_date_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_date_posts', array(
		'label'    => __( 'Show the post date?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_posts',
		'settings' => 'post_date_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'category_links_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'category_links_posts', array(
		'label'    => __( 'Show the category links?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_posts',
		'settings' => 'category_links_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'tag_links_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'tag_links_posts', array(
		'label'    => __( 'Show the tag links?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_posts',
		'settings' => 'tag_links_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'author_avatar_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'author_avatar_posts', array(
		'label'    => __( 'Show avatar in the author box?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_posts',
		'settings' => 'author_avatar_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'author_box_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'author_box_posts', array(
		'label'    => __( 'Show the author box?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_posts',
		'settings' => 'author_box_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'more_from_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'more_from_posts', array(
		'label'    => __( 'Show the "More from..." section?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_posts',
		'settings' => 'more_from_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	//----------------------------------------------------------------------------------
	// Panel: Show/Hide Elements. Section: Comments
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_news_show_hide_comments', array(
		'title'       => __( 'Comments', 'mission-news' ),
		'description' => __( 'These settings apply to post comments.', 'mission-news' ),
		'panel'       => 'ct_mission_news_show_hide_panel',
		'priority'    => 5
	) );
	// setting
	$wp_customize->add_setting( 'comment_date', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'comment_date', array(
		'label'    => __( 'Show the comment date?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_comments',
		'settings' => 'comment_date',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'author_label', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'author_label', array(
		'label'    => __( 'Show the "Post Author" label?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_comments',
		'settings' => 'author_label',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	//----------------------------------------------------------------------------------
	// Panel: Show/Hide Elements. Section: Footer
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_news_show_hide_footer', array(
		'title'       => __( 'Footer', 'mission-news' ),
		'description' => __( 'These settings apply to the footer.', 'mission-news' ),
		'panel'       => 'ct_mission_news_show_hide_panel',
		'priority'    => 6
	) );
	// setting
	$wp_customize->add_setting( 'social_icons_footer', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'social_icons_footer', array(
		'label'    => __( 'Show the social icons?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_footer',
		'settings' => 'social_icons_footer',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'tagline_footer', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'tagline_footer', array(
		'label'    => __( 'Show the tagline?', 'mission-news' ),
		'section'  => 'ct_mission_news_show_hide_footer',
		'settings' => 'tagline_footer',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );

	//----------------------------------------------------------------------------------
	// Section: Excerpts
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_news_excerpts', array(
		'title'    => __( 'Excerpts', 'mission-news' ),
		'priority' => 50
	) );
	// setting
	$wp_customize->add_setting( 'full_post', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_mission_news_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'full_post', array(
		'label'    => __( 'Show full posts on blog?', 'mission-news' ),
		'section'  => 'ct_mission_news_excerpts',
		'settings' => 'full_post',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'mission-news' ),
			'no'  => __( 'No', 'mission-news' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'excerpt_length', array(
		'default'           => '30',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( 'excerpt_length', array(
		'label'    => __( 'Excerpt word count', 'mission-news' ),
		'section'  => 'ct_mission_news_excerpts',
		'settings' => 'excerpt_length',
		'type'     => 'number'
	) );
}

//----------------------------------------------------------------------------------
// Sanitize email
//----------------------------------------------------------------------------------
function ct_mission_news_sanitize_email( $input ) {
	return sanitize_email( $input );
}

//----------------------------------------------------------------------------------
// Sanitize yes/no settings
//----------------------------------------------------------------------------------
function ct_mission_news_sanitize_yes_no_settings( $input ) {

	$valid = array(
		'yes' => __( 'Yes', 'mission-news' ),
		'no'  => __( 'No', 'mission-news' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

//----------------------------------------------------------------------------------
// Sanitize Skype URI
//----------------------------------------------------------------------------------
function ct_mission_news_sanitize_skype( $input ) {
	return esc_url_raw( $input, array( 'http', 'https', 'skype' ) );
}

//----------------------------------------------------------------------------------
// Sanitize layout
//----------------------------------------------------------------------------------
function ct_mission_news_sanitize_layout( $input ) {
	
	$valid = array(
		'simple'       => __( 'Simple', 'mission-news' ),
		'double'       => __( 'Double', 'mission-news' ),
		'rows'         => __( 'Rows', 'mission-news' ),
		'rows-excerpt' => __( 'Rows with excerpts', 'mission-news' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

//----------------------------------------------------------------------------------
// Sanitize post layout
//----------------------------------------------------------------------------------
function ct_mission_news_sanitize_layout_posts( $input ) {

	$valid = array(
		'double-sidebar'     => __( 'Double sidebar', 'mission-news' ),
		'left-sidebar'       => __( 'Left sidebar', 'mission-news' ),
		'left-sidebar-wide'  => __( 'Left sidebar - wide', 'mission-news' ),
		'right-sidebar'      => __( 'Right sidebar', 'mission-news' ),
		'right-sidebar-wide' => __( 'Right sidebar - wide', 'mission-news' ),
		'no-sidebar'         => __( 'No sidebar', 'mission-news' ),
		'no-sidebar-wide'    => __( 'No sidebar - wide', 'mission-news' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_mission_news_sanitize_widget_styles_layout( $input ) {

	$valid = array(
		'row'    => __( 'Row', 'mission-news' ),
		'column' => __( 'Column', 'mission-news' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_mission_news_sanitize_widget_styles_alignment( $input ) {

	$valid = array(
		'left'   => __( 'Left', 'mission-news' ),
		'center' => __( 'Center', 'mission-news' ),
		'right'  => __( 'Right', 'mission-news' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}