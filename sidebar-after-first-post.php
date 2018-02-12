<?php if ( is_active_sidebar( 'after-first-post' ) ) : 
	$widgets      = get_option( 'sidebars_widgets' );
	$widget_class = count( $widgets['after-first-post'] );
	if ( get_theme_mod('ct_mission_widget_styles_after_first_post_layout') == 'column' ) {
		$widget_class = 1;
	}
	?>
	<aside id="after-first-post" class="widget-area widget-area-after-first-post active-<?php echo $widget_class; ?>" role="complementary">
		<?php dynamic_sidebar( 'after-first-post' ); ?>
	</aside>
<?php endif;