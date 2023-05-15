<?php
/**
 * Blue Haze Main Functions
 * 
 * ! adapted from Bootstrap Basic
 */


/**
 * Required WordPress variable.
 */
if (!isset($content_width)) {
    $content_width = 1170;
}


/**
 * Setup theme and register support wp features.
 */
if (!function_exists('bootstrapBasicSetup')) {
    function bootstrapBasicSetup() 
    {
        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         * 
         * copy from underscores theme
         */
        load_theme_textdomain('bootstrap-basic', get_template_directory() . '/languages');

        // add theme support title-tag
        add_theme_support('title-tag');

        // add theme support post and comment automatic feed links
        add_theme_support('automatic-feed-links');

        // enable support for post thumbnail or feature image on posts and pages
        add_theme_support('post-thumbnails');

        // allow the use of html5 markup
        // @link https://codex.wordpress.org/Theme_Markup
        add_theme_support('html5', array('caption', 'comment-form', 'comment-list', 'gallery', 'search-form'));

        // add support menu
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'bootstrap-basic'),
        ));


        // Add Post Format Support & Rename Default Formats
        add_theme_support('post-formats', array('aside', 'quote'));

        function rename_post_formats( $safe_text ) {
            if ( $safe_text == 'Quote' ) { return 'Barebones'; }
            if ( $safe_text == 'Aside' ) { return 'Blue Haze'; }
        
            return $safe_text;
        }
        add_filter( 'esc_html', 'rename_post_formats' );
        
        // Rename Aside in Posts List Table
        function live_rename_formats() { 
            global $current_screen;
        
            if ( $current_screen->id == 'edit-post' ) { ?>
                <script type="text/javascript">
                jQuery('document').ready(function() {
        
                    jQuery("span.post-state-format").each(function() { 
                        if ( jQuery(this).text() == "Quote" )
                            jQuery(this).text("Barebones");    
                        if ( jQuery(this).text() == "Aside" )
                            jQuery(this).text("Blue Haze");             
                    });
        
                });      
                </script>
        <?php }
        }
        add_action('admin_head', 'live_rename_formats');


        // add support for custom background
        add_theme_support(
            'custom-background', 
            apply_filters(
                'bootstrap_basic_custom_background_args', 
                array(
                    'default-color' => 'ffffff', 
                    'default-image' => ''
                )
            )
        );


        // GLOBAL DISABLE VISUAL EDITOR IF OPTION SELECTED
        $tinyMCE = myprefix_get_theme_option( 'visual_editor' );
        if ($tinyMCE != "") { 
            add_filter( 'user_can_richedit' , '__return_false', 50 );
        }


        // INCLUDE USER FUNCTIONS IF SUPPLIED
        if( is_multisite() ) {
            switch_to_blog(1);
            $upload_dir = wp_upload_dir();
            restore_current_blog();
        } else { $upload_dir = wp_upload_dir(); } 
        $bh_dir = $upload_dir['basedir'] . '/bluehaze';
        if (file_exists($bh_dir."/myFunctions.php")) { 
            include $bh_dir . "/myFunctions.php"; 
        }


    }
}
add_action('after_setup_theme', 'bootstrapBasicSetup');


