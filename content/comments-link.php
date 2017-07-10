<span class="comments-link">
	<i class="fa fa-comment" title="<?php esc_attr_e( 'comment icon', 'ct-theme-name' ); ?>"></i>
	<?php
	if ( ! comments_open() && get_comments_number() < 1 ) :
		comments_number( esc_html__( 'Comments closed', 'ct-theme-name' ), esc_html__( '1 Comment', 'ct-theme-name' ), esc_html__( '% Comments', 'ct-theme-name' ) );
	else :
		echo '<a href="' . esc_url( get_comments_link() ) . '">';
		comments_number( esc_html__( 'Leave a Comment', 'ct-theme-name' ), esc_html__( '1 Comment', 'ct-theme-name' ), esc_html__( '% Comments', 'ct-theme-name' ) );
		echo '</a>';
	endif;
	?>
</span>