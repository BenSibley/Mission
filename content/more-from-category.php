<?php
if ( get_theme_mod( 'more_from_posts' ) == 'no' ) return;

global $post;
$categories = wp_get_post_categories( $post->ID );
?>
<div class="more-from-category">
	<?php
	foreach ( $categories as $category ) {
		$cat_posts = get_posts( array(
			'posts_per_page' => 4,
			'category'       => $category,
			'exclude'        => $post->ID
		) );
		if ( count( $cat_posts ) < 1 ) continue;
		echo '<div class="category-container">';
			echo '<div class="top">';
				echo '<span class="section-title">' . esc_html_x( 'More from', 'More from POST CATEGORY', 'mission-news' ) . ' <span>' . esc_html( get_cat_name( $category ) ) . '</span></span>';
			// Translators: %s is the name of the post category
			echo '<a class="category-link" href="' . esc_url( get_category_link( $category ) ) . '">' . sprintf( esc_html__( 'More posts in %s', 'mission-news' ), esc_html( get_cat_name( $category ) ) ) . ' &raquo;</a>';
			echo '</div>';
			echo '<ul>';
				foreach ( $cat_posts as $cat_post ) {
					echo '<li>';
						if ( has_post_thumbnail( $cat_post->ID ) ) {
							echo '<div class="featured-image"><a href="' . esc_url( get_permalink( $cat_post->ID ) ) . '">' . esc_html( get_the_title( $cat_post->ID ) ) . get_the_post_thumbnail( $cat_post->ID, 'medium' ) . '</a></div>';
						}
						echo '<a href="' . esc_url( get_permalink( $cat_post->ID ) ) . '" class="title">' . esc_html( get_the_title( $cat_post->ID ) ) . '</a>';
					echo '</li>';
				}
			echo '</ul>';
		echo '</div>';
	}
	?>
</div>