if (!function_exists('bootstrapBasicWidgetsInit')) {
    /**
     * Register widget areas
     */
    function bootstrapBasicWidgetsInit() 
    {
        register_sidebar(array(
            'name' => __('Sidebar Right', 'bootstrap-basic'),
            'id' => 'sidebar-right',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));

        register_sidebar(array(
            'name' => __('Sidebar Left', 'bootstrap-basic'),
            'id' => 'sidebar-left',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));

        register_sidebar(array(
            'name' => __('Title Header Right', 'bootstrap-basic'),
            'id' => 'header-right',
            'description' => __('Header widget area on the right side next to site title.', 'bootstrap-basic'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));

        register_sidebar(array(
            'name' => __('Navigation Right', 'bootstrap-basic'),
            'id' => 'navbar-right',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => '',
        ));

        register_sidebar(array(
            'name' => __('Footer Full / Simple', 'bootstrap-basic'),
            'id' => 'footer-simple',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<strong>',
            'after_title' => '</strong>',
        ));

        register_sidebar(array(
            'name' => __('Footer Left', 'bootstrap-basic'),
            'id' => 'footer-left',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<strong>',
            'after_title' => '</strong>',
        ));

        register_sidebar(array(
            'name' => __('Footer Right', 'bootstrap-basic'),
            'id' => 'footer-right',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<strong>',
            'after_title' => '</strong>',
        ));
    }// bootstrapBasicWidgetsInit
}
add_action('widgets_init', 'bootstrapBasicWidgetsInit');


/**
 * BLUE HAZE OPTIONS
 */
require_once get_template_directory() . '/inc/BlueHazeOptions.php';


/**
 * ENQUEUE SCRIPTS AND STYLES START
 */

if (!function_exists('bootstrapBasicEnqueueScripts')) {
    function bootstrapBasicEnqueueScripts() 
    {
        global $wp_scripts;
        $Theme = wp_get_theme();
        $themeVersion = $Theme->get('Version');
        unset($Theme);

        // BLUE HAZE STYLE.CSS
        wp_enqueue_style('blue-haze-style', get_stylesheet_uri(), array(), $themeVersion);


        // * Determine if Local or Global Mode *
        $BHGlobal = myprefix_get_theme_option( 'global_mode' );
        if ($BHGlobal == "on") { 
            // BOOTSTRAP 3.4.1 GLOBAL STYLES
            wp_enqueue_style('bootstrap-style-global', 'https://cdn.jsdelivr.net/gh/twbs/bootstrap@3.4.1/dist/css/bootstrap.min.css', array(), '3.4.1');
            wp_enqueue_style('bootstrap-theme-global', 'https://cdn.jsdelivr.net/gh/twbs/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css', array(), '3.4.1');

            // ELITE STAR GLOBAL STYLESHEET
            // For Development, Temporarily Switch to the CS Version - the CDN Version will be Cached...
            //wp_enqueue_style('elite-star-development', 'https://cs.elite-star-services.com/common/css/ess.css', array(), $themeVersion);
            wp_enqueue_style('elite-star-global', 'https://cdn.jsdelivr.net/gh/EliteStarServices/common/css/ess.css', array(), $themeVersion);
        } else {
            // BOOTSTRAP 3.4.1 LOCAL STYLES
            wp_enqueue_style('bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.4.1');
            wp_enqueue_style('bootstrap-theme-style', get_template_directory_uri() . '/css/bootstrap-theme.min.css', array(), '3.4.1');

            // BLUE HAZE LOCAL STYLESHEET
            wp_enqueue_style('elite-star-local', get_template_directory_uri() . '/css/local.css', array(), $themeVersion);
        }


        // INCLUDE USER CSS FILE IF SET
        $UserCSS = myprefix_get_theme_option( 'user_css' );
        if ($UserCSS != "") { 
            wp_enqueue_style('site-specific', $UserCSS, array(), $themeVersion);
        }        


        // Font Awesome support is provided by BH Menu Icons once activated - if the plugin is not active load styles here
        // the Plugin 'Better Font Awesome' is also currently compatible in either state but Disqus needs 
        if (!class_exists('WPMI')) { 
            wp_enqueue_style('fontawesome-style', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.7.0');
        }


        // BOOTSTRAP GLOBAL MODE SCRIPT
        if ($BHGlobal == "on") {
        wp_enqueue_script('bootstrap-script-global', 'https://cdn.jsdelivr.net/gh/twbs/bootstrap@3.4.1/dist/js/bootstrap.min.js', array(), '3.4.1', true);
        // BOOTSTRAP LOCAL MODE SCRIPT
        } else {
        wp_enqueue_script('bootstrap-script', get_template_directory_uri() . '/js/vendor/bootstrap.min.js', array('jquery'), '3.4.1', true);
        }

        // I DON'T THINK THIS IS NEEDED ANYMORE
        //wp_enqueue_script('modernizr-script', get_template_directory_uri() . '/js/vendor/modernizr.min.js', array(), '3.6.0-20190314', true);

        // js that is loaded for old browsers - may not be needed
        wp_register_script('respond-script', get_template_directory_uri() . '/js/vendor/respond.min.js', array(), '1.4.2', true);
        $wp_scripts->add_data('respond-script', 'conditional', 'lt IE 9');
        wp_enqueue_script('respond-script');
        wp_register_script('html5-shiv-script', get_template_directory_uri() . '/js/vendor/html5shiv.min.js', array(), '3.7.3', true);
        $wp_scripts->add_data('html5-shiv-script', 'conditional', 'lte IE 9');
        wp_enqueue_script('html5-shiv-script');
        

        // WP Comments
        if (is_singular() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }        

        // JQuery Scripts ( https://wordpress.stackexchange.com/a/225936/41315 )
        $wp_scripts->add_data('jquery', 'group', 1);
        $wp_scripts->add_data('jquery-core', 'group', 1);
        $wp_scripts->add_data('jquery-migrate', 'group', 1);


        // DATATABLES SCRIPTS & STYLES (Elite Star Configuration)
        $DTSupport = myprefix_get_theme_option( 'data_tables' );
        if ($DTSupport == "on") {

            if ($BHGlobal == "on") { 
                // CS Version listed here - but all are static now so CDN Versions should be used unless they break
                //wp_enqueue_style('dataTables-bootstrap', 'https://cs.elite-star-services.com/common/css/dataTables.bootstrap.min.css', array(), $themeVersion);
                //wp_enqueue_script('required-jquery-version', 'https://cs.elite-star-services.com/common/js/jquery.min.js', array(), '1.12.3', true);
                //wp_enqueue_script('dataTables-jquery', 'https://cs.elite-star-services.com/common/js/jquery.dataTables.min.js', array(), '1.10.12', true);
                //wp_enqueue_script('dataTables-bootstrap', 'https://cs.elite-star-services.com/common/js/dataTables.bootstrap.min.js', array(), $themeVersion, true);
                wp_enqueue_style('dataTables-bootstrap', 'https://cdn.jsdelivr.net/gh/EliteStarServices/common/css/dataTables.bootstrap.min.css', array(), $themeVersion);
                wp_enqueue_script('required-jquery-version', 'https://cdn.jsdelivr.net/gh/EliteStarServices/common/js/jquery.min.js', array(), '1.12.3', true);
                wp_enqueue_script('dataTables-jquery', 'https://cdn.jsdelivr.net/gh/EliteStarServices/common/js/jquery.dataTables.min.js', array(), '1.10.12', true);
                wp_enqueue_script('dataTables-bootstrap', 'https://cdn.jsdelivr.net/gh/EliteStarServices/common/js/dataTables.bootstrap.min.js', array(), $themeVersion, true);

                // GLOBAL dataTables Rules
                // For Development, Temporarily Switch to the CS Version - the CDN Version will be Cached...
                //wp_enqueue_script('dataTables-global', 'https://cs.elite-star-services.com/common/js/ess.dataTables.js', array(), $themeVersion, true);
                wp_enqueue_script('dataTables-global-cdn', 'https://cdn.jsdelivr.net/gh/EliteStarServices/common/js/ess.dataTables.js', array(), $themeVersion, true);
            } else {
                wp_enqueue_style('dataTables-bootstrap', get_template_directory_uri() . '/css/dataTables.bootstrap.min.css', array(), $themeVersion);
                // Local Version does not load properly - use CS Version
                wp_enqueue_script('required-jquery-version', 'https://cs.elite-star-services.com/common/js/jquery.min.js', array(), '1.12.3', true);
                wp_enqueue_script('dataTables-jquery', get_template_directory_uri() . '/js/jquery.dataTables.min.js', array(), '1.10.12', true);
                wp_enqueue_script('dataTables-bootstrap', get_template_directory_uri() . '/js/dataTables.bootstrap.min.js', array(), $themeVersion, true);

                // LOCAL dataTables Rules
                wp_enqueue_script('dataTables-local', get_template_directory_uri() . '/js/local.dataTables.js', array(), $themeVersion, true);
            }

        }

    }
}

/**
 * ENQUEUE SCRIPTS AND STYLES END
 * 
 * to use Classic Scripts & Styles in header.php comment out the Action below
 */
add_action('wp_enqueue_scripts', 'bootstrapBasicEnqueueScripts');




/**
 * Determine if block editor (Gutenberg) support needed.
 */
if( class_exists( 'Classic_Editor' ) ) {
    function smartwp_remove_wp_block_library_css(){
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
        wp_dequeue_style( 'global-styles' ); // REMOVE THEME.JSON
        wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
        wp_dequeue_style( 'classic-theme-styles' ); // Testing that this is not needed
       } 
    add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );
} else {
    // START GUTENBERG SUPPORT CODE --------------------------------------------------------------------------------------
        // @since 1.1 or WordPress 5.0+
        // @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/ reference.
        // add wide alignment ( https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#wide-alignment )
        add_theme_support('align-wide');
        // support default block styles for front-end ( https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#default-block-styles )
        add_theme_support('wp-block-styles');
        // support editor styles ( https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#editor-styles )
        // this one make appearance in editor more close to Bootstrap 3.
        add_theme_support('editor-styles');
        // support responsive embeds for front-end ( https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#responsive-embedded-content )
        add_theme_support('responsive-embeds');
    // END GUTENBERG SUPPORT CODE ----------------------------------------------------------------------------------------


    require_once get_template_directory() . '/inc/BootstrapBasicWp5.php';
    //$BbWp5 = new BootstrapBasicWp5();
    //unset($BbWp5);


    /*
    // FATAL ERROR / php8
    // check if there are any calendar widget blocs.
    if (bootstrapBasicHasWidgetBlock('calendar') === true) {
        // if theme using widget blocks enqueue css to fix calendar widget block to render as non widget block.
        // if you would like it to be render as new widget block, please dequeue this handle.
        wp_enqueue_style('bootstrapbasic-widgetblocks-calendar', get_template_directory_uri() . '/css/widget-blocks/calendar.css', array(), $themeVersion);
    }
    */

    
}




/**
 * BLUE HAZE ADMIN NEWS WIDGET
 */
if (is_admin()) {
    require_once get_template_directory() . '/inc/widgets/BlueHazeAdminNews.php';
}

/**
 * BLUE HAZE ADMIN INFO PAGE LINK
 */
if (is_admin()) {
    require get_template_directory() . '/inc/BlueHazeInfo.php';
    $bbsc_adminhelp = new BootstrapBasicAdminHelp();
    add_action('admin_menu', array($bbsc_adminhelp, 'themeHelpMenu'));
    unset($bbsc_adminhelp);
}



// ADD SUPPORT FOR CUSTOM LOGO & HEADER OPTIONS
function theme_support_options() {
    $defaults = array(
    'height'      => 100,
    'width'       => 280,
    'flex-height' => false, // <-- setting both flex-height and flex-width to false maintains an aspect ratio
    'flex-width'  => false
    );
    add_theme_support( 'custom-logo', $defaults );
   }
   // call the function in the hook
   add_action( 'after_setup_theme', 'theme_support_options' );


   function bluehaze_customize_register( $wp_customize ) 
   {

         $wp_customize->add_section( 'header_section' , array(
           'title'    => __( 'Header Settings', 'blue-haze' ),
           'priority' => 30
       ) );   
  
       $wp_customize->add_setting( 'header_bg' , array(
           'default'   => '#FFFFFF',
           'transport' => 'refresh',
       ) );
   

// This was blocked, but I am not sure why - it controls headfer background color
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
           'label'    => __( 'Header Color', 'blue-haze' ),
           'section'  => 'header_section',
           'settings' => 'header_bg',
       ) ) );

       
       $wp_customize->add_setting( 'header_rd' , array(
       'default'   => '6',
       'transport' => 'refresh',
       ) );

       $wp_customize->add_control( 'header_rd', array(
       'label'    => __( 'Header Radius', 'blue-haze' ),
       'section'  => 'header_section',
       'settings' => 'header_rd',
       ) );

       $wp_customize->add_setting( 'header_ap', array(
        'default'   => false,
        'transport' => 'refresh',
         ) );
        
        $wp_customize->add_control( 'header_ap', array(
        'section'   => 'header_section',
        'label'     => 'Show Header on Internal Templates?',
        'type'      => 'checkbox'
        ) );

       $wp_customize->add_setting( 'header_mg', array(
        'default'   => false,
        'transport' => 'refresh',
         ) );
        
        $wp_customize->add_control( 'header_mg', array(
        'section'   => 'header_section',
        'label'     => 'Adjust Header Margins?',
        'type'      => 'checkbox'
        ) );


   }
   add_action( 'customize_register', 'bluehaze_customize_register');



