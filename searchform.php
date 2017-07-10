<div class='search-form-container'>
    <form role="search" method="get" class="search-form" action="<?php echo esc_url( get_home_url() ); ?>">
        <label class="screen-reader-text" for="search-field"><?php esc_html_e( 'Search', 'mission' ); ?></label>
        <input id="search-field" type="search" class="search-field" value="" name="s"
               title="<?php esc_attr_e( 'Search for:', 'mission' ); ?>" placeholder="<?php esc_attr_e( ' Search for...', 'mission' ); ?>" />
        <input type="submit" class="search-submit" value='<?php esc_attr_e( 'Search', 'mission' ); ?>'/>
    </form>
</div>