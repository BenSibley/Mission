<?php

//----------------------------------------------------------------------------------
// Update the markup of individual comments
//----------------------------------------------------------------------------------
if ( ! function_exists( ( 'ct_mission_news_customize_comments' ) ) ) {
	function ct_mission_news_customize_comments( $comment, $args, $depth ) { ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-author">
				<?php
				echo get_avatar( get_comment_author_email(), 36, '', get_comment_author() );
				?>
				<span class="author-name"><?php comment_author_link(); ?></span>
				<span class="comment-date">
					<?php
					global $post;
					if ( $comment->user_id === $post->post_author && get_theme_mod( 'author_label' ) != 'no' ) {
						echo '<span>' . esc_html__( 'Post author', 'mission-news' ) . '</span>';
						if ( get_theme_mod( 'comment_date' ) != 'no' ) {
							echo ' | ';
						}
					}
					if ( get_theme_mod( 'comment_date' ) != 'no' ) {
						comment_date();
					}
					?>
				</span>
			</div>
			<div class="comment-content">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php esc_html_e( 'Your comment is awaiting moderation.', 'mission-news' ) ?></em>
					<br/>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
			<div class="comment-footer">
				<?php comment_reply_link( array_merge( $args, array(
					'reply_text' => esc_html__( 'Reply', 'mission-news' ),
					'depth'      => $depth,
					'max_depth'  => $args['max_depth']
				) ) ); ?>
				<?php edit_comment_link( esc_html__( 'Edit', 'mission-news' ) ); ?>
			</div>
		</article>
		<?php
	}
}

//----------------------------------------------------------------------------------
// Update the form fields in the comment form
//----------------------------------------------------------------------------------
if ( ! function_exists( 'ct_mission_news_update_fields' ) ) {
	function ct_mission_news_update_fields( $fields ) {

		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$label     = $req ? '*' : ' ' . esc_html__( '(optional)', 'mission-news' );
		$aria_req  = $req ? "aria-required='true'" : '';

		$fields['author'] =
			'<p class="comment-form-author">
	            <label for="author">' . esc_html__( "Name", "mission-news" ) . esc_html( $label ) . '</label>
	            <input id="author" name="author" type="text" placeholder="' . esc_attr__( "Jane Doe", "mission-news" ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
			'" size="30" ' . esc_html( $aria_req ) . ' />
	        </p>';

		$fields['email'] =
			'<p class="comment-form-email">
	            <label for="email">' . esc_html__( "Email", "mission-news" ) . esc_html( $label ) . '</label>
	            <input id="email" name="email" type="email" placeholder="' . esc_attr__( "name@email.com", "mission-news" ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) .
			'" size="30" ' . esc_html( $aria_req ) . ' />
	        </p>';

		$fields['url'] =
			'<p class="comment-form-url">
	            <label for="url">' . esc_html__( "Website", "mission-news" ) . '</label>
	            <input id="url" name="url" type="url" placeholder="http://google.com" value="' . esc_attr( $commenter['comment_author_url'] ) .
			'" size="30" />
	            </p>';

		return $fields;
	}
}
add_filter( 'comment_form_default_fields', 'ct_mission_news_update_fields' );

//----------------------------------------------------------------------------------
// Update the comment textarea field
//----------------------------------------------------------------------------------
if ( ! function_exists( 'ct_mission_news_update_comment_field' ) ) {
	function ct_mission_news_update_comment_field( $comment_field ) {

		$comment_field =
			'<p class="comment-form-comment">
	            <label for="comment">' . esc_html__( "Comment", "mission-news" ) . '</label>
	            <textarea required id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
	        </p>';

		return $comment_field;
	}
}
add_filter( 'comment_form_field_comment', 'ct_mission_news_update_comment_field' );

//----------------------------------------------------------------------------------
// Remove comment notes with markup that displays after the comment form
//----------------------------------------------------------------------------------
if ( ! function_exists( 'ct_mission_news_remove_comments_notes_after' ) ) {
	function ct_mission_news_remove_comments_notes_after( $defaults ) {
		$defaults['comment_notes_after'] = '';
		return $defaults;
	}
}
add_action( 'comment_form_defaults', 'ct_mission_news_remove_comments_notes_after' );