<?php if ( is_active_sidebar( 'above-main' ) ) : 
	$widgets      = get_option( 'sidebars_widgets' );
	$widget_class = count( $widgets['above-main'] );
	if ( get_theme_mod('ct_mission_widget_styles_above_posts_layout') == 'column' ) {
		$widget_class = 1;
	}
	?>
	<aside id="above-main" class="widget-area widget-area-above-main active-<?php echo $widget_class; ?>"  role="complementary">
		<?php dynamic_sidebar( 'above-main' ); ?>
	</aside>
<?php endif;