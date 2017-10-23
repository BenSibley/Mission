<?php
$author = get_theme_mod( 'post_author_blog_archives' );
$date   = get_theme_mod( 'post_date_blog_archives' );
?>
<div <?php post_class(); ?>>
	<?php do_action( 'ct_mission_news_archive_post_before' ); ?>
	<article>
		<?php ct_mission_news_featured_image(); ?>
		<div class='post-header'>
			<?php do_action( 'ct_mission_news_sticky_post_status' ); ?>
			<h2 class='post-title'>
				<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
			</h2>
			<?php ct_mission_news_post_byline( $author, $date ); ?>
		</div>
	</article>
	<?php do_action( 'ct_mission_news_archive_post_after' ); ?>
</div>