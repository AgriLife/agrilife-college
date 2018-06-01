<?php
namespace AgriLife\College;

class RequiredDOM {

    public function __construct() {

        // Alter header title
        add_filter( 'genesis_seo_title', array( $this, 'seo_title' ), 10, 3 );

        add_filter( 'genesis_seo_title', array( $this, 'display_search' ), 11, 3 );

        // Identify post category pages with a custom body class name.
        add_filter( 'body_class', array( $this, 'agriflex_body_class' ) );

        // Modifies post content by removing footer and formatting date information.
        add_filter( 'genesis_post_info', array( $this, 'agriflex_post_date_filter' ) );

        // Prevents "Filed Under" meta from appearing on post list page.
        add_filter( 'genesis_post_meta', array( $this, 'agriflex_post_footer_filter' ) );

        // Replace h1 tags with h2 on the main post list page, because Genesis.
        add_filter( 'genesis_post_title_output', array( $this, 'agriflex_post_title_filter' ) );

        // Custom DOM for primary site on multisite
        $networkurl = network_site_url();
        $siteurl = site_url() . '/';

        if( $networkurl === $siteurl && strpos($siteurl, 'biochemistry') === false){

            add_filter( 'body_class', array( $this, 'aglifesciences_header_links_class' ) );

            add_action( 'genesis_header_right', array( $this, 'aglifesciences_header_links' ) );

        }

        // Remove Site Description
        //remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

        // Add Extension Body Class
        //add_filter( 'body_class', array( $this, 'ext_body_class') );

        // Add Page Slug to Body Class
        //add_filter( 'body_class', array( $this, 'slug_body_class') );

        // Render the footer
        //add_action( 'genesis_header', array($this, 'add_extension_footer_content') ) ;

        // Remove search from navigation
        //add_action( 'genesis_header', array($this, 'remove_search') ) ;

        // Move tagline below navigation
        //add_action('genesis_header',array($this, 'move_tagline') );

    }

    /**
     * Modifies the header title
     *
     * @param $title The title text
     * @param $inside
     * @param $wrap
     *
     * @return string
     */
    public function seo_title( $title, $inside, $wrap ) {

        $title = '<div class="college-title">
                            <a href="http://aglifesciences.tamu.edu/"><span>Texas A&amp;M College of Agriculture and Life Sciences</span></a>
                        </div>';

        $networkurl = parse_url(network_site_url());

        if( get_current_blog_id() !== 1 || $networkurl['host'] !== 'aglifesciences.tamu.edu' ){

            $inside = sprintf( '<a href="%s" title="%s"><span>%s</span></a>',
                esc_attr( get_bloginfo('url') ),
                esc_attr( get_bloginfo('name') ),
                get_bloginfo( 'name' ) );

            $title .= sprintf( '<%s class="site-title" itemprop="headline">%s</%s>',
                $wrap,
                $inside,
                $wrap
            );

        }

        return $title;
    }


    /**
     * Moves the tagline
     *
     * @return void
     */
    public function move_tagline() {

        remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
        add_action('genesis_after_header','genesis_seo_site_description');

    }

    /**
     * Add and Extension body class
     *
     * @param $classes The existing body classes
     *
     * @return string
     */
    public function ext_body_class( $classes ) {

        $classes[] = 'college-site';
        return $classes;

    }

    /**
     * Add page slug and category to body class
     *
     * @param $classes The existing body classes
     *
     * @return string
     */
    public function slug_body_class( $classes ) {

        global $post;

        if ( isset( $post ) ) {
            $classes[] = $post->post_type . '-' . $post->post_name;

            $parent = get_page($post->post_parent);
            $classes[] = $parent->post_type . '-parent-' . $parent->post_name;
        }

        return $classes;

    }

    /**
     * Add extension info to bottom of page
     * @since 1.0
     * @return void
     */
    public function add_extension_footer_content()
    {
        remove_all_actions('genesis_footer');
        add_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
        add_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

        add_action('genesis_footer', array($this, 'render_ext_logo'));
        add_action('genesis_footer', array($this, 'render_tamus_logo'));
        add_action('genesis_footer', array($this, 'render_footer_widgets'));
        add_action('genesis_footer', array($this, 'render_required_links'));
    }

    /**
     * Render Extension logo
     * @since 1.0
     * @return string
     */
    public function render_ext_logo()
    {

        $output = '
            <div class="footer-container-ext">
                <a href="http://agrilifeextension.tamu.edu/" title="Texas A&M AgriLife Extension Service"><img class="footer-ext-logo" src="'.AG_EXT_DIR_URL.'/img/logo-ext.png" title="Texas A&M AgriLife Extension Service" alt="Texas A&M AgriLife Extension Service" /><noscript><img src="'.AF_THEME_DIRURL.'/img/footer-tamus-maroon.png" title="Texas A&M University System Member" alt="Texas A&M University System Member" /></noscript></a>
            </div>';

        echo $output;

    }

    /**
     * Render the widgets in the footer
     * @since 1.0
     * @return void
     */
    public function render_footer_widgets() {

        if ( is_active_sidebar( 'footer-center' ) ) : ?>
            <div id="footer-center-widgets" class="footer-center widget-area" role="complementary">
                <?php dynamic_sidebar( 'footer-center' ); ?>
            </div><!-- #footer-center-widgets -->
        <?php endif;

    }

    /**
     * Remove search from navigation
     * @return void
     */
    public function remove_search() {

        global $wp_filter;
        remove_all_filters( 'agriflex_nav_elements', 11);

    }

    /**
     * Render search field
     * @since 1.0
     * @return string
     */
    public function display_search($output) {

        $output .= sprintf( '<div class="primary-search">%s</div>',
            get_search_form( false )
        );
        return $output;

    }

