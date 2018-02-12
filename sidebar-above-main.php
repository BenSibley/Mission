<?php if ( is_active_sidebar( 'above-main' ) ) : 
	$widgets      = get_option( 'sidebars_widgets' );
	$widget_count = count( $widgets['above-main'] );
	?>
	<aside id="above-main" class="widget-area widget-area-above-main active-<?php echo $widget_count; ?>"  role="complementary">
		<?php dynamic_sidebar( 'above-main' ); ?>
	</aside>
<?php endif;