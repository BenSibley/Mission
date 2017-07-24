<?php

if ( ! is_archive() ) {
	return;
}

$icon_class = 'folder-open';
$prefix = esc_html_x( 'Posts published in', 'Posts published in CATEGORY', 'mission' );

if ( is_tag() ) {
	$icon_class = 'tag';
	$prefix = esc_html__( 'Posts tagged as', 'mission' );
} elseif ( is_author() ) {
	$icon_class = 'user';
	$prefix = esc_html_x( 'Posts published by', 'Posts published by AUTHOR', 'mission' );
} elseif ( is_date() ) {
	$icon_class = 'calendar';
	// Repeating default value to add new translator note - context may change word choice
	$prefix = esc_html_x( 'Posts published in', 'Posts published in MONTH', 'mission' );
}
?>

<div class='archive-header'>
	<h1>
		<i class="fa fa-<?php echo esc_attr( $icon_class ); ?>"></i>
		<?php
		echo esc_html( $prefix ) . ' ';
		the_archive_title( '&ldquo;', '&rdquo;' );
		?>
	</h1>
	<?php if ( get_the_archive_description() != '' ) : ?>
		<?php the_archive_description(); ?>
	<?php endif; ?>
</div>