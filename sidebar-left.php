<?php
// Get layout set in Customizer and override if post has its own layout selected via meta box
$layout = apply_filters( 'ct_mission_news_layout_filter', get_theme_mod( 'layout_posts' ) );
if ( is_singular( 'post' ) && ( $layout == 'right-sidebar' || $layout == 'no-sidebar' ) ) {
    return;
}
if ( is_active_sidebar( 'left' ) ) : ?>
    <aside class="sidebar sidebar-left" id="sidebar-left" role="complementary">
        <div class="inner">
            <?php dynamic_sidebar( 'left' ); ?>
        </div>
    </aside>
<?php endif;