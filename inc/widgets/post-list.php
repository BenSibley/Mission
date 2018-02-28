<?php

//----------------------------------------------------------------------------------
// Create post list widget
//----------------------------------------------------------------------------------
class ct_mission_news_post_list extends WP_Widget {

	//----------------------------------------------------------------------------------
	// Initialize widget
	//----------------------------------------------------------------------------------
	function __construct() {

		$widget_options = array(
			'classname'   => 'widget_ct_mission_news_post_list',
			'description' => esc_html__( 'A more robust recent posts widget. Added by the Mission News theme.', 'mission-news' )
		);
		parent::__construct(
			'ct_mission_news_post_list',
			esc_html__( 'Recent Posts Extended', 'mission-news' ),
			$widget_options
		);
	}

	//----------------------------------------------------------------------------------
	// Prepare default values
	//----------------------------------------------------------------------------------
	function defaults($instance) {
		$defaults = array(
		'title' 			 		=> isset( $instance['title'] ) ? sanitize_text_field($instance['title']) : '',
		'use_category' 		=> isset( $instance['use_category'] ) ? $instance['use_category'] : 'yes',
		'category'     		=> isset( $instance['category'] ) ? absint($instance['category']) : 1,
		'use_tag'      		=> isset( $instance['use_tag'] ) ? $instance['use_tag'] : 'no',
		'tag'          		=> isset( $instance['tag'] ) ? absint($instance['tag']) : 1,
		'relationship' 		=> isset( $instance['relationship'] ) ? sanitize_text_field($instance['relationship']) : 'AND',
		'author'       		=> isset( $instance['author'] ) ? $instance['author'] : 'yes',
		'date'        	 	=> isset( $instance['date'] ) ? $instance['date'] : 'no',
		'image'        		=> isset( $instance['image'] ) ? $instance['image'] : 'no',
		'excerpt'      		=> isset( $instance['excerpt'] ) ? $instance['excerpt'] : 'yes',
		'excerpt_length' 	=> isset( $instance['excerpt_length'] ) ? absint($instance['excerpt_length']) : 25,
		'comments'     		=> isset( $instance['comments'] ) ? $instance['comments'] : 'yes',
		'post_category'   => isset( $instance['post_category'] ) ? $instance['post_category'] : 'no',
		'exclude_current' => isset( $instance['exclude_current'] ) ? $instance['exclude_current'] : 'no',
		'post_count'   		=> isset( $instance['post_count'] ) ? absint($instance['post_count']) : 5,
		'style'        		=> isset( $instance['style'] ) ? absint($instance['style']) : 1,
		);
		return $defaults;
	}

