<?php get_header(); ?>
    <div class="archive-header search-box">
        <h1>
            <?php
            global $wp_query;
            $total_results = $wp_query->found_posts;
            if ( $total_results ) {
                // translators: %1$s = number of results. %2$s = search query
                printf( esc_html( _n( '%1$s search result for %2$s', '%1$s search results for %2$s', absint( $total_results ), 'mission-news' ) ), $total_results, '&ldquo;' . get_search_query() . '&rdquo;' );
            } else {
                // translators: %s = search query
                printf( esc_html__( 'No search results for "%s"', 'mission-news' ), get_search_query() );
            }
            ?>
        </h1>
        <?php get_search_form(); ?>
    </div>
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

<?php the_posts_pagination();

// No need to output two search forms if no results
if ( $total_results ) { ?>
    <div class="search-box bottom">
        <p><?php esc_html_e( "Can't find what you're looking for?  Try refining your search:", "mission-news" ); ?></p>
        <?php get_search_form(); ?>
    </div>
<?php }

get_footer();