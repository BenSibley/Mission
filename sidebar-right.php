<?php
// Get layout set in Customizer and override if post has its own layout selected via meta box
$layout = apply_filters( 'ct_mission_news_layout_filter', get_theme_mod( 'layout_posts' ) );
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