<?php if ( is_active_sidebar( 'after-first-post' ) ) : 
	$widgets      = get_option( 'sidebars_widgets' );
	$widget_count = count( $widgets['after-first-post'] );
	?>
	<aside id="after-first-post" class="widget-area widget-area-after-first-post active-<?php echo $widget_count; ?>" role="complementary">
		<?php dynamic_sidebar( 'after-first-post' ); ?>
	</aside>
<?php endif;