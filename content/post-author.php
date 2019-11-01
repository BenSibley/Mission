<?php if ( get_theme_mod( 'author_box_posts' ) == 'no' ) return; ?>
<div class="post-author">
	<?php if ( get_theme_mod( 'author_avatar_posts' ) != 'no' ) : ?>
	<div class="avatar-container">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 78, '', get_the_author() ); ?>
	</div>
	<?php endif; ?>
	<div>
		<div class="author"><?php the_author(); ?></div>
		<p><?php the_author_meta('description'); ?></p>
		<?php if ( get_theme_mod( 'author_link_posts' ) == 'yes' ) : ?>
				<p>
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>">
						<?php echo esc_html_e( 'More posts from', 'mission-news' ) . ' ' . get_the_author(); ?>
					</a>
				</p>
		<?php endif; ?>
	</div>
</div>