<?php

echo "<div id='site-title' class='site-title'>";
	if ( has_custom_logo() ) {
		the_custom_logo();
	} else {
		echo "<a href='" . esc_url( home_url() ) . "'>";
			bloginfo( 'name' );
		echo "</a>";
	}
echo "</div>";