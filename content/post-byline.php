<?php
$author_display = get_theme_mod( 'post_byline_author' );
$date_display   = get_theme_mod( 'post_byline_date' );

if ( $author_display == 'no' && $date_display == 'no' ) {
	return;
}

$author = get_the_author();
// add compatibility when used in header before loop
if ( empty( $author ) ) {
	global $post;
	$author = get_the_author_meta( 'display_name', $post->post_author );
}
$date   = date_i18n( get_option( 'date_format' ), strtotime( get_the_date() ) );

echo '<div class="post-byline">';
if ( $author_display == 'no' ) {
	// translators: placeholder is the date the post was published
	printf( esc_html_x( 'Published %s', 'This blog post was published on some date', 'mission' ), esc_html( $date ) );
} elseif ( $date_display == 'no' ) {
	// translators: placeholder is the author who published the post
	printf( esc_html_x( 'Published by %s', 'This blog post was published by some author', 'mission' ), esc_html( $author ) );
} else {
	// translators: placeholders are the date the post was published and the author who published it
	printf( esc_html_x( 'Published %1$s by %2$s', 'This blog post was published on some date by some author', 'mission' ), esc_html( $date ), esc_html( $author ) );
}
echo '</div>';
