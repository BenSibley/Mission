<?php if ( is_active_sidebar( 'after-post' ) ) : ?>
	<aside class="widget-area widget-area-after-post" id="after-post" role="complementary">
		<?php dynamic_sidebar( 'after-post' ); ?>
	</aside>
<?php endif;