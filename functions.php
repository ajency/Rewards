<?php

/**
 * Skyi functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link       http://codex.wordpress.org/Theme_Development
 * @link       http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link       http://codex.wordpress.org/Plugin_API
 *
 * @package    Ajency
 * @subpackage skyi
 * @since      Skyi 0.1
 */
require_once 'modules/menu/ajax.php';
require_once 'modules/users/ajax.php';
require_once 'modules/referrals/ajax.php';
require_once 'modules/Memebers/ajax.php';
require_once 'modules/referral_user/ajax.php';
require_once 'modules/customer/ajax.php';
require_once 'modules/Product/ajax.php';
require_once 'modules/Rewards/ajax.php';
require_once 'modules/redemption/ajax.php';
require_once 'modules/referrals/ajax.php';
require_once 'modules/referrallist/ajax.php';
require_once 'modules/shipping/ajax.php';
require_once 'modules/Options/ajax.php';
require_once 'modules/Inventory/ajax.php';
require_once 'modules/dashboard/ajax.php';
require_once 'modules/Pickup/ajax.php';
require_once 'modules/Import/ajax.php';

function set_last_login( $login ) {

    $user = get_userdatabylogin( $login );

    //add or update the last login value for logged in user
    update_usermeta( $user->ID, 'last_login', current_time( 'mysql' ) );
}

add_action( 'wp_login', 'set_last_login' );
if ( !function_exists( 'skyi_setup' ) ) :

    /**
     * skyi setup.
     *
     * Set up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support post thumbnails.
     *
     * @since skyi 0.1
     *
     */
    function skyi_setup() {

        /*
         * Make skyi available for translation. Translations can be added to the /languages/ directory. If you're building a theme based on Skyi, use a find and replace to change 'skyi' to the name of your theme in all template files.
         */
        load_theme_textdomain( 'Rewards', get_template_directory() . '/languages' );

        // Enable support for Post Thumbnails, and declare two sizes.
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 672, 372, TRUE );
        add_image_size( 'skyi-full-width', 1038, 576, TRUE );

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus( array(
            'primary'   => __( 'Top primary menu', 'skyi' ),
            'secondary' => __( 'Secondary menu in left sidebar', 'skyi' )
        ) );

        /*
         * Switch default core markup for search form, comment form, and comments to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list'
        ) );

        /*
         * Enable support for Post Formats. See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support( 'post-formats', array(
            'aside',
            'image',
            'video',
            'audio',
            'quote',
            'link',
            'gallery'
        ) );

        // This theme allows users to set a custom background.
        add_theme_support( 'custom-background', apply_filters( 'skyi_custom_background_args', array(
            'default-color' => 'f5f5f5'
        ) ) );

        // Add support for featured content.
        add_theme_support( 'featured-content', array(
            'featured_content_filter' => 'skyi_get_featured_posts',
            'max_posts'               => 6
        ) );

        // This theme uses its own gallery styles.
        add_filter( 'use_default_gallery_style', '__return_false' );
    }

endif; // skyi_setup
add_action( 'after_setup_theme', 'skyi_setup' );

/**
 * Hide admin bar
 */
show_admin_bar( FALSE );

/**
 * Enqueue styles for the front end.
 *
 * @since Skyi 0.1
 *
 * @return void
 */
