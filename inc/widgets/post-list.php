<?php

class ct_mission_post_list extends WP_Widget {

	function __construct() {

		$widget_options = array(
			'classname'   => 'widget_ct_mission_post_list',
			'description' => __( 'Display a list of posts from any category or tag. Added by the Mission theme.', 'mission' )
		);
		parent::__construct(
			'ct_mission_post_list',
			esc_html__( 'Post List', 'mission' ),
			$widget_options
		);
	}

	public function widget( $args, $instance ) {

		$html = $args['before_widget'];
		if ( $instance['link'] ) {
			$html .= "<a href='" . $instance['link'] . "'>";
		}
		if ( $instance['image'] ) {
			$html .= "<img title='" . $instance['title'] . "' alt='" . $instance['alt-text'] . "' src='" . $instance['image'] . "' />";
		}
		if ( $instance['link'] ) {
			$html .= "</a>";
		}
		$html .= $args['after_widget'];

		echo $html;
	}

	public function form( $instance ) {

		$title        = isset( $instance['title'] ) ? $instance['title'] : '';
		$use_category = isset( $instance['use_category'] ) ? $instance['use_category'] : 1;
		$category     = isset( $instance['category'] ) ? $instance['category'] : 1;
		$use_tag      = isset( $instance['use_tag'] ) ? $instance['use_tag'] : 0;
		$tag          = isset( $instance['tag'] ) ? $instance['tag'] : 1;
		$author       = isset( $instance['author'] ) ? $instance['author'] : 1;
		$date         = isset( $instance['date'] ) ? $instance['date'] : 0;
		$image        = isset( $instance['image'] ) ? $instance['image'] : 0;
		$excerpt        = isset( $instance['excerpt'] ) ? $instance['excerpt'] : 1;
		$excerpt_length        = isset( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 20;
		
		?>
		<div class="mission-post-list-widget">
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'mission' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
				       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
				       value="<?php echo esc_attr( $title ); ?>">
			</p>
			<h4><?php esc_html_e( 'Post Source', 'mission' ); ?></h4>
			<div class="container">
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $use_category, 1 ); ?> id="<?php echo $this->get_field_id( 'use_category' ); ?>" name="<?php echo $this->get_field_name( 'use_category' ); ?>" value="<?php echo $use_category; ?>" />
					<label for="<?php echo $this->get_field_id( 'use_category' ); ?>"><?php _e( 'Use category', 'mission' ); ?></label>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category', 'mission' ); ?></label>
					<?php
					wp_dropdown_categories( array(
						'hide_empty' => 0,
						'selected'  => $category,
						'id' => $this->get_field_id( 'category' ),
						'name' => $this->get_field_name( 'category' )
					) ); ?>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $use_tag, 1 ); ?> id="<?php echo $this->get_field_id( 'use_tag' ); ?>" name="<?php echo $this->get_field_name( 'use_tag' ); ?>" value="<?php echo $use_tag; ?>" />
					<label for="<?php echo $this->get_field_id( 'use_tag' ); ?>"><?php _e( 'Use tag', 'mission' ); ?></label>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'tag' ); ?>"><?php _e( 'Tag', 'mission' ); ?></label>
					<?php wp_dropdown_categories( array(
						'taxonomy' => 'post_tag',
						'hide_empty' => 0,
						'selected'  => $tag,
						'id' => $this->get_field_id( 'tag' ),
						'name' => $this->get_field_name( 'tag' )
					) ); ?>
				</p>
				<p><i><?php _e( 'Only posts with the category AND tag will be used if both selected.', 'mission' ); ?></i></p>
			</div>
			<h4><?php esc_html_e( 'Style', 'mission' ); ?></h4>
			<div class="container">
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $author ); ?> id="<?php echo $this->get_field_id( 'author' ); ?>" name="<?php echo $this->get_field_name( 'author' ); ?>" value="<?php echo $author; ?>" />
					<label for="<?php echo $this->get_field_id( 'author' ); ?>"><?php _e( 'Show author in byline', 'mission' ); ?></label>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $date ); ?> id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" value="<?php echo $date; ?>" />
					<label for="<?php echo $this->get_field_id( 'date' ); ?>"><?php _e( 'Show date in byline', 'mission' ); ?></label>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $image ); ?> id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo $image; ?>" />
					<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Show Featured Images', 'mission' ); ?></label>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $excerpt ); ?> id="<?php echo $this->get_field_id( 'excerpt' ); ?>" name="<?php echo $this->get_field_name( 'excerpt' ); ?>" value="<?php echo $excerpt; ?>" />
					<label for="<?php echo $this->get_field_id( 'excerpt' ); ?>"><?php _e( 'Show excerpt', 'mission' ); ?></label>
				</p>
				<p>
					<input id="<?php echo $this->get_field_id( 'excerpt_length' ); ?>" name="<?php echo $this->get_field_name( 'excerpt_length' ); ?>" type="text" size="2" value="<?php echo esc_attr( $excerpt_length ); ?>">
					<label for="<?php echo $this->get_field_id( 'excerpt_length' ); ?>"><?php _e( 'Number of words in excerpts', 'mission' ); ?></label>
				</p>
			</div>
		</div>
		<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance                   = array();
		$instance['title']          = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['use_category']   = isset( $new_instance['use_category'] ) ? 1 : 0;
		$instance['category']       = isset( $new_instance['category'] ) ? absint( $new_instance['category'] ) : 1;
		$instance['use_tag']        = isset( $new_instance['use_tag'] ) ? 1 : 0;
		$instance['tag']            = isset( $new_instance['tag'] ) ? absint( $new_instance['tag'] ) : 1;
		$instance['author']         = isset( $new_instance['author'] ) ? 1 : 0;
		$instance['date']           = isset( $new_instance['date'] ) ? 1 : 0;
		$instance['image']          = isset( $new_instance['image'] ) ? 1 : 0;
		$instance['excerpt']        = isset( $new_instance['excerpt'] ) ? 1 : 0;
		$instance['excerpt_length'] = isset( $new_instance['excerpt_length'] ) ? absint( $new_instance['excerpt_length'] ) : 20;

		return $instance;
	}
}

function register_ct_mission_post_list_widget() {
	register_widget( 'ct_mission_post_list' );
}
add_action( 'widgets_init', 'register_ct_mission_post_list_widget' );