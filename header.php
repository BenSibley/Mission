<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
	<?php wp_head(); ?>
</head>

<body id="<?php print get_stylesheet(); ?>" <?php body_class(); ?>>
<?php do_action( 'ct_theme_name_body_top' ); ?>
<a class="skip-content" href="#main"><?php esc_html_e( 'Press "Enter" to skip to content', 'ct-theme-name' ); ?></a>
<div id="overflow-container" class="overflow-container">
	<div id="max-width" class="max-width">
		<?php do_action( 'ct_theme_name_before_header' ); ?>
		<header class="site-header" id="site-header" role="banner">
			<div id="menu-primary-container" class="menu-primary-container">
				<?php get_template_part( 'menu', 'primary' ); ?>
				<?php get_template_part( 'content/search-bar' ); ?>
				<?php ct_ct_theme_name_social_icons_output(); ?>
			</div>
			<button id="toggle-navigation" class="toggle-navigation" name="toggle-navigation" aria-expanded="false">
				<span class="screen-reader-text"><?php esc_html_e( 'open menu', 'ct-theme-name' ); ?></span>
				<?php echo ct_ct_theme_name_svg_output( 'toggle-navigation' ); ?>
			</button>
			<div id="title-container" class="title-container">
				<?php get_template_part( 'logo' ) ?>
				<?php if ( get_bloginfo( 'description' ) ) {
					echo '<p class="tagline">' . esc_html( get_bloginfo( 'description' ) ) . '</p>';
				} ?>
			</div>
		</header>
		<?php do_action( 'ct_theme_name_after_header' ); ?>
		<section id="main" class="main" role="main">
			<?php do_action( 'ct_theme_name_main_top' );
			if ( function_exists( 'yoast_breadcrumb' ) ) {
				yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
			}
