<?php get_header(); ?>
    <div class="post-header search-header">
        <h1 class="post-title">
            <?php printf( esc_html__( 'Search Results for %s', 'ct_theme_name' ), '<span>&ldquo;' . get_search_query() . '&rdquo;</span>' ); ?>
        </h1>
        <?php get_search_form(); ?>
    </div>
    <div id="loop-container" class="loop-container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                get_template_part( 'content-archive', get_post_type() );
            endwhile;
        endif;
        ?>
    </div>

<?php the_posts_pagination(); ?>

    <div class="search-bottom">
    <p><?php esc_html_e( "Can't find what you're looking for?  Try refining your search:", "ct_theme_name" ); ?></p>
    <?php get_search_form(); ?>
</div>

<?php get_footer();