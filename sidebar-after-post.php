<?php if ( is_active_sidebar( 'after-post' ) ) : 
	$widgets      = get_option( 'sidebars_widgets' );
	$widget_class = count( $widgets['after-post'] );
	if ( get_theme_mod('ct_mission_widget_styles_after_post_content_layout') == 'column' ) {
		$widget_class = 1;
	}
	?>
	<aside id="after-post" class="widget-area widget-area-after-post active-<?php echo $widget_class; ?>" role="complementary">
		<?php dynamic_sidebar( 'after-post' ); ?>
	</aside>
<?php endif;