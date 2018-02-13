<?php

//----------------------------------------------------------------------------------
// Add meta box that lets users choose where to display individual Featured Images
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_add_featured_image_display_meta_box' ) ) ) {
	function ct_mission_news_add_featured_image_display_meta_box() {

		$screens = array( 'post' );

		foreach ( $screens as $screen ) {

			add_meta_box(
				'ct_mission_news_featured_image_display',
				esc_html__( 'Featured Image Display', 'mission-news' ),
				'ct_mission_news_featured_image_display_callback',
				$screen,
				'side'
			);
		}
	}
}
add_action( 'add_meta_boxes', 'ct_mission_news_add_featured_image_display_meta_box' );

//----------------------------------------------------------------------------------
// Output the <select> element for users to select a layout
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_featured_image_display_callback' ) ) ) {
	function ct_mission_news_featured_image_display_callback( $post ) {

		wp_nonce_field( 'ct_mission_news_featured_image_display', 'ct_mission_news_featured_image_display_nonce' );

		$display = get_post_meta( $post->ID, 'ct_mission_news_featured_image_display', true );
		?>
		<p>
			<select name="mission-news-featured-image-display" id="mission-news-featured-image-display" class="widefat">
				<option value="default"><?php esc_html_e( 'Use display set in Customizer', 'mission-news' ); ?></option>
				<option value="post-blog" <?php selected($display == 'post-blog'); ?>>
					<?php esc_html_e( 'Post & blog', 'mission-news' ); ?>
				</option>
				<option value="post" <?php selected($display == 'post'); ?>>
					<?php esc_html_e( 'Post only', 'mission-news' ); ?>
				</option>
				<option value="blog" <?php selected($display == 'blog'); ?>>
					<?php esc_html_e( 'Blog only', 'mission-news' ); ?>
				</option>
			</select>
		</p> <?php
	}
}

//----------------------------------------------------------------------------------
// Save the meta box setting
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_featured_image_display_save_data' ) ) ) {
	function ct_mission_news_featured_image_display_save_data( $post_id ) {

		global $post;

		if ( ! isset( $_POST['ct_mission_news_featured_image_display_nonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( wp_unslash( $_POST['ct_mission_news_featured_image_display_nonce'] ), 'ct_mission_news_featured_image_display' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['mission-news-featured-image-display'] ) ) {

			$layout            = wp_unslash( $_POST['mission-news-featured-image-display'] );
			$acceptable_values = array( 
				'default', 
				'post-blog', 
				'post', 
				'blog'
			);

			if ( in_array( $layout, $acceptable_values ) ) {
				update_post_meta( $post_id, 'ct_mission_news_featured_image_display', $layout );
			}
		}
	}
}
add_action( 'pre_post_update', 'ct_mission_news_featured_image_display_save_data' );