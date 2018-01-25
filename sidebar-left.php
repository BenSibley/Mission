<?php
// Get layout set in Customizer and override if post has its own layout selected via meta box
$layout_post = apply_filters( 'ct_mission_news_layout_filter', get_theme_mod( 'layout_posts' ) );
$layout_page = apply_filters( 'ct_mission_news_layout_filter', get_theme_mod( 'layout_pages' ) );
$layout_archives = get_theme_mod( 'layout_archives' );
$layout_blog = get_theme_mod( 'layout_blog' );

if (
    // Posts 
    (is_singular('post') && ($layout_post == 'right-sidebar' || $layout_post == 'right-sidebar-wide' || $layout_post == 'no-sidebar' || $layout_post == 'no-sidebar-wide'))
    // Pages
    || (is_singular('page') && ($layout_page == 'right-sidebar' || $layout_page == 'right-sidebar-wide' || $layout_page == 'no-sidebar' || $layout_page == 'no-sidebar-wide'))
    // Archives
    || (is_archive() && ($layout_archives == 'right-sidebar' || $layout_archives == 'right-sidebar-wide' || $layout_archives == 'no-sidebar' || $layout_archives == 'no-sidebar-wide'))
    // Blog
    || (is_home() && ($layout_blog == 'right-sidebar' || $layout_blog == 'right-sidebar-wide' || $layout_blog == 'no-sidebar' || $layout_blog == 'no-sidebar-wide'))
    ) {
        return;
}
if ( is_active_sidebar( 'left' ) ) : ?>
    <aside class="sidebar sidebar-left" id="sidebar-left" role="complementary">
        <div class="inner">
            <?php dynamic_sidebar( 'left' ); ?>
        </div>
    </aside>
<?php endif;