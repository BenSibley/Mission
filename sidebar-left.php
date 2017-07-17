<?php if ( is_active_sidebar( 'left' ) ) : ?>
    <aside class="sidebar sidebar-left" id="sidebar-left" role="complementary">
        <?php dynamic_sidebar( 'left' ); ?>
    </aside>
<?php endif;