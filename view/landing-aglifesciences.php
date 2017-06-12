<?php
/**
 * Template Name: aglifesciences
 */

// Remove post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

// Remove title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

add_action( 'genesis_header_right', 'aglifesciences_header_links' );

add_action( 'genesis_entry_content', 'aglifesciences_home_top' );

add_action( 'genesis_entry_content', 'aglifesciences_home_content' );

add_action( 'genesis_entry_footer', 'aglifesciences_home_programs' );

if ( get_theme_mod('agriflex_background_image') == '' ) {
    add_action( 'genesis_after', 'aglifesciences_background_image' );
}

add_action( 'wp_enqueue_scripts', 'register_template_scripts' );

add_action( 'wp_enqueue_scripts', 'enqueue_template_scripts' );

add_action( 'wp_enqueue_scripts', 'register_template_styles' );

add_action( 'wp_enqueue_scripts', 'enqueue_template_styles' );

function aglifesciences_header_links(){
    ?>
    <div class="menu-secondary">
        <ul id="menu-secondary" class="secondary-nav"><li class="menu-item"><a href="http://aglifesciences.tamu.edu/future-students/">Future Students</a></li><li class="menu-item"><a href="http://aglifesciences.tamu.edu/students/">Current Students</a></li><li class="menu-item"><a href="http://aglifesciences.tamu.edu/former-students/">Former Students</a></li><li class="menu-item"><a href="http://aglifesciences.tamu.edu/faculty-staff/">Faculty and Staff</a></li></ul>
    </div>
    <?php
}

function register_template_scripts(){
    wp_register_script( 'fittext',
        AG_COL_DIR_URL . 'js/jquery.fittext.js',
        array( 'jquery' ),
        false,
        true
    );
    wp_register_script( 'college_scripts',
        AG_COL_DIR_URL . 'js/college_scripts.js',
        array( 'jquery' ),
        false,
        true
    );
}

function enqueue_template_scripts(){
    wp_enqueue_script( 'fittext' );
    wp_enqueue_script( 'college_scripts' );
}

/**
 * Registers all styles used within the template
 */
function register_template_styles(){
    wp_register_style(
        'template-aglifesciences',
        AF_THEME_DIRURL . '/css/college-template-aglifesciences.css',
        array(),
        '',
        'screen'
    );
}

function enqueue_template_styles(){
    wp_enqueue_style( 'template-aglifesciences' );
}


function aglifesciences_home_top()
{
    if ( get_field( 'show_slider' ) ) {

        load_template( dirname( __FILE__ ) . '/landing-aglifesciences-top.php');

    }
}

function aglifesciences_home_content()
{
    ?>
    <div class="home-content">
        <section id="content" role="main">
            <?php
            if ( get_field( 'welcome_text' ) ) {
                load_template( dirname( __FILE__ ) . '/landing-aglifesciences-welcome.php');
            }

            load_template( dirname( __FILE__ ) . '/landing-aglifesciences-main.php');
            ?>

        </section><!-- /end #content -->

        <section id="aside" role="main">
            <?php if ( ! dynamic_sidebar( 'home_right_1' ) ) : ?>


            <?php endif; ?>
        </section><!-- /end #content -->
    </div>
<?php
}

function aglifesciences_home_programs()
{
        if ( get_field( 'program_units' ) ) {
            load_template( dirname( __FILE__ ) . '/landing-aglifesciences-programs.php');
        }
}

function aglifesciences_background_image(){
    ?>
    <div id="bg-image-container"></div>
    <?php
}

genesis();
