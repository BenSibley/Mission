<?php
// Get layout set in Customizer and override if post has its own layout selected via meta box
$layout_post = apply_filters( 'ct_mission_news_layout_filter', get_theme_mod( 'layout_posts' ) );
$layout_page = apply_filters( 'ct_mission_news_layout_filter', get_theme_mod( 'layout_pages' ) );
$layout_archives = get_theme_mod( 'layout_archives' );
$layout_blog = get_theme_mod( 'layout_blog' );
$layout_bbpress = get_theme_mod( 'layout_bbpress' );
$layout_woocommerce = get_theme_mod( 'layout_woocommerce' );
$layout_woocommerce_cat = get_theme_mod( 'layout_woocommerce_cat' );

if ( !function_exists('is_bbpress') ) {
    function is_bbpress() {
        return false;
    }
}
if ( !function_exists('is_product') ) {
    function is_product() {
        return false;
    }
    function is_product_category() {
        return false;
    }
}
if (
    // Posts 
    (is_singular('post') && ($layout_post == 'right-sidebar' || $layout_post == 'right-sidebar-wide' || $layout_post == 'no-sidebar' || $layout_post == 'no-sidebar-wide') && !is_bbpress())
    // Pages
    || (is_singular('page') && ($layout_page == 'right-sidebar' || $layout_page == 'right-sidebar-wide' || $layout_page == 'no-sidebar' || $layout_page == 'no-sidebar-wide') && !is_bbpress())
    // Archives
    || (is_archive() && ($layout_archives == 'right-sidebar' || $layout_archives == 'right-sidebar-wide' || $layout_archives == 'no-sidebar' || $layout_archives == 'no-sidebar-wide') && !is_bbpress())
    // Blog
    || (is_home() && ($layout_blog == 'right-sidebar' || $layout_blog == 'right-sidebar-wide' || $layout_blog == 'no-sidebar' || $layout_blog == 'no-sidebar-wide'))
    // bbPress
    || (is_bbpress() && ($layout_bbpress == 'right-sidebar' || $layout_bbpress == 'right-sidebar-wide' || $layout_bbpress == 'no-sidebar' || $layout_bbpress == 'no-sidebar-wide'))
    // WooCommerce - Product
    || (is_product() && ($layout_woocommerce == 'right-sidebar' || $layout_woocommerce == 'right-sidebar-wide' || $layout_woocommerce == 'no-sidebar' || $layout_woocommerce == 'no-sidebar-wide'))
    // WooCommerce - Category
    || (is_product_category() && ($layout_woocommerce_cat == 'right-sidebar' || $layout_woocommerce_cat == 'right-sidebar-wide' || $layout_woocommerce_cat == 'no-sidebar' || $layout_woocommerce_cat == 'no-sidebar-wide'))
    ) {
        return;
}
if ( function_exists( 'is_woocommerce' ) ) {
    if ( is_cart() || is_checkout() || is_account_page() ) {
        return;
    }
}
if ( is_active_sidebar( 'left' ) ) : ?>
    <aside class="sidebar sidebar-left" id="sidebar-left" role="complementary">
        <div class="inner">
            <?php dynamic_sidebar( 'left' ); ?>
        </div>
    </aside>
<?php endif;