<div <?php post_class(); ?>>
	<?php do_action( 'ct_mission_archive_post_before' ); ?>
	<article>
		<?php ct_mission_featured_image(); ?>
		<div class='post-header'>
			<?php do_action( 'ct_mission_sticky_post_status' ); ?>
			<h2 class='post-title'>
				<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
			</h2>
		</div>
	</article>
	<?php do_action( 'ct_mission_archive_post_after' ); ?>
</div>