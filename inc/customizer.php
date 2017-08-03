<?php

/* Add customizer panels, sections, settings, and controls */
add_action( 'customize_register', 'ct_mission_add_customizer_content' );

function ct_mission_add_customizer_content( $wp_customize ) {

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
	// Custom control for Mission News Pro advertisement
	//----------------------------------------------------------------------------------
	class ct_mission_pro_ad extends WP_Customize_Control {
		public function render_content() {
			$link = 'https://www.competethemes.com/mission-pro/';
			echo "<a href='" . $link . "' target='_blank'><img src='" . get_template_directory_uri() . "/assets/images/mission-pro.gif' /></a>";
			// Translators: %1$s is the URL of the upgrade. %2$s is the name of the theme (Mission News)
			echo "<p class='bold'>" . sprintf( __('<a target="_blank" href="%1$s">%2$s Pro</a> makes advanced customization simple - and fun too!', 'mission-news'), $link, esc_attr( wp_get_theme( get_template() ) ) ) . "</p>";
			// Translators: %s is the name of the theme (Mission News)
			echo "<p>" . sprintf( esc_html_x('%s Pro adds the following features:', 'Mission News Pro adds the following features:', 'mission-news'), esc_attr( wp_get_theme( get_template() ) ) ) . "</p>";
			echo "<ul>
					<li>" . esc_html__('6 new layouts', 'mission-news') . "</li>
					<li>" . esc_html__('4 post templates', 'mission-news') . "</li>
					<li>" . esc_html__('61 advanced color controls', 'mission-news') . "</li>
					<li>" . esc_html__('+ 5 more features', 'mission-news') . "</li>
				  </ul>";
			// translators: placeholder is "Mission News Pro"
			echo "<p class='button-wrapper'><a target=\"_blank\" class='mission-pro-button' href='" . $link . "'>" . sprintf( esc_html_x('View %s Pro', 'View Mission News Pro', 'mission-news'), esc_attr( wp_get_theme( get_template() ) ) ) . "</a></p>";
		}
	}

	//----------------------------------------------------------------------------------
	// Add panels
	//----------------------------------------------------------------------------------
	if ( method_exists( 'WP_Customize_Manager', 'add_panel' ) ) {

		$wp_customize->add_panel( 'ct_mission_show_hide_panel', array(
			'priority'    => 30,
			'title'       => __( 'Show/Hide Elements', 'mission-news' ),
			'description' => __( 'Choose which elements you want displayed on the site.', 'mission-news' )
		) );
	}
	if ( method_exists( 'WP_Customize_Manager', 'add_panel' ) ) {

		$wp_customize->add_panel( 'ct_mission_layout_panel', array(
			'priority'    => 25,
			'title'       => __( 'Layout', 'mission-news' ),
			'description' => __( 'Change the layout of the main content and posts.', 'mission-news' )
		) );
	}

	//----------------------------------------------------------------------------------
	// Section: Mission News Pro
	//----------------------------------------------------------------------------------
	// don't add if Mission News Pro is active
	if ( !defined( 'MISSION_NEWS_PRO_FILE' ) ) {
		// section
		$wp_customize->add_section( 'ct_mission_pro', array(
			// Translators: %s is the name of the theme (Mission News)
			'title'    => sprintf( __( '%s Pro', 'mission-news' ), esc_attr( wp_get_theme( get_template() ) ) ),
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

	//----------------------------------------------------------------------------------
	// Section: Layout
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_layout', array(
		'title'    => __( 'Blog', 'mission-news' ),
		'panel'    => 'ct_mission_layout_panel',
		'priority' => 1,
	) );
	// setting
	$wp_customize->add_setting( 'layout', array(
		'default'           => 'simple',
		'sanitize_callback' => 'ct_mission_sanitize_layout'
	) );
	// control
	$wp_customize->add_control( 'layout', array(
		'label'    => __( 'Blog layout', 'mission-news' ),
		'section'  => 'ct_mission_layout',
		'settings' => 'layout',
		'type'     => 'radio',
		'choices'  => array(
			'simple'       => __( 'Simple', 'mission-news' ),
			'double'       => __( 'Double', 'mission-news' ),
			'rows'         => __( 'Rows', 'mission-news' ),
			'rows-excerpt' => __( 'Rows with excerpts', 'mission-news' )
		)
	) );
	// section
	$wp_customize->add_section( 'ct_mission_layout_posts', array(
		'title'    => __( 'Posts', 'mission-news' ),
		'panel'    => 'ct_mission_layout_panel',
		'priority' => 2,
	) );
	// setting
	$wp_customize->add_setting( 'layout_posts', array(
		'default'           => 'double-sidebar',
		'sanitize_callback' => 'ct_mission_sanitize_layout_posts'
	) );
	// control
	$wp_customize->add_control( 'layout_posts', array(
		'label'       => __( 'Post layout', 'mission-news' ),
		'description' => __( 'Layouts can be changed for individual posts in the post editor.', 'mission-news' ),
		'section'     => 'ct_mission_layout_posts',
		'settings'    => 'layout_posts',
		'type'        => 'radio',
		'choices'     => array(
			'double-sidebar' => __( 'Double sidebar', 'mission-news' ),
			'left-sidebar'   => __( 'Left sidebar', 'mission-news' ),
			'right-sidebar'  => __( 'Right sidebar', 'mission-news' ),
			'no-sidebar'     => __( 'No sidebar', 'mission-news' )
		)
	) );

	//----------------------------------------------------------------------------------
	// Section: Social Media Icons
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_social_media_icons', array(
		'title'       => __( 'Social Media Icons', 'mission-news' ),
		'priority'    => 20,
		'description' => __( 'Add the URL for each of your social profiles.', 'mission-news' )
	) );

	// get the social sites array
	$social_sites = ct_mission_social_array();

	// set a priority used to order the social sites
	$priority = 5;

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
				'label'    => __( 'Email Address', 'mission-news' ),
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
					// Translators: %s is the URL of a blog post
					'description' => sprintf( __( 'Accepts Skype link protocol (<a href="%s" target="_blank">learn more</a>)', 'mission-news' ), 'https://www.competethemes.com/blog/skype-links-wordpress/' ),
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

	//----------------------------------------------------------------------------------
	// Panel: Show/Hide Elements. Section: Header
	//----------------------------------------------------------------------------------
	$wp_customize->add_section( 'ct_mission_show_hide_header', array(
		'title'    => __( 'Header', 'mission-news' ),
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
		'label'    => __( 'Show today\'s date?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_header',
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
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'social_icons_header', array(
		'label'    => __( 'Show the social icons?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_header',
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
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'tagline_header', array(
		'label'    => __( 'Show the tagline?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_header',
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
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'search', array(
		'label'    => __( 'Show the search bar?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_header',
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
	$wp_customize->add_section( 'ct_mission_show_hide_blog_archives', array(
		'title'    => __( 'Blog & Archives', 'mission-news' ),
		'description' => __( 'These settings apply to the main posts page and all archives.', 'mission-news' ),
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
		'label'    => __( 'Show the Featured Images?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_blog_archives',
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
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_author_blog_archives', array(
		'label'    => __( 'Show the post author?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_blog_archives',
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
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_date_blog_archives', array(
		'label'    => __( 'Show the post date?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_blog_archives',
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
	$wp_customize->add_section( 'ct_mission_show_hide_archives', array(
		'title'    => __( 'Archives', 'mission-news' ),
		'description' => __( 'These settings apply to the category, tag, date, and author archives.', 'mission-news' ),
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
		'label'    => __( 'Show the archive title?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_archives',
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
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'archive_description', array(
		'label'    => __( 'Show the archive description?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_archives',
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
	$wp_customize->add_section( 'ct_mission_show_hide_posts', array(
		'title'    => __( 'Posts', 'mission-news' ),
		'description' => __( 'These settings apply to individual post pages.', 'mission-news' ),
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
		'label'    => __( 'Show the Featured Image?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_posts',
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
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_author_posts', array(
		'label'    => __( 'Show the post author?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_posts',
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
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_date_posts', array(
		'label'    => __( 'Show the post date?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_posts',
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
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'category_links_posts', array(
		'label'    => __( 'Show the category links?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_posts',
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
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'tag_links_posts', array(
		'label'    => __( 'Show the tag links?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_posts',
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
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'author_avatar_posts', array(
		'label'    => __( 'Show avatar in the author box?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_posts',
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
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'author_box_posts', array(
		'label'    => __( 'Show the author box?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_posts',
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
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'more_from_posts', array(
		'label'    => __( 'Show the "More from..." section?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_posts',
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
	$wp_customize->add_section( 'ct_mission_show_hide_comments', array(
		'title'       => __( 'Comments', 'mission-news' ),
		'description' => __( 'These settings apply to post comments.', 'mission-news' ),
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
		'label'    => __( 'Show the comment date?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_comments',
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
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'author_label', array(
		'label'    => __( 'Show the "Post Author" label?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_comments',
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
	$wp_customize->add_section( 'ct_mission_show_hide_footer', array(
		'title'       => __( 'Footer', 'mission-news' ),
		'description' => __( 'These settings apply to the footer.', 'mission-news' ),
		'panel'       => 'ct_mission_show_hide_panel',
		'priority'    => 6
	) );
	// setting
	$wp_customize->add_setting( 'social_icons_footer', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'social_icons_footer', array(
		'label'    => __( 'Show the social icons?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_footer',
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
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'tagline_footer', array(
		'label'    => __( 'Show the tagline?', 'mission-news' ),
		'section'  => 'ct_mission_show_hide_footer',
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
	$wp_customize->add_section( 'ct_mission_excerpts', array(
		'title'    => __( 'Excerpts', 'mission-news' ),
		'priority' => 50
	) );
	// setting
	$wp_customize->add_setting( 'full_post', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_mission_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'full_post', array(
		'label'    => __( 'Show full posts on blog?', 'mission-news' ),
		'section'  => 'ct_mission_excerpts',
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
		'section'  => 'ct_mission_excerpts',
		'settings' => 'excerpt_length',
		'type'     => 'number'
	) );
}

//----------------------------------------------------------------------------------
// Sanitize email
//----------------------------------------------------------------------------------
function ct_mission_sanitize_email( $input ) {
	return sanitize_email( $input );
}

//----------------------------------------------------------------------------------
// Sanitize yes/no settings
//----------------------------------------------------------------------------------
function ct_mission_sanitize_yes_no_settings( $input ) {

	$valid = array(
		'yes' => __( 'Yes', 'mission-news' ),
		'no'  => __( 'No', 'mission-news' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

//----------------------------------------------------------------------------------
// Sanitize Skype URI
//----------------------------------------------------------------------------------
function ct_mission_sanitize_skype( $input ) {
	return esc_url_raw( $input, array( 'http', 'https', 'skype' ) );
}

//----------------------------------------------------------------------------------
// Sanitize layout
//----------------------------------------------------------------------------------
function ct_mission_sanitize_layout( $input ) {
	
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
function ct_mission_sanitize_layout_posts( $input ) {

	$valid = array(
		'double-sidebar' => __( 'Double sidebar', 'mission-news' ),
		'left-sidebar'   => __( 'Left sidebar', 'mission-news' ),
		'right-sidebar'  => __( 'Right sidebar', 'mission-news' ),
		'no-sidebar'     => __( 'No sidebar', 'mission-news' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}