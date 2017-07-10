<?php
/* If a post password is required or no comments are given and comments/pings are closed, return. */
if ( post_password_required() || ( ! have_comments() && ! comments_open() && ! pings_open() ) ) {
    return;
}

if ( comments_open() ) { ?>
    <section id="comments" class="comments">
        <ol class="comment-list">
            <?php wp_list_comments( array( 'callback' => 'ct_startup_blog_customize_comments' ) ); ?>
        </ol>
        <?php
        if ( ( get_option( 'page_comments' ) == 1 ) && ( get_comment_pages_count() > 1 ) ) { ?>
            <nav class="comment-pagination">
                <p class="previous-comment"><?php previous_comments_link(); ?></p>
                <p class="next-comment"><?php next_comments_link(); ?></p>
            </nav>
        <?php } ?>
        <?php comment_form(); ?>
    </section>
    <?php
} elseif ( ! comments_open() && have_comments() && pings_open() ) { ?>
    <section id="comments" class="comments">
        <ol class="comment-list">
            <?php wp_list_comments( array( 'callback' => 'ct_startup_blog_customize_comments' ) ); ?>
        </ol>
        <?php
        if ( ( get_option( 'page_comments' ) == 1 ) && ( get_comment_pages_count() > 1 ) ) { ?>
            <nav class="comment-pagination">
                <p class="previous-comment"><?php previous_comments_link(); ?></p>
                <p class="next-comment"><?php next_comments_link(); ?></p>
            </nav>
        <?php } ?>
        <p class="comments-closed pings-open">
            <?php
            // translators: placeholder is link to the trackback URL
            printf( esc_html__( 'Comments are closed, but <a href="%s" title="Trackback URL for this post">trackbacks</a> and pingbacks are open.', 'ct-theme-name' ), esc_url( get_trackback_url() ) );
            ?>
        </p>
    </section>
    <?php
} elseif ( ! comments_open() && have_comments() ) { ?>
    <section id="comments" class="comments">
        <ol class="comment-list">
            <?php wp_list_comments( array( 'callback' => 'ct_startup_blog_customize_comments' ) ); ?>
        </ol>
        <?php
        if ( ( get_option( 'page_comments' ) == 1 ) && ( get_comment_pages_count() > 1 ) ) { ?>
            <nav class="comment-pagination">
                <p class="previous-comment"><?php previous_comments_link(); ?></p>
                <p class="next-comment"><?php next_comments_link(); ?></p>
            </nav>
        <?php } ?>
        <p class="comments-closed">
            <?php esc_html_e( 'Comments are closed.', 'ct-theme-name' ); ?>
        </p>
    </section>
    <?php
} else { ?>
    <section id="comments" class="comments">
        <p class="comments-closed">
            <?php esc_html_e( 'Comments are closed.', 'ct-theme-name' ); ?>
        </p>
    </section>
<?php }