<?php
if ( get_theme_mod( 'search' ) == 'no' ) {
	return;
}
?>
<button id="search-toggle" class="search-toggle"><i class="fa fa-search"></i><span><?php echo esc_html__( 'Search', 'mission-news' );?></span></button>
<div id="search-form-popup" class="search-form-popup">
	<div class="inner">
		<div class="title"><?php echo esc_html__( 'Search', 'mission-news' ) . ' ' . esc_html( get_bloginfo('name') ); ?></div>
		<?php get_search_form(); ?>
		<a id="close-search" class="close" href="#"><?php echo ct_mission_news_svg_output( 'close' ); ?></a>
	</div>
</div>
