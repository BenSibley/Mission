<?php get_header(); ?>
    <div class="archive-header search-box">
        <h1>
            <?php
            // Translators: %s is the search query
            printf( esc_html__( 'Search Results for %s', 'mission' ), '<span>&ldquo;' . get_search_query() . '&rdquo;</span>' );
            ?>
        </h1>
        <?php get_search_form(); ?>
    </div>
    <div id="loop-container" class="loop-container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                ct_mission_get_content_template();
            endwhile;
        endif;
        ?>
    </div>

<?php the_posts_pagination(); ?>

    <div class="search-box bottom">
    <p><?php esc_html_e( "Can't find what you're looking for?  Try refining your search:", "mission" ); ?></p>
    <?php get_search_form(); ?>
</div>

<?php get_footer();