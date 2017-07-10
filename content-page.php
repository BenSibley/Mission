<div <?php post_class(); ?>>
	<?php do_action( 'ct_theme_name_page_before' ); ?>
	<article>
		<?php ct_ct_theme_name_featured_image(); ?>
		<div class='post-header'>
			<h1 class='post-title'><?php the_title(); ?></h1>
		</div>
		<div class="post-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array(
				'before' => '<p class="singular-pagination">' . esc_html__( 'Pages:', 'ct-theme-name' ),
				'after'  => '</p>',
			) ); ?>
			<?php do_action( 'ct_theme_name_page_after' ); ?>
		</div>
	</article>
	<?php comments_template(); ?>
</div>