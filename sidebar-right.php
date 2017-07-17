<?php if ( is_active_sidebar( 'right' ) ) : ?>
	<aside class="sidebar sidebar-right" id="sidebar-right" role="complementary">
		<?php dynamic_sidebar( 'right' ); ?>
	</aside>
<?php endif;