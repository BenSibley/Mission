<?php

function ct_mission_register_theme_page() {
	// Translators: %s is the name of the theme (Mission)
	add_theme_page( sprintf( esc_html__( '%s Dashboard', 'mission' ), wp_get_theme( get_template() ) ), sprintf( esc_html__( '%s Dashboard', 'mission' ), wp_get_theme( get_template() ) ), 'edit_theme_options', 'mission-options', 'ct_mission_options_content', 'ct_mission_options_content' );
}
add_action( 'admin_menu', 'ct_mission_register_theme_page' );

function ct_mission_options_content() {

	$customizer_url = add_query_arg(
		array(
			'url'    => get_home_url(),
			'return' => add_query_arg( 'page', 'mission-options', admin_url( 'themes.php' ) )
		),
		admin_url( 'customize.php' )
	);
	$support_url = 'https://www.competethemes.com/documentation/mission-support-center/';
	?>
	<div id="mission-dashboard-wrap" class="wrap">
		<h2><?php
			// Translators: %s is the name of the theme (Mission)
			printf( esc_html__( '%s Dashboard', 'mission' ), wp_get_theme( get_template() ) );
		?></h2>
		<?php do_action( 'ct_mission_theme_options_before' ); ?>
		<div class="content-boxes">
			<div class="content content-support">
				<h3><?php esc_html_e( 'Get Started', 'mission' ); ?></h3>
				<p><?php
					// Translators: %1$s and %2$s are the name of the theme (Mission)
					printf( esc_html__( 'Not sure where to start? The %1$s Support Center is filled with tutorials that will take you step-by-step through every feature in %1$s.', 'mission' ), wp_get_theme( get_template() ) );
				?></p>
				<p>
					<a target="_blank" class="button-primary"
					   href="https://www.competethemes.com/documentation/mission-support-center/"><?php esc_html_e( 'Visit Support Center', 'mission' ); ?></a>
				</p>
			</div>
			<?php if ( !function_exists( 'ct_mission_pro_init' ) ) : ?>
				<div class="content content-premium-upgrade">
					<h3><?php printf( esc_html__( 'Mission Pro', 'mission' ), wp_get_theme( get_template() ) ); ?></h3>
					<p><?php
						// Translators: %s is the name of the theme (Mission)
						printf( esc_html__( 'Download the %s Pro plugin and unlock six new layouts, four post templates, advanced color controls, and more.', 'mission' ), wp_get_theme( get_template() ) );
					?></p>
					<p>
						<a target="_blank" class="button-primary"
						   href="https://www.competethemes.com/mission-pro/"><?php esc_html_e( 'See Full Feature List', 'mission' ); ?></a>
					</p>
				</div>
			<?php endif; ?>
			<div class="content content-review">
				<h3><?php esc_html_e( 'Leave a Review', 'mission' ); ?></h3>
				<p><?php
					// Translators: %s is the name of the theme (Mission)
					printf( esc_html__( 'Help others find %s by leaving a review on wordpress.org.', 'mission' ), wp_get_theme( get_template() ) );
				?></p>
				<a target="_blank" class="button-primary" href="https://wordpress.org/support/theme/mission/reviews/"><?php esc_html_e( 'Leave a Review', 'mission' ); ?></a>
			</div>
			<div class="content content-delete-settings">
				<h3><?php esc_html_e( 'Reset Customizer Settings', 'mission' ); ?></h3>
				<p><?php
					// Translators:  %1$s is the URL of the Customizer. %2$s is the name of the theme (Mission)
					printf( __( '<strong>Warning:</strong> Clicking this button will erase the %2$s theme\'s current settings in the <a href="%1$s">Customizer</a>.', 'mission' ), esc_url( $customizer_url ), wp_get_theme( get_template() ) );
				?></p>
				<form method="post">
					<input type="hidden" name="ct_mission_reset_customizer" value="ct_mission_reset_customizer_settings"/>
					<p>
						<?php wp_nonce_field( 'ct_mission_reset_customizer_nonce', 'ct_mission_reset_customizer_nonce' ); ?>
						<?php submit_button( esc_html__( 'Reset Customizer Settings', 'mission' ), 'delete', 'delete', false ); ?>
					</p>
				</form>
			</div>
		</div>
		<?php do_action( 'ct_mission_theme_options_after' ); ?>
	</div>
<?php }