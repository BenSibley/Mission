<?php if ( is_active_sidebar( 'site-footer' ) ) : 
	$widgets      = get_option( 'sidebars_widgets' );
	$widget_class = count( $widgets['site-footer'] );
	if ( get_theme_mod('ct_mission_widget_styles_footer_layout') == 'column' ) {
		$widget_class = 1;
	}
	?>
	<aside id="site-footer-widgets" class="widget-area widget-area-site-footer active-<?php echo $widget_class; ?>" role="complementary">
		<?php dynamic_sidebar( 'site-footer' ); ?>
	</aside>
<?php endif;