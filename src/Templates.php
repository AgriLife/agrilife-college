<?php

namespace AgriLife\College;

class Templates {

    public function __construct() {

        add_filter( 'single_template', array( $this, 'get_single_template' ) );
        add_filter( 'single_template', array( $this, 'get_aglifesciences_template' ) );

    }


    /**
     * Shows the programs or solutions template when needed
     * @param  string $single_template The default single template
     * @return string                  The correct single template
     */
    public function get_single_template( $single_template ) {

        global $post;

        if ( is_page_template( 'view/landing1.php' ) ) {
            $single_template = AG_EXT_DIR_PATH . '/view/landing1.php';
        }

        return $single_template;

    }


    /**
     * Shows the programs or solutions template when needed
     * @param  string $single_template The default single template
     * @return string                  The correct single template
     */
    public function get_aglifesciences_template( $single_template ) {

        if ( is_page_template( 'view/landing-aglifesciences.php' ) ) {
            $single_template = AG_COL_DIR_PATH . '/view/landing-aglifesciences.php';
        }

        return $single_template;

    }

}