<?php do_action( 'ct_mission_main_bottom' ); ?>
</section> <!-- .main -->
<?php get_sidebar( 'primary' ); ?>
<?php do_action( 'ct_mission_after_main' ); ?>

<footer id="site-footer" class="site-footer" role="contentinfo">
    <?php do_action( 'ct_mission_footer_top' ); ?>
    <div class="design-credit">
        <span>
            <?php
            $footer_text = sprintf( __( '<a href="%s">Mission News Theme</a> by Compete Themes.', 'mission' ), 'https://www.competethemes.com/mission/' );
            $footer_text = apply_filters( 'ct_ct_mission_footer_text', $footer_text );
            echo wp_kses_post( $footer_text );
            ?>
        </span>
    </div>
</footer>
</div><!-- .max-width -->
</div><!-- .overflow-container -->

<?php do_action( 'ct_mission_body_bottom' ); ?>

<?php wp_footer(); ?>

</body>
</html>