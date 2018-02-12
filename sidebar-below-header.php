<?php if ( is_active_sidebar( 'below-header' ) ) : 
	$widgets      = get_option( 'sidebars_widgets' );
	$widget_class = count( $widgets['below-header'] );
	if ( get_theme_mod('ct_mission_widget_styles_below_header_layout') == 'column' ) {
		$widget_class = 1;
	}
	?>
	<aside id="below-header" class="widget-area widget-area-below-header active-<?php echo $widget_class; ?>" role="complementary">
		<?php dynamic_sidebar( 'below-header' ); ?>
	</aside>
<?php endif;