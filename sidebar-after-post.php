<?php if ( is_active_sidebar( 'after-post' ) ) : 
	$widgets      = get_option( 'sidebars_widgets' );
	$widget_count = count( $widgets['after-post'] );
	?>
	<aside id="after-post" class="widget-area widget-area-after-post active-<?php echo $widget_count; ?>" role="complementary">
		<?php dynamic_sidebar( 'after-post' ); ?>
	</aside>
<?php endif;