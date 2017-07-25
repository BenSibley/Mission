<?php

/* Add customizer panels, sections, settings, and controls */
add_action( 'customize_register', 'ct_mission_add_customizer_content' );

function ct_mission_add_customizer_content( $wp_customize ) {

	/***** Reorder default sections *****/

	$wp_customize->get_section( 'title_tagline' )->priority = 2;

	// check if exists in case user has no pages
	if ( is_object( $wp_customize->get_section( 'static_front_page' ) ) ) {
		$wp_customize->get_section( 'static_front_page' )->priority = 5;
		$wp_customize->get_section( 'static_front_page' )->title    = __( 'Front Page', 'mission' );
	}

	/***** Add PostMessage Support *****/

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	/***** Custom Controls *****/

	class ct_mission_pro_ad extends WP_Customize_Control {
		public function render_content() {
			$link = 'https://www.competethemes.com/mission-pro/';
			echo "<a href='" . $link . "' target='_blank'><img src='" . get_template_directory_uri() . "/assets/images/mission-pro.gif' /></a>";
			echo "<p class='bold'>" . sprintf( __('<a target="_blank" href="%1$s">%2$s Pro</a> makes advanced customization simple - and fun too!', 'mission'), $link, wp_get_theme( get_template() ) ) . "</p>";
			echo "<p>" . sprintf( esc_html_x('%s Pro adds the following features:', 'Startup Blog Pro adds the following features:', 'mission'), wp_get_theme( get_template() ) ) . "</p>";
			echo "<ul>
					<li>" . esc_html__('6 new layouts', 'mission') . "</li>
					<li>" . esc_html__('4 post templates', 'mission') . "</li>
					<li>" . esc_html__('61 advanced color controls', 'mission') . "</li>
					<li>" . esc_html__('+ 5 more features', 'mission') . "</li>
				  </ul>";
			// translators: placeholder is "Startup Blog"
			echo "<p class='button-wrapper'><a target=\"_blank\" class='mission-pro-button' href='" . $link . "'>" . sprintf( esc_html_x('View %s Pro', 'View Startup Blog Pro', 'mission'), wp_get_theme( get_template() ) ) . "</a></p>";
		}
	}

	/********** Add Panels **********/

	// Add panel for colors
	if ( method_exists( 'WP_Customize_Manager', 'add_panel' ) ) {

		$wp_customize->add_panel( 'ct_mission_show_hide_panel', array(
			'priority'    => 2,
			'title'       => __( 'Show/Hide Elements', ' mission' ),
			'description' => __( 'Choose which elements you want displayed on the site.', 'mission' )
		) );
	}

	/***** Startup Blog Pro Section *****/

	// don't add if Startup Blog Pro is active
	if ( !defined( 'ct_mission_PRO_FILE' ) ) {
		// section
		$wp_customize->add_section( 'ct_mission_pro', array(
			'title'    => sprintf( __( '%s Pro', 'mission' ), wp_get_theme( get_template() ) ),
			'priority' => 1
		) );
		// setting
		$wp_customize->add_setting( 'ct_mission_pro', array(
			'sanitize_callback' => 'absint'
		) );
		// control
		$wp_customize->add_control( new ct_mission_pro_ad(
			$wp_customize, 'ct_mission_pro', array(
				'section'  => 'ct_mission_pro',
				'settings' => 'ct_mission_pro'
			)
		) );
	}

	/***** Slider *****/

	// section
	$wp_customize->add_section( 'ct_mission_slider_settings', array(
		'title'    => __( 'Recent Posts Slider', 'mission' ),
		'priority' => 20
	) );
	// setting
	$wp_customize->add_setting( 'slider_recent_posts', array(
		'default'           => '5',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( 'slider_recent_posts', array(
		'label'    => __( 'Number of posts in slider', 'mission' ),
		'section'  => 'ct_mission_slider_settings',
		'settings' => 'slider_recent_posts',
		'type'     => 'number'
	) );
	// setting
	$wp_customize->add_setting( 'slider_post_category', array(
		'default'           => 'all',
		'sanitize_callback' => 'ct_mission_sanitize_post_categories'
	) );
	$categories_array = array( 'all' => 'All' );
	foreach ( get_categories() as $category ) {
		$categories_array[$category->term_id] = $category->name;
	}
	// control
	$wp_customize->add_control( 'slider_post_category', array(
		'label'    => __( 'Post category', 'mission' ),
		'section'  => 'ct_mission_slider_settings',
		'settings' => 'slider_post_category',
		'type'     => 'select',
		'choices' => $categories_array
	) );
	// setting
	$wp_customize->add_setting( 'slider_display', array(
		'default'           => 'homepage',
		'sanitize_callback' => 'ct_mission_sanitize_slider_display'
	) );
	// control
	$wp_customize->add_control( 'slider_display', array(
		'label'    => __( 'Display slider on:', 'mission' ),
		'section'  => 'ct_mission_slider_settings',
		'settings' => 'slider_display',
		'type'     => 'radio',
		'choices' => array(
			'homepage'  => __( 'Homepage', 'mission' ),
			'blog'      => __( 'Blog', 'mission' ),
			'all-pages' => __( 'All Pages', 'mission' ),
			'no'        => __( 'Do not display', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'slider_arrow_navigation', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'slider_arrow_navigation', array(
		'label'    => __( 'Display arrow navigation?', 'mission' ),
		'section'  => 'ct_mission_slider_settings',
		'settings' => 'slider_arrow_navigation',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'slider_dot_navigation', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'slider_dot_navigation', array(
		'label'    => __( 'Display dot navigation?', 'mission' ),
		'section'  => 'ct_mission_slider_settings',
		'settings' => 'slider_dot_navigation',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'slider_button_text', array(
		'default'           => __( 'Read more', 'mission'),
		'sanitize_callback' => 'ct_mission_sanitize_text'
	) );
	// control
	$wp_customize->add_control( 'slider_button_text', array(
		'label'    => __( 'Button text', 'mission' ),
		'section'  => 'ct_mission_slider_settings',
		'settings' => 'slider_button_text',
		'type'     => 'text'
	) );
	// setting
	$wp_customize->add_setting( 'slider_sticky', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'slider_sticky', array(
		'label'    => __( 'Include "sticky" posts?', 'mission' ),
		'section'  => 'ct_mission_slider_settings',
		'settings' => 'slider_sticky',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );

	/***** Colors *****/

	// section
	$wp_customize->add_section( 'ct_mission_colors', array(
		'title'    => __( 'Colors', 'mission' ),
		'priority' => 20
	) );
	// setting
	$wp_customize->add_setting( 'color_primary', array(
		'default'           => '#20a4e6',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	// control
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'color_primary', array(
			'label'       => __( 'Primary Color', 'mission' ),
			'section'     => 'ct_mission_colors',
			'settings'    => 'color_primary'
		)
	) );
	// setting
	$wp_customize->add_setting( 'color_secondary', array(
		'default'           => '#17e6c3',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	// control
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'color_secondary', array(
			'label'       => __( 'Secondary Color', 'mission' ),
			'section'     => 'ct_mission_colors',
			'settings'    => 'color_secondary'
		)
	) );
	// setting
	$wp_customize->add_setting( 'color_background', array(
		'default'           => '#f0f5f8',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	// control
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'color_background', array(
			'label'       => __( 'Background Color', 'mission' ),
			'section'     => 'ct_mission_colors',
			'settings'    => 'color_background'
		)
	) );

	/***** Layout *****/

	// section
	$wp_customize->add_section( 'ct_mission_layout', array(
		'title'    => __( 'Layout', 'mission' ),
		'priority' => 25,
	) );
	// setting
	$wp_customize->add_setting( 'layout', array(
		'default'           => 'simple',
		'sanitize_callback' => 'ct_mission_sanitize_layout'
	) );
	// control
	$wp_customize->add_control( 'layout', array(
		'label'    => __( 'Main Content Layout', 'mission' ),
		'section'  => 'ct_mission_layout',
		'settings' => 'layout',
		'type'     => 'radio',
		'choices'  => array(
			'simple'       => __( 'Simple', 'mission' ),
			'double'       => __( 'Double', 'mission' ),
			'rows'         => __( 'Rows', 'mission' ),
			'rows-excerpt' => __( 'Rows with excerpts', 'mission' )
		)
	) );

	/***** Social Media Icons *****/

	// get the social sites array
	$social_sites = ct_mission_social_array();

	// set a priority used to order the social sites
	$priority = 5;

	// section
	$wp_customize->add_section( 'ct_mission_social_media_icons', array(
		'title'       => __( 'Social Media Icons', 'mission' ),
		'priority'    => 30,
		'description' => __( 'Add the URL for each of your social profiles.', 'mission' )
	) );

	// create a setting and control for each social site
	foreach ( $social_sites as $social_site => $value ) {
		// if email icon
		if ( $social_site == 'email' ) {
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'ct_mission_sanitize_email'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'    => __( 'Email Address', 'mission' ),
				'section'  => 'ct_mission_social_media_icons',
				'priority' => $priority
			) );
		} else {

			$label = ucfirst( $social_site );

			if ( $social_site == 'google-plus' ) {
				$label = 'Google Plus';
			} elseif ( $social_site == 'rss' ) {
				$label = 'RSS';
			} elseif ( $social_site == 'soundcloud' ) {
				$label = 'SoundCloud';
			} elseif ( $social_site == 'slideshare' ) {
				$label = 'SlideShare';
			} elseif ( $social_site == 'codepen' ) {
				$label = 'CodePen';
			} elseif ( $social_site == 'stumbleupon' ) {
				$label = 'StumbleUpon';
			} elseif ( $social_site == 'deviantart' ) {
				$label = 'DeviantArt';
			} elseif ( $social_site == 'hacker-news' ) {
				$label = 'Hacker News';
			} elseif ( $social_site == 'whatsapp' ) {
				$label = 'WhatsApp';
			} elseif ( $social_site == 'qq' ) {
				$label = 'QQ';
			} elseif ( $social_site == 'vk' ) {
				$label = 'VK';
			} elseif ( $social_site == 'wechat' ) {
				$label = 'WeChat';
			} elseif ( $social_site == 'tencent-weibo' ) {
				$label = 'Tencent Weibo';
			} elseif ( $social_site == 'paypal' ) {
				$label = 'PayPal';
			} elseif ( $social_site == 'email-form' ) {
				$label = 'Contact Form';
			} elseif ( $social_site == 'google-wallet' ) {
				$label = 'Google Wallet';
			}

			if ( $social_site == 'skype' ) {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'ct_mission_sanitize_skype'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'        => 'url',
					'label'       => $label,
					'description' => sprintf( __( 'Accepts Skype link protocol (<a href="%s" target="_blank">learn more</a>)', 'mission' ), 'https://www.competethemes.com/blog/skype-links-wordpress/' ),
					'section'     => 'ct_mission_social_media_icons',
					'priority'    => $priority
				) );
			} else {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'esc_url_raw'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'     => 'url',
					'label'    => $label,
					'section'  => 'ct_mission_social_media_icons',
					'priority' => $priority
				) );
			}
		}
		// increment the priority for next site
		$priority = $priority + 5;
	}

	/***** Show/Hide *****/

	// section - Header
	$wp_customize->add_section( 'ct_mission_show_hide_header', array(
		'title'    => __( 'Header', 'mission' ),
		'panel'    => 'ct_mission_show_hide_panel',
		'priority' => 1
	) );
	// setting
	$wp_customize->add_setting( 'date', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'date', array(
		'label'    => __( 'Show today\'s date?', 'mission' ),
		'section'  => 'ct_mission_show_hide_header',
		'settings' => 'date',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'social_icons_header', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'social_icons_header', array(
		'label'    => __( 'Show the social icons?', 'mission' ),
		'section'  => 'ct_mission_show_hide_header',
		'settings' => 'social_icons_header',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'tagline_header', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'tagline_header', array(
		'label'    => __( 'Show the tagline?', 'mission' ),
		'section'  => 'ct_mission_show_hide_header',
		'settings' => 'tagline_header',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'search', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'search', array(
		'label'    => __( 'Show the search bar?', 'mission' ),
		'section'  => 'ct_mission_show_hide_header',
		'settings' => 'search',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// section - Blog & Archives
	$wp_customize->add_section( 'ct_mission_show_hide_blog_archives', array(
		'title'    => __( 'Blog & Archives', 'mission' ),
		'description' => __( 'These settings apply to the main posts page and all archives.', 'mission' ),
		'panel'    => 'ct_mission_show_hide_panel',
		'priority' => 2
	) );
	// setting
	$wp_customize->add_setting( 'featured_image_blog_archives', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'featured_image_blog_archives', array(
		'label'    => __( 'Show the Featured Images?', 'mission' ),
		'section'  => 'ct_mission_show_hide_blog_archives',
		'settings' => 'featured_image_blog_archives',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'post_author_blog_archives', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_author_blog_archives', array(
		'label'    => __( 'Show the post author?', 'mission' ),
		'section'  => 'ct_mission_show_hide_blog_archives',
		'settings' => 'post_author_blog_archives',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'post_date_blog_archives', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_date_blog_archives', array(
		'label'    => __( 'Show the post date?', 'mission' ),
		'section'  => 'ct_mission_show_hide_blog_archives',
		'settings' => 'post_date_blog_archives',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// section - Archives
	$wp_customize->add_section( 'ct_mission_show_hide_archives', array(
		'title'    => __( 'Archives', 'mission' ),
		'description' => __( 'These settings apply to the category, tag, date, and author archives.', 'mission' ),
		'panel'    => 'ct_mission_show_hide_panel',
		'priority' => 3
	) );
	// setting
	$wp_customize->add_setting( 'archive_title', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'archive_title', array(
		'label'    => __( 'Show the archive title?', 'mission' ),
		'section'  => 'ct_mission_show_hide_archives',
		'settings' => 'archive_title',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'archive_description', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'archive_description', array(
		'label'    => __( 'Show the archive description?', 'mission' ),
		'section'  => 'ct_mission_show_hide_archives',
		'settings' => 'archive_description',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// section - Posts
	$wp_customize->add_section( 'ct_mission_show_hide_posts', array(
		'title'    => __( 'Posts', 'mission' ),
		'description' => __( 'These settings apply to individual post pages.', 'mission' ),
		'panel'    => 'ct_mission_show_hide_panel',
		'priority' => 4
	) );
	// setting
	$wp_customize->add_setting( 'featured_image_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'featured_image_posts', array(
		'label'    => __( 'Show the Featured Image?', 'mission' ),
		'section'  => 'ct_mission_show_hide_posts',
		'settings' => 'featured_image_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'post_author_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_author_posts', array(
		'label'    => __( 'Show the post author?', 'mission' ),
		'section'  => 'ct_mission_show_hide_posts',
		'settings' => 'post_author_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'post_date_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_date_posts', array(
		'label'    => __( 'Show the post date?', 'mission' ),
		'section'  => 'ct_mission_show_hide_posts',
		'settings' => 'post_date_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'category_links_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'category_links_posts', array(
		'label'    => __( 'Show the category links?', 'mission' ),
		'section'  => 'ct_mission_show_hide_posts',
		'settings' => 'category_links_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'tag_links_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'tag_links_posts', array(
		'label'    => __( 'Show the tag links?', 'mission' ),
		'section'  => 'ct_mission_show_hide_posts',
		'settings' => 'tag_links_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'author_avatar_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'author_avatar_posts', array(
		'label'    => __( 'Show avatar in the author box?', 'mission' ),
		'section'  => 'ct_mission_show_hide_posts',
		'settings' => 'author_avatar_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'author_box_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'author_box_posts', array(
		'label'    => __( 'Show the author box?', 'mission' ),
		'section'  => 'ct_mission_show_hide_posts',
		'settings' => 'author_box_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'more_from_posts', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'more_from_posts', array(
		'label'    => __( 'Show the "More from..." section?', 'mission' ),
		'section'  => 'ct_mission_show_hide_posts',
		'settings' => 'more_from_posts',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// section - Comments
	$wp_customize->add_section( 'ct_mission_show_hide_comments', array(
		'title'       => __( 'Comments', 'mission' ),
		'description' => __( 'These settings apply to post comments.', 'mission' ),
		'panel'       => 'ct_mission_show_hide_panel',
		'priority'    => 5
	) );
	// setting
	$wp_customize->add_setting( 'comment_date', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'comment_date', array(
		'label'    => __( 'Show the comment date?', 'mission' ),
		'section'  => 'ct_mission_show_hide_comments',
		'settings' => 'comment_date',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'author_label', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'author_label', array(
		'label'    => __( 'Show the "Post Author" label?', 'mission' ),
		'section'  => 'ct_mission_show_hide_comments',
		'settings' => 'author_label',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );

//	// setting
//	$wp_customize->add_setting( 'post_byline_date', array(
//		'default'           => 'yes',
//		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
//	) );
//	// control
//	$wp_customize->add_control( 'post_byline_date', array(
//		'label'    => __( 'Show date in post byline?', 'mission' ),
//		'section'  => 'ct_mission_show_hide',
//		'settings' => 'post_byline_date',
//		'type'     => 'radio',
//		'choices'  => array(
//			'yes' => __( 'Yes', 'mission' ),
//			'no'  => __( 'No', 'mission' )
//		)
//	) );
//	// setting
//	$wp_customize->add_setting( 'post_byline_author', array(
//		'default'           => 'yes',
//		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
//	) );
//	// control
//	$wp_customize->add_control( 'post_byline_author', array(
//		'label'    => __( 'Show author name in post byline?', 'mission' ),
//		'section'  => 'ct_mission_show_hide',
//		'settings' => 'post_byline_author',
//		'type'     => 'radio',
//		'choices'  => array(
//			'yes' => __( 'Yes', 'mission' ),
//			'no'  => __( 'No', 'mission' )
//		)
//	) );
//	// setting
//	$wp_customize->add_setting( 'author_avatars', array(
//		'default'           => 'yes',
//		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
//	) );
//	// control
//	$wp_customize->add_control( 'author_avatars', array(
//		'label'    => __( 'Show post author avatars?', 'mission' ),
//		'section'  => 'ct_mission_show_hide',
//		'settings' => 'author_avatars',
//		'type'     => 'radio',
//		'choices'  => array(
//			'yes' => __( 'Yes', 'mission' ),
//			'no'  => __( 'No', 'mission' )
//		)
//	) );
//	// setting
//	$wp_customize->add_setting( 'author_box', array(
//		'default'           => 'yes',
//		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
//	) );
//	// control
//	$wp_customize->add_control( 'author_box', array(
//		'label'    => __( 'Show author box after posts?', 'mission' ),
//		'section'  => 'ct_mission_show_hide',
//		'settings' => 'author_box',
//		'type'     => 'radio',
//		'choices'  => array(
//			'yes' => __( 'Yes', 'mission' ),
//			'no'  => __( 'No', 'mission' )
//		)
//	) );
//	// setting
//	$wp_customize->add_setting( 'post_categories', array(
//		'default'           => 'yes',
//		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
//	) );
//	// control
//	$wp_customize->add_control( 'post_categories', array(
//		'label'    => __( 'Show categories after the post?', 'mission' ),
//		'section'  => 'ct_mission_show_hide',
//		'settings' => 'post_categories',
//		'type'     => 'radio',
//		'choices'  => array(
//			'yes' => __( 'Yes', 'mission' ),
//			'no'  => __( 'No', 'mission' )
//		)
//	) );
//	// setting
//	$wp_customize->add_setting( 'post_tags', array(
//		'default'           => 'yes',
//		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
//	) );
//	// control
//	$wp_customize->add_control( 'post_tags', array(
//		'label'    => __( 'Show tags after the post?', 'mission' ),
//		'section'  => 'ct_mission_show_hide',
//		'settings' => 'post_tags',
//		'type'     => 'radio',
//		'choices'  => array(
//			'yes' => __( 'Yes', 'mission' ),
//			'no'  => __( 'No', 'mission' )
//		)
//	) );
//	// setting
//	$wp_customize->add_setting( 'sidebar', array(
//		'default'           => 'after',
//		'sanitize_callback' => 'ct_mission_sanitize_sidebar_settings'
//	) );
//	// control
//	$wp_customize->add_control( 'sidebar', array(
//		'label'    => __( 'Show sidebar on mobile devices?', 'mission' ),
//		'section'  => 'ct_mission_show_hide',
//		'settings' => 'sidebar',
//		'type'     => 'radio',
//		'choices'  => array(
//			'after'  => __( 'Yes, after main content', 'mission' ),
//			'before' => __( 'Yes, before main content', 'mission' ),
//			'no'     => __( 'No', 'mission' )
//		)
//	) );

	/***** Blog *****/

	// section
	$wp_customize->add_section( 'ct_mission_blog', array(
		'title'    => __( 'Blog', 'mission' ),
		'priority' => 50
	) );
	// setting
	$wp_customize->add_setting( 'full_post', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'full_post', array(
		'label'    => __( 'Show full posts on blog?', 'mission' ),
		'section'  => 'ct_mission_blog',
		'settings' => 'full_post',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'mission' ),
			'no'  => __( 'No', 'mission' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'excerpt_length', array(
		'default'           => '30',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( 'excerpt_length', array(
		'label'    => __( 'Excerpt word count', 'mission' ),
		'section'  => 'ct_mission_blog',
		'settings' => 'excerpt_length',
		'type'     => 'number'
	) );
}

/***** Custom Sanitization Functions *****/

function ct_mission_sanitize_email( $input ) {
	return sanitize_email( $input );
}

// sanitize yes/no settings
function ct_mission_sanitize_yes_no_settings( $input ) {

	$valid = array(
		'yes' => __( 'Yes', 'mission' ),
		'no'  => __( 'No', 'mission' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_mission_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function ct_mission_sanitize_skype( $input ) {
	return esc_url_raw( $input, array( 'http', 'https', 'skype' ) );
}

function ct_mission_sanitize_tagline_settings( $input ) {

	$valid = array(
		'header-footer' => __( 'Yes, in the header & footer', 'mission' ),
		'header'        => __( 'Yes, in the header', 'mission' ),
		'footer'        => __( 'Yes, in the footer', 'mission' ),
		'no'            => __( 'No', 'mission' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_mission_sanitize_sidebar_settings( $input ) {

	$valid = array(
		'after'  => __( 'Yes, after main content', 'mission' ),
		'before' => __( 'Yes, before main content', 'mission' ),
		'no'     => __( 'No', 'mission' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_mission_sanitize_slider_display( $input ) {

	$valid = array(
		'homepage'  => __( 'Homepage', 'mission' ),
		'blog'      => __( 'Blog', 'mission' ),
		'all-pages' => __( 'All Pages', 'mission' ),
		'no'        => __( 'Do not display', 'mission' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_mission_sanitize_post_categories( $input ) {

	$categories_array = array( 'all' => 'All' );
	foreach ( get_categories() as $category ) {
		$categories_array[$category->term_id] = $category->name;
	}

	return array_key_exists( $input, $categories_array ) ? $input : '';
}

function ct_mission_sanitize_layout( $input ) {

	/*
	 * Also allow layouts only included in the premium plugin.
	 * Needs to be done this way b/c sanitize_callback cannot by updated
	 * via get_setting()
	 */
	$valid = array(
		'simple'       => __( 'Simple', 'mission' ),
		'double'       => __( 'Double', 'mission' ),
		'rows'         => __( 'Rows', 'mission' ),
		'rows-excerpt' => __( 'Rows with excerpts', 'mission' ),
		'narrow'       => __( 'No sidebar - Narrow', 'mission' ),
		'wide'         => __( 'No sidebar - Wide', 'mission' ),
		'two-right'    => __( 'Two column - Right sidebar', 'mission' ),
		'two-left'     => __( 'Two column - Left sidebar', 'mission' ),
		'two-narrow'   => __( 'Two column - No Sidebar - Narrow', 'mission' ),
		'two-wide'     => __( 'Two column - No Sidebar - Wide', 'mission' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}
