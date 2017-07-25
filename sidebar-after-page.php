<?php if ( is_active_sidebar( 'after-page' ) ) : ?>
	<aside class="widget-area widget-area-after-page" id="after-page" role="complementary">
		<?php dynamic_sidebar( 'after-page' ); ?>
	</aside>
<?php endif;