/**
 * CHANGE COMMENT FORM TEXT
 */
add_filter( 'comment_form_defaults', 'wpse33039_form_defaults' );
function wpse33039_form_defaults( $defaults )
{
    $defaults['title_reply'] = '';
    return $defaults;
}
add_filter( 'comment_form_logged_in', 'unset_login_field' );
function unset_login_field($fields){
    unset($fields);
    return $fields;
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';


/**
 * Custom dropdown menu and navbar in walker class
 */
require get_template_directory() . '/inc/BootstrapBasicMyWalkerNavMenu.php';


/**
 * Template Functions
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * --------------------------------------------------------------
 * Theme Widget & Widget Hooks
 * --------------------------------------------------------------
 */
require get_template_directory() . '/inc/widgets/BootstrapBasicAutoRegisterWidgets.php';
$BootstrapBasicAutoRegisterWidgets = new BootstrapBasicAutoRegisterWidgets();
$BootstrapBasicAutoRegisterWidgets->registerAll();
unset($BootstrapBasicAutoRegisterWidgets);
require get_template_directory() . '/inc/template-widgets-hook.php';

/**
 * Plugin Requirements / Suggestions
 */
require_once get_template_directory() . '/inc/tgm-plugin/check-plugins.php';

/**
 * Check for Theme Updates
 */
require 'inc/bh-update/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://cs.elite-star-services.com/wp-repo/?action=get_metadata&slug=blue-haze',
	__FILE__, //Full path to the main plugin file or functions.php.
	'blue-haze'
);



// BLUE HAZE ADMIN NOTIFICATION
// v0.9.9.4 REQUIRED ANNOUNCEMENT
// Post Template Select plugin was depreciated
if (is_admin()) {
    require_once get_template_directory() . '/inc/BlueHazeNotify.php';
}