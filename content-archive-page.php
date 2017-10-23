<div <?php post_class(); ?>>
	<?php do_action( 'ct_mission_news_archive_post_before' ); ?>
	<article>
		<?php ct_mission_news_featured_image(); ?>
		<div class='post-header'>
			<?php do_action( 'ct_mission_news_sticky_post_status' ); ?>
			<h2 class='post-title'>
				<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
			</h2>
		</div>
		<div class="post-content">
			<?php echo wp_kses_post( ct_mission_news_excerpt() ); ?>
		</div>
	</article>
	<?php do_action( 'ct_mission_news_archive_post_after' ); ?>
</div>