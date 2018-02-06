<?php
// translators: The label of the "Back" link in primary navigation
$backLabel = esc_html__( 'Back', 'mission-news' );
?>
<div class="dropdown-navigation"><a id="back-button" class="back-button" href="#"><i class="fa fa-angle-left"></i> <?php echo $backLabel ?></a><span class="label"></span></div>
<div id="menu-primary" class="menu-container menu-primary" role="navigation">
    <?php wp_nav_menu(
        array(
            'theme_location'  => 'primary',
            'container'       => 'nav',
            'container_class' => 'menu',
            'menu_class'      => 'menu-primary-items',
            'menu_id'         => 'menu-primary-items',
            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'fallback_cb'     => 'ct_mission_news_wp_page_menu',
        ) ); ?>
</div>