	//----------------------------------------------------------------------------------
	// Output the widget's contents on the front-end
	//----------------------------------------------------------------------------------
	public function widget( $args, $instance ) {

		// Prepare defaults and override with saved values
		$instance = $this->defaults($instance);
		
		/***** Prepare the query to get posts *****/
		$query_args = array(
			'posts_per_page' => $instance['post_count'],
			'orderby'        => 'date',
			'order'          => 'DESC',
			'post_type'      => 'post',
			'post_status'    => 'publish'
		);
		// If using posts in either a category or a tag
		if ( $instance['use_category'] == 'yes' && $instance['use_tag'] == 'yes' && $instance['relationship'] == 'OR' ) {
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
			// add category as post requirement
			if ( $instance['use_category'] == 'yes' ) {
				$query_args['cat'] = $instance['category'];
			}
			// add tag as post requirement
			if ( $instance['use_tag'] == 'yes' ) {
				$query_args['tag_id'] = $instance['tag'];
			}
		}
		// exclude current post from query
		if ( $instance['exclude_current'] == 'yes' ) {
			global $post;
			$query_args['post__not_in'] = array($post->ID);
		}

		// create the query
		$the_query = new WP_Query( $query_args );

		/***** Output the widget's contents *****/

		echo $args['before_widget'];
		echo '<div class="style-' . esc_attr( $instance['style'] ) . '">';
		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'];
			echo esc_html( $instance['title'] );
			echo $args['after_title'];
		}
		if ( $the_query->have_posts() ) {
			echo '<ul>';
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$classes = 'post-item';
				if ( $instance['image'] == 'yes' ) {
					$classes .= ' has-image';
				}
				echo '<li class="'. esc_attr( $classes ) .'">';
					echo '<div class="top">';
						if ( $instance['image'] == 'yes' ) {
							echo '<div class="featured-image"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . get_the_post_thumbnail( get_the_ID(), 'medium' ) . '</a></div>';
						}
						echo '<div class="top-inner">';
							echo '<a href="' . esc_url( get_the_permalink() ) . '" class="title">' . esc_html( get_the_title() ) . '</a>';
							if ( $instance['author'] == 'yes' || $instance['date'] == 'yes' ) {
								ct_mission_news_post_byline( $instance['author'], $instance['date'] );
							}
							if ( $instance['post_category'] == 'yes' ) {
								the_category();
							}
						echo '</div>';
					echo '</div>';
					if ( $instance['excerpt'] == 'yes' || $instance['comments'] == 'yes' ) {
						echo '<div class="bottom">';
						if ( $instance['excerpt'] == 'yes' ) {
							echo '<div class="excerpt">';
							if ( has_excerpt() ) {
								echo get_the_excerpt();
							} else {
								echo wp_kses_post(strip_shortcodes(wp_trim_words(get_the_content(),$instance['excerpt_length'])));
							}
							echo '</div>';
						}
						if ( $instance['comments'] == 'yes' ) {
							get_template_part( 'content/comments-link' );
						}
						echo '</div>';
					}
				echo '</li>';
			}
			echo '</ul>';
			wp_reset_postdata();
		}
		echo '</div>';
		echo $args['after_widget'];
	}

	//----------------------------------------------------------------------------------
	// Output the widget's contents on the back-end
	//----------------------------------------------------------------------------------
	public function form( $instance ) {

		// Prepare defaults and override with saved values
		$instance = $this->defaults($instance);

		?>
		<div class="mission-post-list-widget">
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'mission-news' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( esc_attr( $instance['title'] ) ); ?>">
			</p>
			<h4><?php esc_html_e( 'Post Source', 'mission-news' ); ?></h4>
			<div class="container">
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $instance['use_category'], 'yes' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'use_category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'use_category' ) ); ?>" value="<?php echo esc_attr( $instance['use_category'] ); ?>" />
					<label for="<?php echo esc_attr( $this->get_field_id( 'use_category' ) ); ?>"><?php esc_html_e( 'Category', 'mission-news' ); ?></label>
				</p>
				<p class="category">
					<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Category', 'mission-news' ); ?></label>
					<?php
					wp_dropdown_categories( array(
						'hide_empty' => 0,
						'selected'   => $instance['category'],
						'id'         => $this->get_field_id( 'category' ),
						'name'       => $this->get_field_name( 'category' )
					) ); ?>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $instance['use_tag'], 'yes' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'use_tag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'use_tag' ) ); ?>" value="<?php echo esc_attr( $instance['use_tag'] ); ?>" />
					<label for="<?php echo esc_attr( $this->get_field_id( 'use_tag' ) ); ?>"><?php esc_html_e( 'Tag', 'mission-news' ); ?></label>
				</p>
				<p class="tag">
					<label for="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>"><?php esc_html_e( 'Tag', 'mission-news' ); ?></label>
					<?php wp_dropdown_categories( array(
						'taxonomy'   => 'post_tag',
						'hide_empty' => 0,
						'selected'   => $instance['tag'],
						'id'         => $this->get_field_id( 'tag' ),
						'name'       => $this->get_field_name( 'tag' )
					) ); ?>
				</p>
				<p class="relationship">
					<label for="<?php echo esc_attr( $this->get_field_id( 'relationship' ) ); ?>"><?php esc_html_e( 'Relationship', 'mission-news' ); ?></label>
					<select name="<?php echo esc_attr( $this->get_field_name( 'relationship' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'relationship' ) ); ?>" class="postform">
						<option value="AND" <?php selected( $instance['relationship'], 'AND'); ?>><?php esc_html_e( 'AND', 'mission-news' ); ?></option>
						<option value="OR" <?php selected( $instance['relationship'], 'OR'); ?>><?php esc_html_e( 'OR', 'mission-news' ); ?></option>
					</select>
				</p>
				<div class="tooltip">
					<a class="tip-icon" href="#">?</a>
					<p class="tip">
						<?php echo esc_html_e( 'Selecting both a category and a tag will require posts to be in both. If you\'d like to get posts from either the category or tag, switch the "Relationship" option to "OR." If you\'d like to use
						the most recent posts from any tag or category, uncheck both "Category" and "Tag."', 'mission-news' ); ?>
					</p>
				</div>
				
			</div>
			<h4><?php esc_html_e( 'Content', 'mission-news' ); ?></h4>
			<div class="container">
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $instance['author'], 'yes' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'author' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'author' ) ); ?>" value="<?php echo esc_attr( $instance['author'] ); ?>" />
					<label for="<?php echo esc_attr( $this->get_field_id( 'author' ) ); ?>"><?php esc_html_e( 'Show author in byline', 'mission-news' ); ?></label>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $instance['date'], 'yes' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date' ) ); ?>" value="<?php echo esc_attr( $instance['date'] ); ?>" />
					<label for="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>"><?php esc_html_e( 'Show date in byline', 'mission-news' ); ?></label>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $instance['image'], 'yes' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" value="<?php echo esc_attr( $instance['image'] ); ?>" />
					<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'Show Featured Images', 'mission-news' ); ?></label>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $instance['excerpt'], 'yes' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt' ) ); ?>" value="<?php echo esc_attr( $instance['excerpt'] ); ?>" />
					<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>"><?php esc_html_e( 'Show excerpt', 'mission-news' ); ?></label>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $instance['comments'], 'yes' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'comments' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'comments' ) ); ?>" value="<?php echo esc_attr( $instance['comments'] ); ?>" />
					<label for="<?php echo esc_attr( $this->get_field_id( 'comments' ) ); ?>"><?php esc_html_e( 'Show comments link', 'mission-news' ); ?></label>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $instance['post_category'], 'yes' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'post_category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_category' ) ); ?>" value="<?php echo esc_attr( $instance['post_category'] ); ?>" />
					<label for="<?php echo esc_attr( $this->get_field_id( 'post_category' ) ); ?>"><?php esc_html_e( 'Show category link', 'mission-news' ); ?></label>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php checked( $instance['exclude_current'], 'yes' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'exclude_current' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude_current' ) ); ?>" value="<?php echo esc_attr( $instance['exclude_current'] ); ?>" />
					<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_current' ) ); ?>"><?php esc_html_e( 'Exclude current post', 'mission-news' ); ?></label>
				</p>
				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'post_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_count' ) ); ?>" type="text" size="2" value="<?php echo esc_attr( $instance['post_count'] ); ?>">
					<label for="<?php echo esc_attr( $this->get_field_id( 'post_count' ) ); ?>"><?php esc_html_e( 'Number of posts', 'mission-news' ); ?></label>
				</p>
				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_length' ) ); ?>" type="text" size="2" value="<?php echo esc_attr( $instance['excerpt_length'] ); ?>">
					<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>"><?php esc_html_e( 'Excerpt word count', 'mission-news' ); ?></label>
				</p>
			</div>
			<h4><?php esc_html_e( 'Style', 'mission-news' ); ?></h4>
			<div class="container">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php esc_html_e( 'Style', 'mission-news' ); ?></label>
					<select name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" class="postform">
						<option value="1" <?php selected( $instance['style'], 1); ?>><?php esc_html_e( 'Style 1', 'mission-news' ); ?></option>
						<option value="2" <?php selected( $instance['style'], 2); ?>><?php esc_html_e( 'Style 2', 'mission-news' ); ?></option>
					</select>
				</p>
			</div>
		</div>
		<?php
	}

	//----------------------------------------------------------------------------------
	// Save the widget settings
	//----------------------------------------------------------------------------------
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance = $this->defaults($new_instance);
		$instance['use_category'] 	 = isset( $new_instance['use_category'] ) ? 'yes' : 'no';
		$instance['use_tag']      	 = isset( $new_instance['use_tag'] ) ? 'yes' : 'no';
		$instance['author']       	 = isset( $new_instance['author'] ) ? 'yes' : 'no';
		$instance['date']         	 = isset( $new_instance['date'] ) ? 'yes' : 'no';
		$instance['image']        	 = isset( $new_instance['image'] ) ? 'yes' : 'no';
		$instance['excerpt']      	 = isset( $new_instance['excerpt'] ) ? 'yes' : 'no';
		$instance['comments']     	 = isset( $new_instance['comments'] ) ? 'yes' : 'no';
		$instance['post_category']   = isset( $new_instance['post_category'] ) ? 'yes' : 'no';
		$instance['exclude_current'] = isset( $new_instance['exclude_current'] ) ? 'yes' : 'no';

		return $instance;
	}
}

//----------------------------------------------------------------------------------
// Register the widget
//----------------------------------------------------------------------------------
function ct_mission_news_register_post_list_widget() {
	register_widget( 'ct_mission_news_post_list' );
}
add_action( 'widgets_init', 'ct_mission_news_register_post_list_widget' );