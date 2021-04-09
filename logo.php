<?php

$date_class = 'has-date';
if ( get_theme_mod( 'date' ) == 'no' ) {
	$date_class = 'no-date';
}

echo "<div class='site-title ". esc_attr($date_class)  ."'>";
	if ( $args['source'] == 'footer' && get_theme_mod('footer_logo') ) { ?>
		<a class="footer-logo" href="<?php echo esc_url( home_url() ); ?>">
			<img src="<?php echo esc_url(get_theme_mod('footer_logo')); ?>" />
			<span class="screen-reader-text"><?php echo esc_html( get_bloginfo('name') );  ?></span>
		</a><?php
	} elseif ( $args['source'] == 'footer' && has_custom_logo() ) {
		the_custom_logo();
	} elseif ( $args['source'] == 'header' && has_custom_logo() ) {
		the_custom_logo();
	} else {
		echo "<a href='" . esc_url( home_url() ) . "'>";
		bloginfo( 'name' );
		echo "</a>";
	}
echo "</div>";