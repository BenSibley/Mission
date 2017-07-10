<?php get_header(); ?>
	<div class="entry">
		<article>
			<div class="post-padding-container">
				<div class='post-header'>
					<h1 class='post-title'><?php esc_html__e('404: Page Not Found', 'ct-theme-name'); ?></h1>
				</div>
				<div class="post-content">
					<p><?php esc_html_e('Sorry, we couldn\'t find a page at this URL', 'ct-theme-name' ); ?></p>
					<p><?php esc_html_e('Please double-check that the URL is correct or try searching our site with the form below.', 'ct-theme-name' ); ?></p>
				</div>
				<?php get_search_form(); ?>
			</div>
		</article>
	</div>
<?php get_footer(); ?>