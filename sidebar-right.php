<?php
$layout = get_theme_mod( 'layout_posts' );
if ( is_singular( 'post' ) && ( $layout == 'left-sidebar' || $layout == 'no-sidebar' ) ) {
	return;
}
if ( is_active_sidebar( 'right' ) ) : ?>
	<aside class="sidebar sidebar-right" id="sidebar-right" role="complementary">
		<div class="inner">
			<?php dynamic_sidebar( 'right' ); ?>
		</div>
	</aside>
<?php endif;