    /**
     * Identify post category pages with a custom body class name.
     * @since 1.0
     * @return string
     */
    public function agriflex_body_class( $classes ) {
        if ( !is_page() && !is_single() ) {
            $classes[] = 'posts';
        }
        return $classes;
    }

    /**
     * Add body class for header secondary menu
     * @since 1.0.7
     * @return string
     */
    public function aglifesciences_header_links_class( $classes ){

        $tslug = get_page_template_slug();
        $template = array('page.php');

        if(!empty($tslug)){

            preg_match( '/[\w\d\-]+\.php$/', $tslug, $template );

        }

        if( $template[0] != 'landing-aglifesciences.php' ){

            $classes[] = 'mainsite-internalpage';

        }

        return $classes;

    }

    /**
     * Add header secondary menu for common demographics
     * @since 1.0.7
     * @return string
     */
    public function aglifesciences_header_links(){

        $tslug = get_page_template_slug();
        $template = array('page.php');

        if(!empty($tslug)){

            preg_match( '/[\w\d\-]+\.php$/', $tslug, $template );

        }

        if( $template[0] != 'landing-aglifesciences.php' ){

        ?>
    <div class="menu-secondary">
        <ul id="menu-secondary" class="secondary-nav"><li class="menu-item"><a href="http://aglifesciences.tamu.edu/future-students/">Future Students</a></li><li class="menu-item"><a href="http://aglifesciences.tamu.edu/students/">Current Students</a></li><li class="menu-item"><a href="http://aglifesciences.tamu.edu/former-students/">Former Students</a></li><li class="menu-item"><a href="http://aglifesciences.tamu.edu/faculty-staff/">Faculty and Staff</a></li></ul>
    </div>
        <?php

        }
    }

    /**
     * Replace h1 tags with h2 on the main post list page, because Genesis.
     * @since 1.0
     * @return string
     */
    public function agriflex_post_title_filter( $post_title ) {
        if ( !is_page() && !is_single() ) {
            $post_title = str_replace("<h1", "<h2", $post_title);
            $post_title = str_replace("/h1>", "/h2>", $post_title);
        }
        return $post_title;
    }

    /**
     * Modifies post content by removing footer and formatting date information.
     * @since 1.0
     * @return string
     */
    public function agriflex_post_date_filter( $post_info ) {
        if (!is_page() && !is_single()) {
            $wrap = array('<time class="entry-date" datetime="' . esc_attr( get_the_date( 'c' ) ) . '" itemprop="datePublished">', '</time>');
            $day = '<span class="day">' . esc_html( get_the_date( 'j' ) ) . '</span>';
            $month = '<span class="month">' . esc_html( get_the_date( 'M' ) ) . '</span>';
            $post_info = $wrap[0] . $day . $month . $wrap[1];
        }
        return $post_info;
    }

    /**
     * Prevents "Filed Under" meta from appearing on post list page.
     * @since 1.0
     * @return string
     */
    public function agriflex_post_footer_filter( $post_footer ) {
        if ( !is_page() && !is_single() ) {
          $post_footer = '';
        }
        return $post_footer;
    }

    /**
     * Render TAMUS logo
     * @todo refactor this, repeated functionality
     * @since 1.0
     * @return string
     */
    public static function render_tamus_logo()
    {

        $output = '
            <div class="footer-container-tamus">
                <a href="http://tamus.edu/" title="Texas A&amp;M University System"><img class="footer-tamus" src="'.AG_EXT_DIR_URL.'/img/logo-tamus.png" title="Texas A&amp;M University System Member" alt="Texas A&amp;M University System Member" />
                <noscript><img src="'.AF_THEME_DIRURL.'/img/footer-tamus-maroon.png" title="Texas A&amp;M University System Member" alt="Texas A&amp;M University System Member" /></noscript></a>
            </div>';

        echo $output;

    }

    /**
     * Render required links
     * @todo refactor this, repeated functionality
     * @since 1.0
     * @return string
     */
    public static function render_required_links()
    {

        $output = '
            <div class="footer-container-required">
                <ul class="req-links">
                    <li><a href="http://agrilife.org/required-links/compact/">Compact with Texans</a></li>
                    <li><a href="http://agrilife.org/required-links/privacy/">Privacy and Security</a></li>
                    <li><a href="http://itaccessibility.tamu.edu/" target="_blank">Accessibility Policy</a></li>
                    <li><a href="http://publishingext.dir.texas.gov/portal/internal/resources/DocumentLibrary/State%20Website%20Linking%20and%20Privacy%20Policy.pdf" target="_blank">State Link Policy</a></li>
                    <li><a href="http://www.tsl.state.tx.us/trail" target="_blank">Statewide Search</a></li>
                    <li><a href="http://www.tamus.edu/veterans/" target="_blank">Veterans Benefits</a></li>
                    <li><a href="http://fcs.tamu.edu/families/military_families/" target="_blank">Military Families</a></li>
                    <li><a href="https://secure.ethicspoint.com/domain/en/report_custom.asp?clientid=19681" target="_blank">Risk, Fraud &amp; Misconduct Hotline</a></li>
                    <li><a href="https://gov.texas.gov/organization/hsgd" target="_blank">Texas Homeland Security</a></li>
                    <li><a href="http://veterans.portal.texas.gov/">Texas Veteran&apos;s Portal</a></li>
                    <li><a href="http://agrilifeas.tamu.edu/hr/diversity/equal-opportunity-educational-programs/" target="_blank">Equal Opportunity</a></li>
                    <li class="last"><a href="http://agrilife.org/required-links/orpi/">Open Records/Public Information</a></li>
                </ul>
            </div>';

        echo $output;

    }

}
