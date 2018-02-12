<?php if ( is_active_sidebar( 'after-page' ) ) : 
	$widgets      = get_option( 'sidebars_widgets' );
	$widget_class = count( $widgets['after-page'] );
	if ( get_theme_mod('ct_mission_widget_styles_after_page_content_layout') == 'column' ) {
		$widget_class = 1;
	}
	?>
	<aside id="after-page" class="widget-area widget-area-after-page active-<?php echo $widget_class; ?>" role="complementary">
		<?php dynamic_sidebar( 'after-page' ); ?>
	</aside>
<?php endif;