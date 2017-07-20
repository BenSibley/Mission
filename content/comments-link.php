<span class="comments-link">
	<a href="<?php echo esc_url( get_comments_link() ); ?>">
	<i class="fa fa-comment-o" title="<?php esc_attr_e( 'comment icon', 'mission' ); ?>"></i>
		<?php
		if ( ! comments_open() && get_comments_number() < 1 ) :
			comments_number( esc_html__( 'Comments closed', 'mission' ), esc_html__( '1 Comment', 'mission' ), esc_html__( '% Comments', 'mission' ) );
		else :
			comments_number( esc_html__( 'Leave a Comment', 'mission' ), esc_html__( '1 Comment', 'mission' ), esc_html__( '% Comments', 'mission' ) );
		endif;
		?>
	</a>
</span>