<?php if ( get_theme_mod( 'author_box' ) == 'no' ) return; ?>
<div class="post-author">
	<div class="avatar-container">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 78, '', get_the_author() ); ?>
	</div>
	<div>
		<h3><?php the_author(); ?></h3>
		<p><?php the_author_meta('description'); ?></p>
	</div>
</div>