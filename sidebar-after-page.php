<?php if ( is_active_sidebar( 'after-page' ) ) : 
	$widgets      = get_option( 'sidebars_widgets' );
	$widget_count = count( $widgets['after-page'] );
	?>
	<aside id="after-page" class="widget-area widget-area-after-page active-<?php echo $widget_count; ?>" role="complementary">
		<?php dynamic_sidebar( 'after-page' ); ?>
	</aside>
<?php endif;