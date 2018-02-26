<?php do_action( 'ct_mission_news_main_bottom' ); ?>
</section> <!-- .main -->
<?php do_action( 'ct_mission_news_after_main' ); ?>
<?php get_sidebar( 'right' ); ?>
</div><!-- layout-container -->
</div><!-- content-container -->

<footer id="site-footer" class="site-footer" role="contentinfo">
    <?php do_action( 'ct_mission_news_footer_top' ); ?>
    <div class="footer-title-container">
        <?php get_template_part( 'logo' ) ?>
        <?php if ( get_bloginfo( 'description' ) && get_theme_mod( 'tagline_footer' ) != 'no' ) {
            echo '<p class="footer-tagline">' . esc_html( get_bloginfo( 'description' ) ) . '</p>';
        } ?>
        <?php ct_mission_news_social_icons_output( 'footer' ); ?>
    </div>
    <?php get_sidebar( 'site-footer' ); ?>
    <div class="design-credit">
        <span>
            <?php
            // Translators: %s is the URL of the theme
            $footer_text = sprintf( __( '<a href="%s">Mission News Theme</a> by Compete Themes.', 'mission-news' ), 'https://www.competethemes.com/mission-news/' );
            $footer_text = apply_filters( 'ct_mission_news_footer_text', $footer_text );
            echo wp_kses_post( $footer_text );
            ?>
        </span>
    </div>
    <?php do_action( 'ct_mission_news_footer_bottom' ); ?>
</footer>
</div><!-- .max-width -->
</div><!-- .overflow-container -->

<?php do_action( 'ct_mission_news_body_bottom' ); ?>

<?php wp_footer(); ?>

</body>
</html>