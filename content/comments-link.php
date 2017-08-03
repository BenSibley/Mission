<span class="comments-link">
	<a href="<?php echo esc_url( get_comments_link() ); ?>">
	<i class="fa fa-comment-o" title="<?php esc_attr_e( 'comment icon', 'mission-news' ); ?>"></i>
		<?php
		if ( ! comments_open() && get_comments_number() < 1 ) :
			comments_number( esc_html__( 'Comments closed', 'mission-news' ), esc_html__( '1 Comment', 'mission-news' ), esc_html__( '% Comments', 'mission-news' ) );
		else :
			comments_number( esc_html__( 'Leave a Comment', 'mission-news' ), esc_html__( '1 Comment', 'mission-news' ), esc_html__( '% Comments', 'mission-news' ) );
		endif;
		?>
	</a>
</span>