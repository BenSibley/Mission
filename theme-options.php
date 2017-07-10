<?php

function ct_ct_theme_name_register_theme_page() {
	add_theme_page( sprintf( esc_html__( '%s Dashboard', 'ct-theme-name' ), wp_get_theme( get_template() ) ), wp_get_theme( get_template() ), 'edit_theme_options', 'ct-theme-name-options', 'ct_ct_theme_name_options_content', 'ct_ct_theme_name_options_content' );
}
add_action( 'admin_menu', 'ct_ct_theme_name_register_theme_page' );

function ct_ct_theme_name_options_content() {

	$customizer_url = add_query_arg(
		array(
			'url'    => get_home_url(),
			'return' => add_query_arg( 'page', 'ct-theme-name-options', admin_url( 'themes.php' ) )
		),
		admin_url( 'customize.php' )
	);
	$support_url = 'https://www.competethemes.com/documentation/ct-theme-name-support-center/';
	?>
	<div id="ct-theme-name-dashboard-wrap" class="wrap">
		<h2><?php printf( esc_html__( '%s Dashboard', 'ct-theme-name' ), wp_get_theme( get_template() ) ); ?></h2>
		<?php do_action( 'ct_ct_theme_name_theme_options_before' ); ?>
		<div class="content-boxes">
			<div class="content content-support">
				<h3><?php esc_html_e( 'Get Started', 'ct-theme-name' ); ?></h3>
				<p><?php printf( esc_html__( 'Not sure where to start? The %1$s Support Center is filled with tutorials that will take you step-by-step through every feature in %1$s.', 'ct-theme-name' ), wp_get_theme( get_template() ) ); ?></p>
				<p>
					<a target="_blank" class="button-primary"
					   href="https://www.competethemes.com/documentation/ct-theme-name-support-center/"><?php esc_html_e( 'Visit Support Center', 'ct-theme-name' ); ?></a>
				</p>
			</div>
			<?php if ( !function_exists( 'ct_ct_theme_name_pro_init' ) ) : ?>
				<div class="content content-premium-upgrade">
					<h3><?php printf( esc_html__( 'Startup Blog Pro', 'ct-theme-name' ), wp_get_theme( get_template() ) ); ?></h3>
					<p><?php printf( esc_html__( 'Download the %s Pro plugin and unlock six new layouts, four post templates, advanced color controls, and more.', 'ct-theme-name' ), wp_get_theme( get_template() ) ); ?></p>
					<p>
						<a target="_blank" class="button-primary"
						   href="https://www.competethemes.com/ct-theme-name-pro/"><?php esc_html_e( 'See Full Feature List', 'ct-theme-name' ); ?></a>
					</p>
				</div>
			<?php endif; ?>
			<div class="content content-review">
				<h3><?php esc_html_e( 'Leave a Review', 'ct-theme-name' ); ?></h3>
				<p><?php printf( esc_html__( 'Help others find %s by leaving a review on wordpress.org.', 'ct-theme-name' ), wp_get_theme( get_template() ) ); ?></p>
				<a target="_blank" class="button-primary" href="https://wordpress.org/support/theme/ct-theme-name/reviews/"><?php esc_html_e( 'Leave a Review', 'ct-theme-name' ); ?></a>
			</div>
			<div class="content content-delete-settings">
				<h3><?php esc_html_e( 'Reset Customizer Settings', 'ct-theme-name' ); ?></h3>
				<p>
					<?php printf( __( '<strong>Warning:</strong> Clicking this button will erase the %2$s theme\'s current settings in the <a href="%1$s">Customizer</a>.', 'ct-theme-name' ), esc_url( $customizer_url ), wp_get_theme( get_template() ) ); ?>
				</p>
				<form method="post">
					<input type="hidden" name="ct_theme_name_reset_customizer" value="ct_theme_name_reset_customizer_settings"/>
					<p>
						<?php wp_nonce_field( 'ct_theme_name_reset_customizer_nonce', 'ct_theme_name_reset_customizer_nonce' ); ?>
						<?php submit_button( esc_html__( 'Reset Customizer Settings', 'ct-theme-name' ), 'delete', 'delete', false ); ?>
					</p>
				</form>
			</div>
		</div>
		<?php do_action( 'ct_ct_theme_name_theme_options_after' ); ?>
	</div>
<?php }