<?php

$date_class = 'has-date';
if ( get_theme_mod( 'date' ) == 'no' ) {
	$date_class = 'no-date';
}

echo "<div class='site-title ". esc_attr($date_class)  ."'>";
	if ( has_custom_logo() ) {
		the_custom_logo();
	} else {
		echo "<a href='" . esc_url( home_url() ) . "'>";
			bloginfo( 'name' );
		echo "</a>";
	}
echo "</div>";