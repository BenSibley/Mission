<?php

class ct_mission_post_list extends WP_Widget {

	function __construct() {

		$widget_options = array(
			'classname'   => 'widget_ct_mission_post_list',
			'description' => __( 'A more robust recent posts widget. Added by the Mission theme.', 'mission' )
		);
		parent::__construct(
			'ct_mission_post_list',
			esc_html__( 'Recent Posts Extended', 'mission' ),
			$widget_options
		);
	}

	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		echo '<div class="style-' . $instance['style'] . '">';

		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'];
			echo esc_html( $instance['title'] );
			echo $args['after_title'];
		}

		$query_args = array(
			'posts_per_page' => $instance['post_count'],
			'orderby'        => 'date',
			'order'          => 'DESC',
			'post_type'      => 'post',
			'post_status'    => 'publish'
		);
		if ( $instance['use_category'] == 1 && $instance['use_tag'] == 1 && $instance['relationship'] == 'OR' ) {
			$query_args['tax_query'] = array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'category',
					'field' => 'term_id',
					'terms' => $instance['category']
				    ),
			    array(
				    'taxonomy' => 'post_tag',
				    'field' => 'term_id',
				    'terms' => $instance['tag']
			    ),
			);
		} else {
			if ( $instance['use_category'] == 1 ) {
				$query_args['cat'] = $instance['category'];
			}
			if ( $instance['use_tag'] == 1 ) {
				$query_args['tag_id'] = $instance['tag'];
			}
		}

		$the_query = new WP_Query( $query_args );

		if ( $the_query->have_posts() ) {
			echo '<ul>';
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				echo '<li>';
					echo '<div class="top">';
						if ( $instance['image'] == 1 ) {
							ct_mission_featured_image();
						}
						echo '<div class="top-inner">';
							echo '<a href="' . esc_url( get_the_permalink() ) . '" class="title">' . esc_html( get_the_title() ) . '</a>';
							if ( $instance['author'] == 1 || $instance['date'] == 1 ) {
								ct_mission_post_byline( $instance['author'], $instance['date'] );
							}
						echo '</div>';
					echo '</div>';
					echo '<div class="bottom">';
						if ( $instance['excerpt'] == 1 ) {
							echo '<div class="excerpt">';
								echo wpautop( get_the_excerpt() );
							echo '</div>';
						}
						if ( $instance['comments'] == 1 ) {
							get_template_part( 'content/comments-link' );
						}
					echo '</div>';
				echo '</li>';
			}
			echo '</ul>';
			wp_reset_postdata();
		}
		echo '</div>';
		echo $args['after_widget'];
	}

	public function form( $instance ) {

		$title        = isset( $instance['title'] ) ? $instance['title'] : '';
		$use_category = isset( $instance['use_category'] ) ? $instance['use_category'] : 1;
		$category     = isset( $instance['category'] ) ? $instance['category'] : 1;
		$use_tag      = isset( $instance['use_tag'] ) ? $instance['use_tag'] : 0;
		$tag          = isset( $instance['tag'] ) ? $instance['tag'] : 1;
		$relationship = isset( $instance['relationship'] ) ? $instance['relationship'] : 'AND';
		$author       = isset( $instance['author'] ) ? $instance['author'] : 1;
		$date         = isset( $instance['date'] ) ? $instance['date'] : 0;
		$image        = isset( $instance['image'] ) ? $instance['image'] : 0;
		$excerpt      = isset( $instance['excerpt'] ) ? $instance['excerpt'] : 1;
		$comments     = isset( $instance['comments'] ) ? $instance['comments'] : 1;
		$post_count   = isset( $instance['post_count'] ) ? $instance['post_count'] : 5;
		$style        = isset( $instance['style'] ) ? $instance['style'] : 1;
		?>
		<div class="mission-post-list-widget">
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title', 'mission' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<h4><?php esc_html_e( 'Post Source', 'mission' ); ?></h4>
			<div class="container">
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $use_category, 1 ); ?> id="<?php echo $this->get_field_id( 'use_category' ); ?>" name="<?php echo $this->get_field_name( 'use_category' ); ?>" value="<?php echo $use_category; ?>" />
					<label for="<?php echo $this->get_field_id( 'use_category' ); ?>"><?php esc_html_e( 'Category', 'mission' ); ?></label>
				</p>
				<p class="category">
					<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category', 'mission' ); ?></label>
					<?php
					wp_dropdown_categories( array(
						'hide_empty' => 0,
						'selected'   => $category,
						'id'         => $this->get_field_id( 'category' ),
						'name'       => $this->get_field_name( 'category' )
					) ); ?>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $use_tag, 1 ); ?> id="<?php echo $this->get_field_id( 'use_tag' ); ?>" name="<?php echo $this->get_field_name( 'use_tag' ); ?>" value="<?php echo $use_tag; ?>" />
					<label for="<?php echo $this->get_field_id( 'use_tag' ); ?>"><?php esc_html_e( 'Tag', 'mission' ); ?></label>
				</p>
				<p class="tag">
					<label for="<?php echo $this->get_field_id( 'tag' ); ?>"><?php esc_html_e( 'Tag', 'mission' ); ?></label>
					<?php wp_dropdown_categories( array(
						'taxonomy'   => 'post_tag',
						'hide_empty' => 0,
						'selected'   => $tag,
						'id'         => $this->get_field_id( 'tag' ),
						'name'       => $this->get_field_name( 'tag' )
					) ); ?>
				</p>
				<p class="relationship">
					<label for="<?php echo $this->get_field_id( 'relationship' ); ?>"><?php esc_html_e( 'Relationship', 'mission' ); ?></label>
					<select name="<?php echo $this->get_field_name( 'relationship' ); ?>" id="<?php echo $this->get_field_id( 'relationship' ); ?>" class="postform">
						<option value="AND" <?php selected( $relationship, 'AND'); ?>><?php esc_html_e( 'AND', 'mission' ); ?></option>
						<option value="OR" <?php selected( $relationship, 'OR'); ?>><?php esc_html_e( 'OR', 'mission' ); ?></option>
					</select>
				</p>
				<div class="tooltip">
					<a class="tip-icon" href="#">?</a>
					<p class="tip">
						<?php echo esc_html_e( 'Selecting both a category and a tag will require posts to be in both. If you\'d like to get posts from either the category or tag, switch the "Relationship" option to "OR." If you\'d like to use
						the most recent posts from any tag or category, uncheck both "Category" and "Tag."', 'mission' ); ?>
					</p>
				</div>
				
			</div>
			<h4><?php esc_html_e( 'Content', 'mission' ); ?></h4>
			<div class="container">
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $author ); ?> id="<?php echo $this->get_field_id( 'author' ); ?>" name="<?php echo $this->get_field_name( 'author' ); ?>" value="<?php echo $author; ?>" />
					<label for="<?php echo $this->get_field_id( 'author' ); ?>"><?php esc_html_e( 'Show author in byline', 'mission' ); ?></label>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $date ); ?> id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" value="<?php echo $date; ?>" />
					<label for="<?php echo $this->get_field_id( 'date' ); ?>"><?php esc_html_e( 'Show date in byline', 'mission' ); ?></label>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $image ); ?> id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo $image; ?>" />
					<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php esc_html_e( 'Show Featured Images', 'mission' ); ?></label>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $excerpt ); ?> id="<?php echo $this->get_field_id( 'excerpt' ); ?>" name="<?php echo $this->get_field_name( 'excerpt' ); ?>" value="<?php echo $excerpt; ?>" />
					<label for="<?php echo $this->get_field_id( 'excerpt' ); ?>"><?php esc_html_e( 'Show excerpt', 'mission' ); ?></label>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $comments ); ?> id="<?php echo $this->get_field_id( 'comments' ); ?>" name="<?php echo $this->get_field_name( 'comments' ); ?>" value="<?php echo $comments; ?>" />
					<label for="<?php echo $this->get_field_id( 'comments' ); ?>"><?php esc_html_e( 'Show comments link', 'mission' ); ?></label>
				</p>
				<p>
					<input id="<?php echo $this->get_field_id( 'post_count' ); ?>" name="<?php echo $this->get_field_name( 'post_count' ); ?>" type="text" size="2" value="<?php echo esc_attr( $post_count ); ?>">
					<label for="<?php echo $this->get_field_id( 'post_count' ); ?>"><?php esc_html_e( 'Number of posts', 'mission' ); ?></label>
				</p>
			</div>
			<h4><?php esc_html_e( 'Style', 'mission' ); ?></h4>
			<div class="container">
				<p>
					<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php esc_html_e( 'Style', 'mission' ); ?></label>
					<select name="<?php echo $this->get_field_name( 'style' ); ?>" id="<?php echo $this->get_field_id( 'style' ); ?>" class="postform">
						<option value="1" <?php selected( $style, 1); ?>><?php esc_html_e( 'Style 1', 'mission' ); ?></option>
						<option value="2" <?php selected( $style, 2); ?>><?php esc_html_e( 'Style 2', 'mission' ); ?></option>
					</select>
				</p>
			</div>
		</div>
		<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance                 = array();
		$instance['title']        = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['use_category'] = isset( $new_instance['use_category'] ) ? 1 : 0;
		$instance['category']     = isset( $new_instance['category'] ) ? absint( $new_instance['category'] ) : 1;
		$instance['use_tag']      = isset( $new_instance['use_tag'] ) ? 1 : 0;
		$instance['tag']          = isset( $new_instance['tag'] ) ? absint( $new_instance['tag'] ) : 1;
		$instance['author']       = isset( $new_instance['author'] ) ? 1 : 0;
		$instance['date']         = isset( $new_instance['date'] ) ? 1 : 0;
		$instance['image']        = isset( $new_instance['image'] ) ? 1 : 0;
		$instance['excerpt']      = isset( $new_instance['excerpt'] ) ? 1 : 0;
		$instance['comments']     = isset( $new_instance['comments'] ) ? 1 : 0;
		$instance['post_count']   = isset( $new_instance['post_count'] ) ? absint( $new_instance['post_count'] ) : 5;
		$instance['style']        = isset( $new_instance['style'] ) ? absint( $new_instance['style'] ) : 1;
		$instance['relationship'] = isset( $new_instance['relationship'] ) ? strip_tags( $new_instance['relationship'] ) : 'AND';

		return $instance;
	}
}

function register_ct_mission_post_list_widget() {
	register_widget( 'ct_mission_post_list' );
}
add_action( 'widgets_init', 'register_ct_mission_post_list_widget' );