<?php

if ( ! is_archive() ) {
	return;
}

$icon_class = 'folder-open';
$prefix = esc_html_x( 'Posts published in', 'Posts published in CATEGORY', 'ct-theme-name' );

if ( is_tag() ) {
	$icon_class = 'tag';
	$prefix = esc_html__( 'Posts tagged as', 'ct-theme-name' );
} elseif ( is_author() ) {
	$icon_class = 'user';
	$prefix = esc_html_x( 'Posts published by', 'Posts published by AUTHOR', 'ct-theme-name' );
} elseif ( is_date() ) {
	$icon_class = 'calendar';
	// Repeating default value to add new translator note - context may change word choice
	$prefix = esc_html_x( 'Posts published in', 'Posts published in MONTH', 'ct-theme-name' );
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
		<p class="description">
			<?php the_archive_description(); ?>
		</p>
	<?php endif; ?>
</div>