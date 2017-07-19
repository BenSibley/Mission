<?php
$author = get_theme_mod( 'post_byline_author' );
$date   = get_theme_mod( 'post_byline_date' );
?>
<div <?php post_class(); ?>>
	<?php do_action( 'ct_mission_post_before' ); ?>
	<article>
		<?php ct_mission_featured_image(); ?>
		<div class='post-header'>
			<h1 class='post-title'><?php the_title(); ?></h1>
			<?php ct_mission_post_byline( $author, $date ); ?>
		</div>
		<div class="post-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array(
				'before' => '<p class="singular-pagination">' . esc_html__( 'Pages:', 'mission' ),
				'after'  => '</p>',
			) ); ?>
			<?php do_action( 'ct_mission_post_after' ); ?>
		</div>
		<div class="post-meta">
			<?php get_template_part( 'content/post-categories' ); ?>
			<?php get_template_part( 'content/post-tags' ); ?>
			<?php get_template_part( 'content/post-nav' ); ?>
		</div>
	</article>
	<?php comments_template(); ?>
</div>