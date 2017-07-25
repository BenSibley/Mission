<?php if ( is_active_sidebar( 'after-first-post' ) ) : ?>
	<aside class="widget-area widget-area-after-first-post" id="after-first-post" role="complementary">
		<?php dynamic_sidebar( 'after-first-post' ); ?>
	</aside>
<?php endif;