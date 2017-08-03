<?php
if ( get_theme_mod( 'tag_links_posts') == 'no' ) return;

$tags   = get_the_tags( $post->ID );
$output = '';
if ( $tags ) {
	echo '<div class="post-tags">';
	echo '<ul>';
	foreach ( $tags as $tag ) {
		// translators: placeholder is the name of the post tag
		echo '<li><a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts tagged %s", 'mission-news' ), $tag->name ) ) . '">' . esc_html( $tag->name ) . '</a></li>';
	}
	echo '</ul>';
	echo '</div>';
}