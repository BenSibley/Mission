<?php

//----------------------------------------------------------------------------------
// Setup array with all social accounts available for icons in the Customizer
//----------------------------------------------------------------------------------
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

//----------------------------------------------------------------------------------
// Output social icons based on user's Customizer settings
//----------------------------------------------------------------------------------
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