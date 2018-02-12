<?php if ( is_active_sidebar( 'below-header' ) ) : 
	$widgets      = get_option( 'sidebars_widgets' );
	$widget_count = count( $widgets['below-header'] );
	?>
	<aside id="below-header" class="widget-area widget-area-below-header active-<?php echo $widget_count; ?>" role="complementary">
		<?php dynamic_sidebar( 'below-header' ); ?>
	</aside>
<?php endif;