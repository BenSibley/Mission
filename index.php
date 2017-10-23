<?php get_header();

get_template_part( 'content/archive-header' ); ?>

<div id="loop-container" class="loop-container">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            ct_mission_news_get_content_template();
        endwhile;
    endif;
    ?>
</div>

<?php // Output pagination if Jetpack not installed, otherwise check if infinite scroll is active before outputting
if ( !class_exists( 'Jetpack' ) ) {
    the_posts_pagination( array(
        'mid_size' => 1
    ) );
} elseif ( !Jetpack::is_module_active( 'infinite-scroll' ) ) {
    the_posts_pagination( array(
        'mid_size' => 1
    ) );
}

get_footer();