function skyi_styles() {

    // // Load Framework
    wp_enqueue_style( 'skyi-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array() );
    wp_enqueue_style( 'skyi-bootstrap-theme', get_template_directory_uri() . '/css/bootstrap-theme.min.css', array() );
    wp_enqueue_style( 'skyi-fontawsome', get_template_directory_uri() . '/css/font-awesome.css', array() );
    // // Load Theme Style.
    wp_enqueue_style( 'skyi-pace-theme', get_template_directory_uri() . '/css/pace-theme-flash.css', array() );
    wp_enqueue_style( 'skyi-sidr-light', get_template_directory_uri() . '/css/jquery.sidr.light.css', array() );
    wp_enqueue_style( 'skyi-bootstrap-select', get_template_directory_uri() . '/css/select2.css', array() );
    //wp_enqueue_style('skyi-data-tables', get_template_directory_uri() . '/css/jquery.dataTables.css', array());
    wp_enqueue_style( 'skyi-checkbox', get_template_directory_uri() . '/css/bootstrap-checkbox.css', array() );
    wp_enqueue_style( 'skyi-data-tables-responsive', get_template_directory_uri() . '/css/datatables.responsive.css', array() );
    wp_enqueue_style( 'skyi-intl-tel-input', get_template_directory_uri() . '/css/intlTelInput.css', array() );

    wp_enqueue_style( 'skyi-style-css', get_template_directory_uri() . '/css/style.css', array() );
    wp_enqueue_style( 'skyi-reponsive', get_template_directory_uri() . '/css/responsive.css', array() );
    wp_enqueue_style( 'skyi-custom-icon', get_template_directory_uri() . '/css/custom-icon-set.css', array() );
    wp_enqueue_style( 'skyi-custom-css', get_template_directory_uri() . '/css/custom.css', array() );

    // Load our main stylesheet.
    wp_enqueue_style( 'skyi-style', get_stylesheet_uri(), array() );


    // Load the Internet Explorer specific stylesheet. un comment if required
    // wp_enqueue_style( 'skyi-ie', get_template_directory_uri() . '/css/ie.css', array( 'skyi-style', 'genericons' ), '20131205' );
    // wp_style_add_data( 'skyi-ie', 'conditional', 'lt IE 9' );
}

add_action( 'wp_enqueue_scripts', 'skyi_styles' );

/**
 * Check the development envirionment
 * a global is set in wp-config.php [define('ENV', 'development||production)]
 * @return boolean
 */
function is_development() {

    $env = get_environment();

    return $env === 'development';
}

/**
 * get the current developement environment
 * @return string
 */
function get_environment() {

    // default is development. if ENV is not set return 'development'
    if ( !defined( 'ENV' ) )
        return 'development';

    return ENV;
}

/**
 * Get the slug of the currently opened page
 * @return string
 */
function get_current_page_slug() {

    $post = get_post( get_the_ID() );

    return $post->post_name;
}

/**
 * Get the JS version. Used to disable cached file on browser
 * The value is set in wp-config
 * @return string version number
 */
function get_js_version() {

    if ( !defined( 'JSVERSION' ) )
        $version = '1.0';
    else
        $version = JSVERSION;

    return $version;
}

/**
 * Add extra classes to body tag
 *
 * @param unknown $classes
 * @param unknown $class
 *
 * @return string
 */
function append_body_classes( $classes, $class ) {

    // add extra classes


    $classes[ ] = 'breakpoint-1024 pace-done';


    return $classes;
}

add_filter( 'body_class', 'append_body_classes', 10, 2 );

//fetch a list of roles///

function get_all_roles() {

    global $wp_roles;

    foreach ( $wp_roles->get_names() as $key => $value ) {


        if ( ( $value == "Administrator" ) || ( $value == "Rewards Manager" ) || ( $value == "Product Manager" ) ) {
            $user_role[ ] = array(
                'name' => $value,
                'id'   => $key
            );
        }

    }

    return $user_role;
}
function get_date(){
    
    global $wpdb;
    $customer  = $wpdb->prefix . "customer";
    
     $customer_date = $wpdb->get_row( "select * from $customer  order by date_of_import desc limit 1" );
     if($customer_date!=null){
         
         $customer_date = $customer_date->date_of_import;
     }
     else
     {
         $customer_date = '0000-00-00';
     }
     return $customer_date;
}
add_action( 'init', 'create_post_type' );

function create_post_type() {

    register_post_type( 'Products', array(
            'labels'             => array(
                'name'          => __( 'Products' ),
                'singular_name' => __( 'Product' )
            ),
            'public'             => TRUE,
            'has_archive'        => TRUE,
            'public'             => TRUE,
            'publicly_queryable' => TRUE,
            'show_ui'            => TRUE,
            'query_var'          => TRUE,
            'rewrite'            => TRUE,
            'capability_type'    => 'post',
            'hierarchical'       => FALSE,
            'supports'           => array( 'product_price', 'thumbnail' ),
            'taxonomies'         => array( 'Options' )
        )
    );

}


add_action( 'init', 'create_taxonomy_option', 0 );

function create_taxonomy_option() {

    // Project Categories
    register_taxonomy( 'Options', array( 'Products' ), array(
        'hierarchical'  => TRUE,
        'label'         => 'Option Categories',
        'singular_name' => 'Option Category',
        'show_ui'       => TRUE,
        'query_var'     => TRUE,
        'rewrite'       => array( 'slug' => 'options' )
    ) );
}

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );


function my_login_redirect() {

    $user_role = get_user_role();
    if ( $user_role != 'administrator' ) {

        $redirect_to = site_url() . '/dashboard';
    } else {
        $redirect_to = get_admin_url() . '/user';
    }

    return $redirect_to;
}


function my_login_logo() {

    ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/skyi-logoS-1.png);
            padding-bottom: 30px;
            margin-bottom: 15px;
            background-size: 67px 100px;

        }
    </style>
<?php
}

add_action( 'login_enqueue_scripts', 'my_login_logo' );


function cron_job_send_emails() {

    include( ABSPATH . "wp-content/themes/Rewards/modules/referrals/comm_module.php" );

}
add_filter('CRON_SCHEDULE_SEND_MAILS', 'cron_job_send_emails', 2, 0);
//add_filter('admin_init', 'cron_job_send_emails', 2, 0);






function cron_job2_send_mails(){

    //include( ABSPATH . "wp-content/themes/Rewards/modules/redemption/comm_module_redemption.php" );
    send_mail_redemption();

}
add_filter('CRON_SCHEDULE_SEND_MAILS2', 'cron_job2_send_mails', 3, 0);
//add_filter('admin_init', 'cron_job2_send_mails', 1, 0);


//suspend user////
function disable_suspended_user_login_hk($user_login, $user){

    disable_suspended_uer_login($user->ID);

}
add_action('wp_login', 'disable_suspended_user_login_hk',10,2);

function disable_suspended_uer_login($user_id){

    $user_status = get_user_suspended_status($user_id);

    if($user_status=='true'){
        wp_clear_auth_cookie();

        $redirect_url = get_login_url().'/?error=disabled';

        /*var_dump($redirect_url); */
        wp_redirect($redirect_url);
        exit();

    }

}


function get_user_suspended_status($user_id){

    $user_suspended_status = get_user_meta($user_id,'suspended_user',true);

    return $user_suspended_status;

}

function get_login_url(){
    //return wp_login_url();

    return site_url().'/wp-login.php';
}

function custom_login_msg (){

    if( (isset($_REQUEST['error'])) && ($_REQUEST['error']=="disabled") ){

        return  '<p class="message">The user account is disabled</p>';
    }

}
add_filter('login_message', 'custom_login_msg');

add_filter('wpmu_validate_user_signup', 'skip_email_exist');
function skip_email_exist($result){
    if(isset($result['errors']->errors['user_email']) && ($key = array_search(__('Sorry, that email address is already used!'), $result['errors']->errors['user_email'])) !== false) {
        unset($result['errors']->errors['user_email'][$key]);
        if (empty($result['errors']->errors['user_email'])) unset($result['errors']->errors['user_email']);
    }
    define( 'WP_IMPORTING', 'SKIP_EMAIL_EXIST' );
    return $result;
}
