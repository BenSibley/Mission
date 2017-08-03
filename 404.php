<?php get_header(); ?>
	<div class="entry">
		<article>
			<div class='post-header'>
				<h1 class='post-title'><?php esc_html_e('404: Page Not Found', 'mission-news'); ?></h1>
			</div>
			<div class="post-content">
				<p><?php esc_html_e('Sorry, we couldn\'t find a page at this URL', 'mission-news' ); ?></p>
				<p><?php esc_html_e('Please double-check that the URL is correct or try searching our site with the form below.', 'mission-news' ); ?></p>
			</div>
			<div class="search-box">
				<?php get_search_form(); ?>
			</div>
		</article>
	</div>
<?php get_footer(); ?>