<?php

//----------------------------------------------------------------------------------
// Add menu item for Startup Blog options page
// TRT Note: wp_get_theme( get_template() ) is used extensively to remove "Mission News" from the translation.
// This makes a lot more strings identical across my themes allowing for greater reuse of translations
//----------------------------------------------------------------------------------
if ( ! function_exists( 'ct_mission_news_register_theme_page' ) ) {
	function ct_mission_news_register_theme_page() {
		// Translators: %s is the name of the theme (Mission News)
		add_theme_page( sprintf( esc_html__( '%s Dashboard', 'mission-news' ), esc_attr( wp_get_theme( get_template() ) ) ), esc_attr( wp_get_theme( get_template() ) ), 'edit_theme_options', 'mission-options', 'ct_mission_news_options_content', 'ct_mission_news_options_content' );
	}
}
add_action( 'admin_menu', 'ct_mission_news_register_theme_page' );

//----------------------------------------------------------------------------------
// Output the markup for the theme options page
//----------------------------------------------------------------------------------
if ( ! function_exists( 'ct_mission_news_options_content' ) ) {
	function ct_mission_news_options_content() {

		$support_url    = 'https://www.competethemes.com/documentation/mission-support-center/';
		$customizer_url = add_query_arg(
			array(
				'url'    => home_url(),
				'return' => add_query_arg( 'page', 'mission-options', admin_url( 'themes.php' ) )
			),
			admin_url( 'customize.php' )
		);
		?>
		<div id="mission-dashboard-wrap" class="wrap">
			<h2><?php
				// Translators: %s is the name of the theme (Mission News)
				printf( esc_html__( '%s Dashboard', 'mission-news' ), esc_attr( wp_get_theme( get_template() ) ) );
				?></h2>
			<?php do_action( 'ct_mission_news_theme_options_before' ); ?>
			<div class="content-boxes">
				<div class="content content-support">
					<h3><?php esc_html_e( 'Get Started', 'mission-news' ); ?></h3>
					<p><?php
						// Translators: %1$s and %2$s are the name of the theme (Mission News)
						printf( esc_html__( 'Not sure where to start? The %1$s Getting Started Guide will take you step-by-step through every feature in %1$s.', 'mission-news' ), esc_attr( wp_get_theme( get_template() ) ) );
						?></p>
					<p>
						<a target="_blank" class="button-primary"
						   href="https://www.competethemes.com/help/getting-started-mission-news/"><?php esc_html_e( 'View Guide', 'mission-news' ); ?></a>
					</p>
				</div>
				<?php if ( !function_exists( 'ct_mission_news_pro_activation_notice' ) ) : ?>
					<div class="content content-premium-upgrade">
						<h3><?php esc_html_e( 'Mission News Pro', 'mission-news' ); ?></h3>
						<p><?php printf( __( 'Download the %s Pro plugin and unlock the breaking news ticker, "Featured Videos", responsive slider, and more', 'mission-news' ), wp_get_theme( get_template() ) ); ?>...</p>
						<p>
							<a target="_blank" class="button-primary"
								href="https://www.competethemes.com/mission-news-pro/"><?php _e( 'See Full Feature List', 'mission-news' ); ?></a>
						</p>
					</div>
				<?php endif; ?>
				<div class="content content-review">
					<h3><?php esc_html_e( 'Leave a Review', 'mission-news' ); ?></h3>
					<p><?php
						// Translators: %s is the name of the theme (Mission News)
						printf( esc_html__( 'Help others find %s by leaving a review on wordpress.org.', 'mission-news' ), esc_attr( wp_get_theme( get_template() ) ) );
						?></p>
					<a target="_blank" class="button-primary"
					   href="https://wordpress.org/support/theme/mission-news/reviews/"><?php esc_html_e( 'Leave a Review', 'mission-news' ); ?></a>
				</div>
				<div class="content content-delete-settings">
					<h3><?php esc_html_e( 'Reset Customizer Settings', 'mission-news' ); ?></h3>
					<p><?php
						// Translators:  %1$s is the URL of the Customizer. %2$s is the name of the theme (Mission News)
						printf( __( '<strong>Warning:</strong> Clicking this button will erase the %2$s theme\'s current settings in the <a href="%1$s">Customizer</a>.', 'mission-news' ), esc_url( $customizer_url ), esc_attr( wp_get_theme( get_template() ) ) );
						?></p>
					<form method="post">
						<input type="hidden" name="ct_mission_news_reset_customizer"
						       value="ct_mission_news_reset_customizer_settings"/>
						<p>
							<?php wp_nonce_field( 'ct_mission_news_reset_customizer_nonce', 'ct_mission_news_reset_customizer_nonce' ); ?>
							<?php submit_button( esc_html__( 'Reset Customizer Settings', 'mission-news' ), 'delete', 'delete', false ); ?>
						</p>
					</form>
				</div>
			</div>
			<?php do_action( 'ct_mission_news_theme_options_after' ); ?>
		</div>
	<?php }
}