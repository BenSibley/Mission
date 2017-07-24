<?php if ( is_active_sidebar( 'left' ) ) : ?>
    <aside class="sidebar sidebar-left" id="sidebar-left" role="complementary">
        <div class="inner">
            <?php dynamic_sidebar( 'left' ); ?>
        </div>
    </aside>
<?php endif;