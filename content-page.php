<div <?php post_class(); ?>>
	<?php do_action( 'ct_mission_news_page_before' ); ?>
	<article>
		<?php ct_mission_news_featured_image(); ?>
		<div class='post-header'>
			<h1 class='post-title'><?php the_title(); ?></h1>
		</div>
		<div class="post-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array(
				'before' => '<p class="singular-pagination">' . esc_html__( 'Pages:', 'mission-news' ),
				'after'  => '</p>',
			) ); ?>
			<?php do_action( 'ct_mission_news_page_after' ); ?>
			<?php get_sidebar( 'after-page' ); ?>
		</div>
	</article>
	<?php comments_template(); ?>
</div>