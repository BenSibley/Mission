<?php
// Get layout set in Customizer and override if post has its own layout selected via meta box
$layout_post = apply_filters( 'ct_mission_news_layout_filter', get_theme_mod( 'layout_posts' ) );
$layout_page = apply_filters( 'ct_mission_news_layout_filter', get_theme_mod( 'layout_pages' ) );
if ( 
    (is_singular( 'post' ) && ( strpos($layout_post, 'right') !== false || strpos($layout_post, 'no-sidebar' ) !== false ) )
    || (is_singular( 'page' ) && ( strpos($layout_page, 'right') !== false || strpos($layout_page, 'no-sidebar') !== false ))
    ){
    return;
}
if ( is_active_sidebar( 'left' ) ) : ?>
    <aside class="sidebar sidebar-left" id="sidebar-left" role="complementary">
        <div class="inner">
            <?php dynamic_sidebar( 'left' ); ?>
        </div>
    </aside>
<?php endif;