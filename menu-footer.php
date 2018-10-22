<div id="menu-footer" class="menu-container menu-footer" role="navigation">
	<?php wp_nav_menu(
		array(
			'theme_location'  => 'footer',
			'container'       => 'nav',
			'container_class' => 'menu',
			'fallback_cb'			=> false,
			'menu_class'      => 'menu-footer-items',
			'menu_id'         => 'menu-footer-items',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>'
		) ); ?>
</div>
