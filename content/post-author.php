<?php if ( get_theme_mod( 'author_box' ) == 'no' ) return; ?>
<div class="post-author">
	<div class="avatar-container">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 65, '', get_the_author() ); ?>
	</div>
	<h3>
		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
			<?php the_author(); ?>
		</a>
	</h3>
	<p><?php the_author_meta('description'); ?></p>
	<?php ct_mission_social_icons_output( 'author' ) ?>
</div>