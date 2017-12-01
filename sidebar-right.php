<?php
// Get layout set in Customizer and override if post has its own layout selected via meta box
$layout_post = apply_filters( 'ct_mission_news_layout_filter', get_theme_mod( 'layout_posts' ) );
$layout_page = apply_filters( 'ct_mission_news_layout_filter', get_theme_mod( 'layout_pages' ) );
if (
	(is_singular( 'post' ) && ( $layout_post == 'left-sidebar' || $layout_post == 'no-sidebar' ) )
	|| (is_singular( 'page' ) && ( $layout_page == 'left-sidebar' || $layout_page == 'no-sidebar' ) )
){
	return;
}
if ( is_active_sidebar( 'right' ) ) : ?>
	<aside class="sidebar sidebar-right" id="sidebar-right" role="complementary">
		<div class="inner">
			<?php dynamic_sidebar( 'right' ); ?>
		</div>
	</aside>
<?php endif;