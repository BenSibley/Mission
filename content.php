<?php
$author = get_theme_mod( 'post_author_posts' );
$date   = get_theme_mod( 'post_date_posts' );
?>
<div <?php post_class(); ?>>
	<?php do_action( 'ct_mission_news_post_before' ); ?>
	<article>
		<?php ct_mission_news_featured_image(); ?>
		<div class='post-header'>
			<h1 class='post-title'><?php the_title(); ?></h1>
			<?php ct_mission_news_post_byline( $author, $date ); ?>
		</div>
		<div class="post-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array(
				'before' => '<p class="singular-pagination">' . esc_html__( 'Pages:', 'mission-news' ),
				'after'  => '</p>',
			) ); ?>
			<?php do_action( 'ct_mission_news_post_after' ); ?>
		</div>
		<div class="post-meta">
			<?php get_template_part( 'content/post-categories' ); ?>
			<?php get_template_part( 'content/post-tags' ); ?>
			<?php get_sidebar( 'after-post' ); ?>
			<?php get_template_part( 'content/post-author' ); ?>
		</div>
		<?php get_template_part( 'content/more-from-category' ); ?>
	</article>
	<?php comments_template(); ?>
</div>