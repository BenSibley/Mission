<?php
$author = get_theme_mod( 'post_byline_author' );
$date   = get_theme_mod( 'post_byline_date' );
?>
<div <?php post_class(); ?>>
	<?php do_action( 'ct_mission_archive_post_before' ); ?>
	<article>
		<?php ct_mission_featured_image(); ?>
		<div class='post-header'>
			<?php do_action( 'ct_mission_sticky_post_status' ); ?>
			<h2 class='post-title'>
				<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
			</h2>
			<?php ct_mission_post_byline( $author, $date ); ?>
		</div>
		<div class="post-content">
			<?php echo wp_kses_post( ct_mission_excerpt() ); ?>
		</div>
	</article>
	<?php do_action( 'ct_mission_archive_post_after' ); ?>
</div>