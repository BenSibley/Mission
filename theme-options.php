<?php

function ct_mission_news_register_theme_page() {
	add_theme_page( sprintf( esc_html__( '%s Dashboard', 'mission-news' ), wp_get_theme() ), sprintf( esc_html__( '%s Dashboard', 'mission-news' ), wp_get_theme() ), 'edit_theme_options', 'mission-options', 'ct_mission_news_options_content', 'ct_mission_news_options_content' );
}
add_action( 'admin_menu', 'ct_mission_news_register_theme_page' );

function ct_mission_news_options_content() {

	$customizer_url = add_query_arg(
		array(
			'url'    => get_home_url(),
			'return' => add_query_arg( 'page', 'mission-options', admin_url( 'themes.php' ) )
		),
		admin_url( 'customize.php' )
	);
	$pro_url = 'https://www.competethemes.com/mission-news-pro/?utm_source=wp-dashboard&utm_medium=Dashboard&utm_campaign=Mission%20News%20Pro%20-%20Dashboard';
	?>
	<div id="mission-news-dashboard-wrap" class="wrap mission-news-dashboard-wrap">
		<h2><?php printf( esc_html__( '%s Dashboard', 'mission-news' ), wp_get_theme() ); ?></h2>
		<?php do_action( 'ct_mission_news_theme_options_before' ); ?>
		<div class="main">
			<?php if ( defined( 'MISSION_NEWS_PRO_FILE' ) ) : ?>
			<div class="thanks-upgrading" style="background-image: url(<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/bg-texture.png'; ?>)">
				<h3>Thanks for upgrading!</h3>
				<p>You can find the new features in the Customizer</p>
			</div>
			<?php endif; ?>
			<?php if ( !defined( 'MISSION_NEWS_PRO_FILE' ) ) : ?>
			<div class="getting-started">
				<h3>Get Started with Mission News</h3>
				<p>Follow this step-by-step guide to customize your website with Mission News:</p>
				<a href="https://www.competethemes.com/help/getting-started-mission-news/" target="_blank">Read the Getting Started Guide</a>
			</div>
			<div class="pro">
				<h3>Customize More with Mission News Pro</h3>
				<p>Add 8 new customization features to your site with the <a href="<?php echo $pro_url; ?>" target="_blank">Mission News Pro</a> plugin.</p>
				<ul class="feature-list">
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/news-ticker.png'; ?>" />
						</div>
						<div class="text">
							<h4>News Ticker</h4>
							<p>Add a news ticker to the top or bottom of your site to promote your latest and most important posts.</p>
							<p>Change the colors, scrolling speed, and more with the customizable settings.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/custom-background.png'; ?>" />
						</div>
						<div class="text">
							<h4>Custom Background</h4>
							<p>Change your site to a boxed-style layout with a background image or any color.</p>
							<p>Choose the exact amount of space around your site and repeat images as textures too with this feature.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/slider.png'; ?>" />
						</div>
						<div class="text">
							<h4>Responsive Slider</h4>
							<p>Feature any posts you want in the responsive slider on desktop and mobile devices. Select custom posts or use a category or tag to source them dynamically.</p>
							<p>The slider comes with an auto-rotate option, custom background color, and more style options.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/fonts.png'; ?>" />
						</div>
						<div class="text">
							<h4>New Fonts</h4>
							<p>Stylish new fonts add character and charm to your content. Select and instantly preview fonts from the Customizer.</p>
							<p>Since Mission News Pro is powered by Google Fonts, it comes with 728 fonts for you to choose from.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/header-image.png'; ?>" />
						</div>
						<div class="text">
							<h4>Flexible Header Image</h4>
							<p>Header images welcome visitors and set your site apart. Upload your image and quickly resize it to the perfect size.</p>
							<p>Display the header image on just the homepage, or leave it sitewide and link it to the homepage.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/featured-videos.png'; ?>" />
						</div>
						<div class="text">
							<h4>Featured Videos</h4>
							<p>Featured Videos are an easy way to share videos in place of Featured Images. Instantly embed a Youtube video by copying and pasting its URL into an input.</p>
							<p>Mission News Pro auto-embeds videos from Youtube, Vimeo, DailyMotion, Flickr, Animoto, TED, Blip, Cloudup, FunnyOrDie, Hulu, Vine, WordPress.tv, and VideoPress.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/sticky-header.png'; ?>" />
						</div>
						<div class="text">
							<h4>Sticky Header</h4>
							<p>Want to keep your menu and social profiles accessible at all times? Easily enable the sticky header to keep it fixed at the top of the screen.</p>
							<p>The sticky header can be toggled on/off instantly for desktop and mobile device visitors.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/footer-text.png'; ?>" />
						</div>
						<div class="text">
							<h4>Custom Footer Text</h4>
							<p>Custom footer text lets you further brand your site. Just start typing to add your own text to the footer.</p>
							<p>The footer text supports plain text and full HTML for adding links.</p>
						</div>
					</li>
				</ul>
				<p><a href="<?php echo $pro_url; ?>" target="_blank">Click here</a> to view Mission News Pro now, and see what it can do for your site.</p>
			</div>
			<div class="pro-ad" style="background-image: url(<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/bg-texture.png'; ?>)">
				<h3>Add Incredible Flexibility to Your Site</h3>
				<p>Start customizing with Mission News Pro today</p>
				<a href="<?php echo $pro_url; ?>" target="_blank">View Mission News Pro</a>
			</div>
			<?php endif; ?>
		</div>
		<div class="sidebar">
			<div class="dashboard-widget">
				<h4>More Amazing Resources</h4>
				<ul>
					<li><a href="https://www.competethemes.com/documentation/mission-news-support-center/" target="_blank">Mission News Support Center</a></li>
					<li><a href="https://wordpress.org/support/theme/mission-news/" target="_blank">Support Forum</a></li>
					<li><a href="https://www.competethemes.com/help/mission-news-changelog/" target="_blank">Changelog</a></li>
					<li><a href="https://www.competethemes.com/help/mission-news-css-snippets/" target="_blank">CSS Snippets</a></li>
					<li><a href="https://www.competethemes.com/help/child-theme-mission-news/" target="_blank">Starter child theme</a></li>
					<li><a href="https://www.competethemes.com/help/mission-news-demo-data/" target="_blank">Mission News demo data</a></li>
					<li><a href="<?php echo $pro_url; ?>" target="_blank">Mission News Pro</a></li>
				</ul>
			</div>
			<div class="dashboard-widget">
				<h4>User Reviews</h4>
				<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/reviews.png'; ?>" />
				<p>Users are loving Mission News! <a href="https://wordpress.org/support/theme/mission-news/reviews/?filter=5#new-post" target="_blank">Click here</a> to leave your own review</p>
			</div>
			<div class="dashboard-widget">
				<h4>Reset Customizer Settings</h4>
				<p><b>Warning:</b> Clicking this button will erase the Mission News theme's current settings in the Customizer.</p>
				<form method="post">
					<input type="hidden" name="ct_mission_news_reset_customizer" value="ct_mission_news_reset_customizer_settings"/>
					<p>
						<?php wp_nonce_field( 'ct_mission_news_reset_customizer_nonce', 'ct_mission_news_reset_customizer_nonce' ); ?>
						<?php submit_button( 'Reset Customizer Settings', 'delete', 'delete', false ); ?>
					</p>
				</form>
			</div>
		</div>
		<?php do_action( 'ct_mission_news_theme_options_after' ); ?>
	</div>
<?php }