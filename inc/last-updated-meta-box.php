<?php
defined( 'ABSPATH' ) OR exit;

function ct_mission_news_last_updated_meta_box() {

	$screens = array( 'post' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'ct_mission_news_last_updated',
			esc_html__( 'Last Updated Date', 'mission-news' ),
			'ct_mission_news_last_updated_callback',
			$screen,
			'side'
		);
	}
}
add_action( 'add_meta_boxes', 'ct_mission_news_last_updated_meta_box' );

function ct_mission_news_last_updated_callback( $post ) {

  wp_nonce_field( 'ct_mission_news_last_updated', 'ct_mission_news_last_updated_nonce' );
  $display = get_post_meta( $post->ID, 'ct_mission_news_last_updated', true );

  ?>
	<p>
		<select name="mission-news-last-updated" id="mission-news-last-updated" class="widefat">
			<option value="default"><?php esc_html_e( 'Use Customizer setting', 'mission-news' ); ?></option>
			<option value="yes" <?php if ( $display == 'yes' ) {
				echo 'selected';
			} ?>><?php esc_html_e( 'Show the date', 'mission-news' ); ?>
			</option>
			<option value="no" <?php if ( $display == 'no' ) {
				echo 'selected';
			} ?>><?php esc_html_e( "Don't show the date", 'mission-news' ); ?>
			</option>
		</select>
	</p> <?php
}
function ct_mission_news_last_updated_save_data( $post_id ) {

	global $post;

	if ( ! isset( $_POST['ct_mission_news_last_updated_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['ct_mission_news_last_updated_nonce'], 'ct_mission_news_last_updated' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	/* it's safe to save the data now. */

	if ( isset( $_POST['mission-news-last-updated'] ) ) {

    $display = $_POST['mission-news-last-updated'];
    $accepted_values = array('default', 'yes', 'no');

		if ( in_array( $display, $accepted_values ) ) {
			update_post_meta( $post_id, 'ct_mission_news_last_updated', $display );
		}
	}
}
add_action( 'pre_post_update', 'ct_mission_news_last_updated_save_data' );