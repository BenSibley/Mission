<?php
$author = get_theme_mod( 'post_author_blog_archives' );
$date   = get_theme_mod( 'post_date_blog_archives' );
$categories   = get_theme_mod( 'post_categories_blog_archives' );
$post_title_position = get_theme_mod('post_titles_positioning');
?>
<div <?php post_class(); ?>>
	<?php do_action( 'ct_mission_news_archive_post_before' ); ?>
	<article>
		<?php
		if ( $post_title_position == '' || $post_title_position == 'below' ) {
			ct_mission_news_featured_image();
		} ?>
		<div class='post-header'>
			<?php do_action( 'ct_mission_news_sticky_post_status' ); ?>
			<h2 class='post-title'>
				<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
			</h2>
			<?php ct_mission_news_post_byline( $author, $date, $categories ); ?>
		</div>
		<?php
		if ( $post_title_position == 'above' ) {
			ct_mission_news_featured_image();
		} ?>
		<div class="post-content">
			<?php echo ct_mission_news_excerpt(); ?>
		</div>
	</article>
	<?php do_action( 'ct_mission_news_archive_post_after' ); ?>
</div>