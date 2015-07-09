<?php
/**
 * @package WordPress
 * @subpackage Highend
 */

if ( !defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

function hb_import_demo( $demo_id, $demo_name, $content, $sliders, $widgets, $media, $highend_options, $essential_grid ) {
    global $wpdb;
    
    if ( current_user_can( 'manage_options' ) ) {
        if ( !defined( 'WP_LOAD_IMPORTERS' ) )
            define( 'WP_LOAD_IMPORTERS', true );
        
        if ( !class_exists( 'WP_Importer' ) ) {
            $wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
            include $wp_importer;
        }
        
        if ( !class_exists( 'WP_Import' ) ) {
            $wp_import = get_template_directory() . '/admin/demo-importer/wordpress-importer.php';
            include $wp_import;
        }
        
        if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) {
            
            $importer  = new WP_Import();
            $theme_xml = "";
            
            /* Delete menus to prevent menu duplication */
            wp_delete_nav_menu( 'Main Menu' );
            wp_delete_nav_menu( 'Footer Menu' );
            wp_delete_nav_menu( 'One Page Menu' );
            wp_delete_nav_menu( 'Shortcodes Menu' );
            wp_delete_nav_menu( 'Sidebar Navigation1' );
            
            // Reset widgets to prevent the duplication
            update_option( 'sidebars_widgets', null );
            
            // **** Different demos
            $theme_xml        = get_template_directory() . '/admin/demo-importer/' . $demo_id . '/highend.xml.gz'; // main xml file
            $widgets_json_url = get_template_directory_uri() . '/admin/demo-importer/' . $demo_id . '/widgets.json'; // widgets
            $rev_directory    = get_template_directory() . '/admin/demo-importer/' . $demo_id . '/revsliders/'; // revslider folder
            

            if ( $media == "true" ) {
                // fetch attachments
                $importer->fetch_attachments = true;
            }
            
            if ( $content == "true" ) {
                // import the demo
                ob_start();
                $importer->import( $theme_xml );
                ob_end_clean();
            }
            
            $locations = get_theme_mod( 'nav_menu_locations' ); // registered menu locations in theme
            $menus     = wp_get_nav_menus(); // registered menus
            
            // assign menus to theme locations
            if ( $menus ) {
                foreach ( $menus as $menu ) {
                    if ( $menu->name == 'Main Menu' ) {
                        $locations['main-menu']   = $menu->term_id;
                        $locations['mobile-menu'] = $menu->term_id;
                    } else if ( $menu->name == 'Footer Menu' ) {
                        $locations['footer-menu'] = $menu->term_id;
                    } else if ( $menu->name == 'One Page Menu' ) {
                        $locations['one-page-menu'] = $menu->term_id;
                    }
                }
            }
            
            // set menus to locations
            set_theme_mod( 'nav_menu_locations', $locations );
            
            // Set the front page
            $homepage = get_page_by_title( 'Home' );
            if ( $homepage != null && $homepage->ID ) {
                update_option( 'show_on_front', 'page' );
                update_option( 'page_on_front', $homepage->ID );
            }

            $sidebars = null;
            if ( $demo_id == 'main-demo' ) {
                if ( class_exists( 'Woocommerce' ) ) {
                    // Add sidebar widget areas
                    $sidebars = array(
                        'ShopWidget1' => 'Show Widget 1',
                        'ShopWidget2' => 'Show Widget 2',
                        'ShopWidget3' => 'Show Widget 3',
                        'ShopWidget4' => 'Show Widget 4',
                        'DefaultPageSidebar' => 'Default Page Sidebar',
                        'SidebarNavigation1' => 'Sidebar Navigation 1',
                        'PortfolioSingleSidebar' => 'Portfolio Single Sidebar',
                        'ShortcodesSidebar' => 'Shortcodes Sidebar',
                        'ShopSidebar' => 'Shop Sidebar' 
                    );
                } else {
                    // Add sidebar widget areas
                    $sidebars = array(
                        'DefaultPageSidebar' => 'Default Page Sidebar',
                        'SidebarNavigation1' => 'Sidebar Navigation 1',
                        'PortfolioSingleSidebar' => 'Portfolio Single Sidebar',
                        'ShortcodesSidebar' => 'Shortcodes Sidebar' 
                    );
                }
                    
                update_option( 'sbg_sidebars', $sidebars );
            }


                // Simple Blog Sidebars
            if ( $demo_id == 'simple-blog' ){
                $sidebars = array(
                    'ContactSidebar' => 'Contact Sidebar',
                    'AboutSidebar' => 'About Sidebar'
                );

                update_option( 'sbg_sidebars', $sidebars );
            }

            // Import Sidebars
            if ( $sidebars != null && is_array( $sidebars ) ) {
                foreach ( $sidebars as $sidebar ) {
                    $sidebar_class = hb_name_to_class( $sidebar );
                    register_sidebar( array(
                         'name' => $sidebar,
                        'id' => 'hb-custom-sidebar-' . strtolower( $sidebar_class ),
                        'before_widget' => '<div id="%1$s" class="widget-item %2$s">',
                        'after_widget' => '</div>',
                        'before_title' => '<h4>',
                        'after_title' => '</h4>' 
                    ) );
                }
            }
            
            

            // Import Color Customizer
            if ( $demo_id == 'photography' ) {
                set_theme_mod( 'hb_focus_color_setting', '#f2c100' );
                set_theme_mod( 'hb_side_nav_bg_setting', '#252525' );
                set_theme_mod( 'hb_footer_bg_setting', '#222222' );
                set_theme_mod( 'hb_footer_text_setting', '#999999' );
                set_theme_mod( 'hb_footer_link_setting', '#FFFFFF' );
                set_theme_mod( 'hb_content_bg_setting', '#444444' );
                set_theme_mod( 'hb_content_border_setting', '#F4F4F4' );
                set_theme_mod( 'hb_content_c_bg_setting', '#F4F4F4' );
            }

            if ( $demo_id == 'simple-blog' ) {
                set_theme_mod( 'hb_focus_color_setting', '#f09e88' );
                set_theme_mod( 'hb_nav_bar_bg_setting', '#ffffff');
                set_theme_mod( 'hb_nav_bar_text_setting', '#444444');
                set_theme_mod( 'hb_nav_bar_border_setting', '#e1e1e1');
                set_theme_mod( 'hb_copyright_bg_setting', '#ffffff');
                set_theme_mod( 'hb_copyright_text_setting', '#999999');
                set_theme_mod( 'hb_copyright_link_setting', '#777777');
                set_theme_mod( 'hb_content_bg_setting', '#f2f3f5');
                set_theme_mod( 'hb_side_section_bg_setting', '#454545');
                set_theme_mod( 'hb_content_c_bg_setting', '#ffffff');
                set_theme_mod( 'hb_content_text_color_setting', '#666666');
                set_theme_mod( 'hb_content_link_color_setting', '#f09e88');
                set_theme_mod( 'hb_content_border_setting', '#f0f1f2');
            }

            if ( $demo_id == 'presentation' ) {
                set_theme_mod( 'hb_focus_color_setting', '#ed6162' );
                set_theme_mod( 'hb_nav_bar_bg_setting', '#ffffff');
                //set_theme_mod( 'hb_nav_bar_text_setting', '#444444');
                set_theme_mod( 'hb_nav_bar_border_setting', '#e1e1e1');
                set_theme_mod( 'hb_nav_bar_stuck_bg_setting', '#ffffff');
                set_theme_mod( 'hb_nav_bar_stuck_text_setting', '#444444');
                set_theme_mod( 'hb_nav_bar_stuck_border_setting', '#f0f0f0');
                set_theme_mod( 'hb_pfooter_bg_setting', '#ececec');
                set_theme_mod( 'hb_pfooter_text_setting', '#323436');
                set_theme_mod( 'hb_footer_bg_setting', '#3d4045');
                set_theme_mod( 'hb_footer_text_setting', '#999999');
                set_theme_mod( 'hb_footer_link_setting', '#ffffff');
                set_theme_mod( 'hb_copyright_bg_setting', '#43474d');
                set_theme_mod( 'hb_copyright_text_setting', '#999999');
                set_theme_mod( 'hb_copyright_link_setting', '#ffffff');
                set_theme_mod( 'hb_content_bg_setting', '#222222');
                set_theme_mod( 'hb_side_section_bg_setting', '#ed6162');
                set_theme_mod( 'hb_content_c_bg_setting', '#ffffff');
                set_theme_mod( 'hb_content_text_color_setting', '#666666');
                set_theme_mod( 'hb_content_link_color_setting', '#252525');
                set_theme_mod( 'hb_content_border_setting', '#f0f0f0');
            }
            
            
            if ( $sliders == "true" ) {
            // Import Revslider
                if ( class_exists( 'UniteFunctionsRev' ) ) // if revslider is activated
                    {
                    
                    // Download Rev Sliders imports to local
                    
                    if ( $demo_id == 'main-demo' ) {
                        $url = get_template_directory() . '/admin/demo-importer/main-demo/revsliders/jobs-slider.zip';
                        if ( !file_exists( $url ) ) {
                            $d_url = 'http://hb-themes.com/repository/import/highend/revsliders/jobs-slider.zip';
                            $src   = fopen( $d_url, 'r' );
                            $dest  = fopen( $url, 'w' );

                            if ($src != false && $dest != false) {
                                stream_copy_to_stream( $src, $dest );
                                fclose( $d_url );
                                fclose( $url );
                            }
                        }
                        
                        $url = get_template_directory() . '/admin/demo-importer/main-demo/revsliders/boxed-corporate-slider.zip';
                        if ( !file_exists( $url ) ) {
                            $d_url = 'http://hb-themes.com/repository/import/highend/revsliders/boxed-corporate-slider.zip';
                            $src   = fopen( $d_url, 'r' );
                            $dest  = fopen( $url, 'w' );
                            stream_copy_to_stream( $src, $dest );
                            fclose( $d_url );
                            fclose( $url );
                        }
                        
                        
                        $url = get_template_directory() . '/admin/demo-importer/main-demo/revsliders/corporate-slider.zip';
                        if ( !file_exists( $url ) ) {
                            $d_url = 'http://hb-themes.com/repository/import/highend/revsliders/corporate-slider.zip';
                            $src   = fopen( $d_url, 'r' );
                            $dest  = fopen( $url, 'w' );
                            stream_copy_to_stream( $src, $dest );
                            fclose( $d_url );
                            fclose( $url );
                        }
                        
                        
                        $url = get_template_directory() . '/admin/demo-importer/main-demo/revsliders/home-classic-slider.zip';
                        if ( !file_exists( $url ) ) {
                            $d_url = 'http://hb-themes.com/repository/import/highend/revsliders/home-classic-slider.zip';
                            $src   = fopen( $d_url, 'r' );
                            $dest  = fopen( $url, 'w' );
                            stream_copy_to_stream( $src, $dest );
                            fclose( $d_url );
                            fclose( $url );
                        }
                        
                        
                        $url = get_template_directory() . '/admin/demo-importer/main-demo/revsliders/home-default-slider.zip';
                        if ( !file_exists( $url ) ) {
                            $d_url = 'http://hb-themes.com/repository/import/highend/revsliders/home-default-slider.zip';
                            $src   = fopen( $d_url, 'r' );
                            $dest  = fopen( $url, 'w' );
                            stream_copy_to_stream( $src, $dest );
                            fclose( $d_url );
                            fclose( $url );
                        }
                        
                        
                        $url = get_template_directory() . '/admin/demo-importer/main-demo/revsliders/home-special-slider.zip';
                        if ( !file_exists( $url ) ) {
                            $d_url = 'http://hb-themes.com/repository/import/highend/revsliders/home-special-slider.zip';
                            $src   = fopen( $d_url, 'r' );
                            $dest  = fopen( $url, 'w' );
                            stream_copy_to_stream( $src, $dest );
                            fclose( $d_url );
                            fclose( $url );
                        }
                        
                        
                        $url = get_template_directory() . '/admin/demo-importer/main-demo/revsliders/one-page-slider.zip';
                        if ( !file_exists( $url ) ) {
                            $d_url = 'http://hb-themes.com/repository/import/highend/revsliders/one-page-slider.zip';
                            $src   = fopen( $d_url, 'r' );
                            $dest  = fopen( $url, 'w' );
                            stream_copy_to_stream( $src, $dest );
                            fclose( $d_url );
                            fclose( $url );
                        }
                        
                        
                        $url = get_template_directory() . '/admin/demo-importer/main-demo/revsliders/shop-slider.zip';
                        if ( !file_exists( $url ) ) {
                            $d_url = 'http://hb-themes.com/repository/import/highend/revsliders/shop-slider.zip';
                            $src   = fopen( $d_url, 'r' );
                            $dest  = fopen( $url, 'w' );
                            stream_copy_to_stream( $src, $dest );
                            fclose( $d_url );
                            fclose( $url );
                        }
                    } else if ( $demo_id == 'photography' ) {
                        $url = get_template_directory() . '/admin/demo-importer/photography/revsliders/home-slider.zip';
                        if ( !file_exists( $url ) ) {
                            $d_url = 'http://hb-themes.com/repository/import/highend/photography/home-slider.zip';
                            $src   = fopen( $d_url, 'r' );
                            $dest  = fopen( $url, 'w' );
                            stream_copy_to_stream( $src, $dest );
                            fclose( $d_url );
                            fclose( $url );
                        }
                        
                        $url = get_template_directory() . '/admin/demo-importer/photography/revsliders/blog-slider.zip';
                        if ( !file_exists( $url ) ) {
                            $d_url = 'http://hb-themes.com/repository/import/highend/photography/blog-slider.zip';
                            $src   = fopen( $d_url, 'r' );
                            $dest  = fopen( $url, 'w' );
                            stream_copy_to_stream( $src, $dest );
                            fclose( $d_url );
                            fclose( $url );
                        }
                    } else if ( $demo_id == 'presentation' ) {
                        $url = get_template_directory() . '/admin/demo-importer/presentation/revsliders/about-slider.zip';
                        if ( !file_exists( $url ) ) {
                            $d_url = 'http://hb-themes.com/repository/import/highend/presentation/about-slider.zip';
                            $src   = fopen( $d_url, 'r' );
                            $dest  = fopen( $url, 'w' );
                            stream_copy_to_stream( $src, $dest );
                            fclose( $d_url );
                            fclose( $url );
                        }
                    }
                    
                    
                    $rev_directory = get_template_directory() . '/admin/demo-importer/' . $demo_id . '/revsliders/'; // revslider data dir
                    
                    foreach ( glob( $rev_directory . '*.zip' ) as $filename ) // get all files from revsliders data dir
                        {
                        $filename    = basename( $filename );
                        $rev_files[] = get_template_directory() . '/admin/demo-importer/' . $demo_id . '/revsliders/' . $filename;
                    }
                    
                    foreach ( $rev_files as $rev_file ) // finally import rev slider data files
                        {
                        
                        $filepath = $rev_file;
                        
                        //check if zip file or fallback to old, if zip, check if all files exist
                        $zip       = new ZipArchive;
                        $importZip = $zip->open( $filepath, ZIPARCHIVE::CREATE );
                        
                        if ( $importZip === true ) //true or integer. If integer, its not a correct zip file
                            {
                            
                            //check if files all exist in zip
                            $slider_export     = $zip->getStream( 'slider_export.txt' );
                            $custom_animations = $zip->getStream( 'custom_animations.txt' );
                            $dynamic_captions  = $zip->getStream( 'dynamic-captions.css' );
                            $static_captions   = $zip->getStream( 'static-captions.css' );
                            
                            //if(!$slider_export)  UniteFunctionsRev::throwError("slider_export.txt does not exist!");
                            //if(!$custom_animations)  UniteFunctionsRev::throwError("custom_animations.txt does not exist!");
                            //if(!$dynamic_captions) UniteFunctionsRev::throwError("dynamic-captions.css does not exist!");
                            //if(!$static_captions)  UniteFunctionsRev::throwError("static-captions.css does not exist!");
                            
                            $content    = '';
                            $animations = '';
                            $dynamic    = '';
                            $static     = '';
                            
                            while ( !feof( $slider_export ) )
                                $content .= fread( $slider_export, 1024 );
                            
                            if ( $custom_animations ) {
                                while ( !feof( $custom_animations ) )
                                    $animations .= fread( $custom_animations, 1024 );
                            }
                            if ( $dynamic_captions ) {
                                while ( !feof( $dynamic_captions ) )
                                    $dynamic .= fread( $dynamic_captions, 1024 );
                            }
                            if ( $static_captions ) {
                                while ( !feof( $static_captions ) )
                                    $static .= fread( $static_captions, 1024 );
                            }
                            
                            fclose( $slider_export );
                            if ( $custom_animations ) {
                                fclose( $custom_animations );
                            }
                            if ( $dynamic_captions ) {
                                fclose( $dynamic_captions );
                            }
                            if ( $static_captions ) {
                                fclose( $static_captions );
                            }
                            
                            //check for images!
                            
                        } else //check if fallback
                            {
                            //get content array
                            $content = @file_get_contents( $filepath );
                        }
                        
                        if ( $importZip === true ) //we have a zip
                            {
                            $db = new UniteDBRev();
                            
                            //update/insert custom animations
                            $animations = @unserialize( $animations );
                            if ( !empty( $animations ) ) {
                                foreach ( $animations as $key => $animation ) //$animation['id'], $animation['handle'], $animation['params']
                                    {
                                    $exist = $db->fetch( GlobalsRevSlider::$table_layer_anims, "handle = '" . $animation['handle'] . "'" );
                                    if ( !empty( $exist ) ) //update the animation, get the ID
                                        {
                                        if ( $updateAnim == "true" ) //overwrite animation if exists
                                            {
                                            $arrUpdate           = array();
                                            $arrUpdate['params'] = stripslashes( json_encode( str_replace( "'", '"', $animation['params'] ) ) );
                                            $db->update( GlobalsRevSlider::$table_layer_anims, $arrUpdate, array(
                                                 'handle' => $animation['handle'] 
                                            ) );
                                            
                                            $id = $exist['0']['id'];
                                        } else //insert with new handle
                                            {
                                            $arrInsert           = array();
                                            $arrInsert["handle"] = 'copy_' . $animation['handle'];
                                            $arrInsert["params"] = stripslashes( json_encode( str_replace( "'", '"', $animation['params'] ) ) );
                                            
                                            $id = $db->insert( GlobalsRevSlider::$table_layer_anims, $arrInsert );
                                        }
                                    } else //insert the animation, get the ID
                                        {
                                        $arrInsert           = array();
                                        $arrInsert["handle"] = $animation['handle'];
                                        $arrInsert["params"] = stripslashes( json_encode( str_replace( "'", '"', $animation['params'] ) ) );
                                        
                                        $id = $db->insert( GlobalsRevSlider::$table_layer_anims, $arrInsert );
                                    }
                                    
                                    //and set the current customin-oldID and customout-oldID in slider params to new ID from $id
                                    $content = str_replace( array(
                                         'customin-' . $animation['id'],
                                        'customout-' . $animation['id'] 
                                    ), array(
                                         'customin-' . $id,
                                        'customout-' . $id 
                                    ), $content );
                                }
                                //dmp(__("animations imported!",REVSLIDER_TEXTDOMAIN));
                            } else {
                                //dmp(__("no custom animations found, if slider uses custom animations, the provided export may be broken...",REVSLIDER_TEXTDOMAIN));
                            }
                            
                            //overwrite/append static-captions.css
                            if ( !empty( $static ) ) {
                                if ( $updateStatic == "true" ) //overwrite file
                                    {
                                    RevOperations::updateStaticCss( $static );
                                } else //append
                                    {
                                    $static_cur = RevOperations::getStaticCss();
                                    $static     = $static_cur . "\n" . $static;
                                    RevOperations::updateStaticCss( $static );
                                }
                            }
                            //overwrite/create dynamic-captions.css
                            //parse css to classes
                            $dynamicCss = UniteCssParserRev::parseCssToArray( $dynamic );
                            
                            if ( is_array( $dynamicCss ) && $dynamicCss !== false && count( $dynamicCss ) > 0 ) {
                                foreach ( $dynamicCss as $class => $styles ) {
                                    //check if static style or dynamic style
                                    $class = trim( $class );
                                    
                                    if ( ( strpos( $class, ':hover' ) === false && strpos( $class, ':' ) !== false ) || //before, after
                                        strpos( $class, " " ) !== false || // .tp-caption.imageclass img or .tp-caption .imageclass or .tp-caption.imageclass .img
                                        strpos( $class, ".tp-caption" ) === false || // everything that is not tp-caption
                                        ( strpos( $class, "." ) === false || strpos( $class, "#" ) !== false ) || // no class -> #ID or img
                                        strpos( $class, ">" ) !== false ) //.tp-caption>.imageclass or .tp-caption.imageclass>img or .tp-caption.imageclass .img
                                        {
                                        continue;
                                    }
                                    
                                    //is a dynamic style
                                    if ( strpos( $class, ':hover' ) !== false ) {
                                        $class                 = trim( str_replace( ':hover', '', $class ) );
                                        $arrInsert             = array();
                                        $arrInsert["hover"]    = json_encode( $styles );
                                        $arrInsert["settings"] = json_encode( array(
                                             'hover' => 'true' 
                                        ) );
                                    } else {
                                        $arrInsert           = array();
                                        $arrInsert["params"] = json_encode( $styles );
                                    }
                                    //check if class exists
                                    $result = $db->fetch( GlobalsRevSlider::$table_css, "handle = '" . $class . "'" );
                                    
                                    if ( !empty( $result ) ) //update
                                        {
                                        $db->update( GlobalsRevSlider::$table_css, $arrInsert, array(
                                             'handle' => $class 
                                        ) );
                                    } else //insert
                                        {
                                        $arrInsert["handle"] = $class;
                                        $db->insert( GlobalsRevSlider::$table_css, $arrInsert );
                                    }
                                }
                                //dmp(__("dynamic styles imported!",REVSLIDER_TEXTDOMAIN));
                            } else {
                                //dmp(__("no dynamic styles found, if slider uses dynamic styles, the provided export may be broken...",REVSLIDER_TEXTDOMAIN));
                            }
                        }
                        
                        $content = preg_replace( '!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $content ); //clear errors in string
                        
                        $arrSlider    = @unserialize( $content );
                        $sliderParams = $arrSlider["params"];
                        
                        if ( isset( $sliderParams["background_image"] ) )
                            $sliderParams["background_image"] = UniteFunctionsWPRev::getImageUrlFromPath( $sliderParams["background_image"] );
                        
                        $json_params = json_encode( $sliderParams );
                        
                        //new slider
                        $arrInsert           = array();
                        $arrInsert["params"] = $json_params;
                        $arrInsert["title"]  = UniteFunctionsRev::getVal( $sliderParams, "title", "Slider1" );
                        $arrInsert["alias"]  = UniteFunctionsRev::getVal( $sliderParams, "alias", "slider1" );
                        $sliderID            = $wpdb->insert( GlobalsRevSlider::$table_sliders, $arrInsert );
                        $sliderID            = $wpdb->insert_id;
                        
                        //-------- Slides Handle -----------
                        
                        //create all slides
                        $arrSlides = $arrSlider["slides"];
                        
                        $alreadyImported = array();
                        
                        foreach ( $arrSlides as $slide ) {
                            
                            $params = $slide["params"];
                            $layers = $slide["layers"];
                            
                            //convert params images:
                            if ( isset( $params["image"] ) ) {
                                //import if exists in zip folder
                                if ( trim( $params["image"] ) !== '' ) {
                                    if ( $importZip === true ) //we have a zip, check if exists
                                        {
                                        $image = $zip->getStream( 'images/' . $params["image"] );
                                        if ( !$image ) {
                                            echo $params["image"] . ' not found!<br>';
                                        } else {
                                            if ( !isset( $alreadyImported['zip://' . $filepath . "#" . 'images/' . $params["image"]] ) ) {
                                                $importImage = UniteFunctionsWPRev::import_media( 'zip://' . $filepath . "#" . 'images/' . $params["image"], $sliderParams["alias"] . '/' );
                                                
                                                if ( $importImage !== false ) {
                                                    $alreadyImported['zip://' . $filepath . "#" . 'images/' . $params["image"]] = $importImage['path'];
                                                    
                                                    $params["image"] = $importImage['path'];
                                                }
                                            } else {
                                                $params["image"] = $alreadyImported['zip://' . $filepath . "#" . 'images/' . $params["image"]];
                                            }
                                        }
                                    }
                                }
                                $params["image"] = UniteFunctionsWPRev::getImageUrlFromPath( $params["image"] );
                            }
                            
                            //convert layers images:
                            foreach ( $layers as $key => $layer ) {
                                if ( isset( $layer["image_url"] ) ) {
                                    //import if exists in zip folder
                                    if ( trim( $layer["image_url"] ) !== '' ) {
                                        if ( $importZip === true ) //we have a zip, check if exists
                                            {
                                            $image_url = $zip->getStream( 'images/' . $layer["image_url"] );
                                            if ( !$image_url ) {
                                                echo $layer["image_url"] . ' not found!<br>';
                                            } else {
                                                if ( !isset( $alreadyImported['zip://' . $filepath . "#" . 'images/' . $layer["image_url"]] ) ) {
                                                    $importImage = UniteFunctionsWPRev::import_media( 'zip://' . $filepath . "#" . 'images/' . $layer["image_url"], $sliderParams["alias"] . '/' );
                                                    
                                                    if ( $importImage !== false ) {
                                                        $alreadyImported['zip://' . $filepath . "#" . 'images/' . $layer["image_url"]] = $importImage['path'];
                                                        
                                                        $layer["image_url"] = $importImage['path'];
                                                    }
                                                } else {
                                                    $layer["image_url"] = $alreadyImported['zip://' . $filepath . "#" . 'images/' . $layer["image_url"]];
                                                }
                                            }
                                        }
                                    }
                                    $layer["image_url"] = UniteFunctionsWPRev::getImageUrlFromPath( $layer["image_url"] );
                                    $layers[$key]       = $layer;
                                }
                            }
                            
                            //create new slide
                            $arrCreate                = array();
                            $arrCreate["slider_id"]   = $sliderID;
                            $arrCreate["slide_order"] = $slide["slide_order"];
                            $arrCreate["layers"]      = json_encode( $layers );
                            $arrCreate["params"]      = json_encode( $params );
                            
                            $wpdb->insert( GlobalsRevSlider::$table_slides, $arrCreate );
                            //}
                        }
                    }
                }
            }
            

            if ( $essential_grid == "true" ) { 
                // Import Essential Grid
                if ( defined( 'EG_PLUGIN_PATH' ) && class_exists( 'Essential_Grid_Import' ) ) {
                    try {
                        $json_url = get_template_directory() . '/admin/demo-importer/' . $demo_id . '/ess_grid.json';
                        
                        if ( file_exists( $json_url ) ) {
                            $tp_grid_meta_fonts = file_get_contents( $json_url, true );
                            
                            //insert meta, grids & punchfonts
                            $im = new Essential_Grid_Import();
                            $im->set_overwrite_data( $tp_grid_meta_fonts ); //set overwrite data global to class
                            
                            if ( isset( $tp_grid_meta_fonts ) ) {
                                $tp_grid_meta_fonts = json_decode( $tp_grid_meta_fonts, true );
                                
                                /* Skins */
                                $skins     = @$tp_grid_meta_fonts['skins'];
                                $skins_ids = array();
                                
                                foreach ( $skins as $skin ) {
                                    $skins_ids[] = $skin['id'];
                                }
                                if ( !empty( $skins ) && is_array( $skins ) ) {
                                    $skins_imported = $im->import_skins( $skins, $skins_ids );
                                }
                                
                                /* Navigation Skins */
                                $navigation_skins     = @$tp_grid_meta_fonts['navigation-skins'];
                                $navigation_skins_ids = array();
                                
                                foreach ( $navigation_skins as $nav_skin ) {
                                    $navigation_skins_ids[] = $nav_skin['id'];
                                }
                                
                                if ( !empty( $navigation_skins ) && is_array( $navigation_skins ) ) {
                                    $navigation_skins_imported = $im->import_navigation_skins( $navigation_skins, $navigation_skins_ids );
                                }
                                
                                /* Grids */
                                $grids     = @$tp_grid_meta_fonts['grids'];
                                $grids_ids = array();
                                
                                foreach ( $grids as $grid ) {
                                    $grids_ids[] = $grid['id'];
                                }
                                
                                if ( !empty( $grids ) && is_array( $grids ) ) {
                                    $grids_imported = $im->import_grids( $grids, $grids_ids );
                                }
                                
                                /* Custom Metas */
                                $custom_metas        = @$tp_grid_meta_fonts['custom-meta'];
                                $custom_meta_handles = array();
                                
                                foreach ( $custom_metas as $custom_meta ) {
                                    $custom_meta_handles[] = $custom_meta['handle'];
                                }
                                
                                if ( !empty( $custom_metas ) && is_array( $custom_metas ) ) {
                                    $custom_metas_imported = $im->import_custom_meta( $custom_metas, $custom_meta_handles );
                                }
                                
                                /* Custom Fonts */
                                $custom_fonts        = @$tp_grid_meta_fonts['punch-fonts'];
                                $custom_font_handles = array();
                                
                                foreach ( $custom_fonts as $custom_font ) {
                                    $custom_font_handles[] = $custom_font['handle'];
                                }
                                
                                if ( !empty( $custom_fonts ) && is_array( $custom_fonts ) ) {
                                    $custom_fonts_imported = $im->import_punch_fonts( $custom_fonts, $custom_font_handles );
                                }
                                
                                // Global CSS
                                $global_css = @$tp_grid_meta_fonts['global-css'];
                                if ( !empty( $global_css ) && is_array( $global_css ) ) {
                                    $global_css_imported = $im->import_global_styles( $global_css );
                                }
                                
                            }
                        }
                        
                    }
                    catch ( Exception $d ) {
                    }
                }
                // END Essential Grid Import

            }
            
            
             if ( $widgets == "true" ) {
                // Add data to widgets
                $widgets_json   = $widgets_json_url;
                $widgets_json   = wp_remote_get( $widgets_json );
                $widget_data    = $widgets_json['body'];
                $import_widgets = hb_import_widget_data( $widget_data );
            }

            // ********************************************************
            // finally return status
            $home_url = home_url();
            return "<strong>" . $demo_name . "</strong>" . __( " has been imported successfully! <a href='" . $home_url . "'>View your website.</a>", "hbthemes" );
            
        }
    }
    
    return "Something went wrong. Please try again.";
}

/* HELPER FUNCTIONS
 *******************************************************************/

// Parsing Widgets Function
function hb_import_widget_data( $widget_data ) {
    
    $json_data = $widget_data;
    $json_data = json_decode( $json_data, true );
    
    $sidebar_data = $json_data[0];
    $widget_data  = $json_data[1];
    
    
    foreach ( $widget_data as $widget_data_title => $widget_data_value ) {
        $widgets[$widget_data_title] = '';
        foreach ( $widget_data_value as $widget_data_key => $widget_data_array ) {
            if ( is_int( $widget_data_key ) ) {
                $widgets[$widget_data_title][$widget_data_key] = 'on';
            }
        }
    }
    unset( $widgets[""] );
    
    foreach ( $sidebar_data as $title => $sidebar ) {
        $count = count( $sidebar );
        for ( $i = 0; $i < $count; $i++ ) {
            $widget               = array();
            $widget['type']       = trim( substr( $sidebar[$i], 0, strrpos( $sidebar[$i], '-' ) ) );
            $widget['type-index'] = trim( substr( $sidebar[$i], strrpos( $sidebar[$i], '-' ) + 1 ) );
            if ( !isset( $widgets[$widget['type']][$widget['type-index']] ) ) {
                unset( $sidebar_data[$title][$i] );
            }
        }
        $sidebar_data[$title] = array_values( $sidebar_data[$title] );
    }
    
    foreach ( $widgets as $widget_title => $widget_value ) {
        foreach ( $widget_value as $widget_key => $widget_value ) {
            $widgets[$widget_title][$widget_key] = $widget_data[$widget_title][$widget_key];
        }
    }
    
    $sidebar_data = array(
         array_filter( $sidebar_data ),
        $widgets 
    );
    
    hb_parse_import_data( $sidebar_data );
}

function hb_parse_import_data( $import_array ) {
    global $wp_registered_sidebars;
    $sidebars_data    = $import_array[0];
    $widget_data      = $import_array[1];
    $current_sidebars = get_option( 'sidebars_widgets' );
    $new_widgets      = array();
    
    foreach ( $sidebars_data as $import_sidebar => $import_widgets ):
        foreach ( $import_widgets as $import_widget ):
        //if the sidebar exists
            if ( isset( $wp_registered_sidebars[$import_sidebar] ) ):
                $title               = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
                $index               = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
                $current_widget_data = get_option( 'widget_' . $title );
                $new_widget_name     = hb_get_new_widget_name( $title, $index );
                $new_index           = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );
                if ( !empty( $new_widgets[$title] ) && is_array( $new_widgets[$title] ) ) {
                    while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
                        $new_index++;
                    }
                }
                $current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
                if ( array_key_exists( $title, $new_widgets ) ) {
                    $new_widgets[$title][$new_index] = $widget_data[$title][$index];
                    $multiwidget                     = $new_widgets[$title]['_multiwidget'];
                    unset( $new_widgets[$title]['_multiwidget'] );
                    $new_widgets[$title]['_multiwidget'] = $multiwidget;
                } else {
                    $current_widget_data[$new_index] = $widget_data[$title][$index];
                    $current_multiwidget             = $current_widget_data['_multiwidget'];
                    $new_multiwidget                 = isset( $widget_data[$title]['_multiwidget'] ) ? $widget_data[$title]['_multiwidget'] : false;
                    $multiwidget                     = ( $current_multiwidget != $new_multiwidget ) ? $current_multiwidget : 1;
                    unset( $current_widget_data['_multiwidget'] );
                    $current_widget_data['_multiwidget'] = $multiwidget;
                    $new_widgets[$title]                 = $current_widget_data;
                }
            endif;
        endforeach;
    endforeach;
    
    if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
        update_option( 'sidebars_widgets', $current_sidebars );
        
        foreach ( $new_widgets as $title => $content )
            update_option( 'widget_' . $title, $content );
        
        return true;
    }
    
    return false;
}

function hb_get_new_widget_name( $widget_name, $widget_index ) {
    $current_sidebars = get_option( 'sidebars_widgets' );
    $all_widget_array = array();
    
    if ( is_array( $current_sidebars ) ) {
        foreach ( $current_sidebars as $sidebar => $widgets ) {
            if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
                foreach ( $widgets as $widget ) {
                    $all_widget_array[] = $widget;
                }
            }
        }
    }
    while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
        $widget_index++;
    }
    $new_widget_name = $widget_name . '-' . $widget_index;
    return $new_widget_name;
}

if ( function_exists( 'layerslider_import_sample_slider' ) ) {
    function hb_import_sample_slider( $layerslider_data ) {
        // Base64 encoded, serialized slider export code
        $sample_slider = $layerslider_data;
        
        // Iterate over the sliders
        foreach ( $sample_slider as $sliderkey => $slider ) {
            
            // Iterate over the layers
            foreach ( $sample_slider[$sliderkey]['layers'] as $layerkey => $layer ) {
                
                // Change background images if any
                if ( !empty( $sample_slider[$sliderkey]['layers'][$layerkey]['properties']['background'] ) ) {
                    $sample_slider[$sliderkey]['layers'][$layerkey]['properties']['background'] = $GLOBALS['lsPluginPath'] . 'sampleslider/' . basename( $layer['properties']['background'] );
                }
                
                // Change thumbnail images if any
                if ( !empty( $sample_slider[$sliderkey]['layers'][$layerkey]['properties']['thumbnail'] ) ) {
                    $sample_slider[$sliderkey]['layers'][$layerkey]['properties']['thumbnail'] = $GLOBALS['lsPluginPath'] . 'sampleslider/' . basename( $layer['properties']['thumbnail'] );
                }
                
                // Iterate over the sublayers
                if ( isset( $layer['sublayers'] ) && !empty( $layer['sublayers'] ) ) {
                    foreach ( $layer['sublayers'] as $sublayerkey => $sublayer ) {
                        
                        // Only IMG sublayers
                        if ( $sublayer['type'] == 'img' ) {
                            $sample_slider[$sliderkey]['layers'][$layerkey]['sublayers'][$sublayerkey]['image'] = $GLOBALS['lsPluginPath'] . 'sampleslider/' . basename( $sublayer['image'] );
                        }
                    }
                }
            }
        }
        
        // Get WPDB Object
        global $wpdb;
        
        // Table name
        $table_name = $wpdb->prefix . "layerslider";
        
        // Append duplicate
        foreach ( $sample_slider as $key => $val ) {
            // Insert the duplicate
            $wpdb->query( $wpdb->prepare( "INSERT INTO $table_name (name, data, date_c, date_m) VALUES (%s, %s, %d, %d)", $val['properties']['title'], json_encode( $val ), time(), time() ) );
        }
    }
}

// Rename sidebar
function hb_name_to_class( $name ) {
    $class = str_replace( array(
        ' ',
        ',',
        '.',
        '"',
        "'",
        '/',
        "\\",
        '+',
        '=',
        ')',
        '(',
        '*',
        '&',
        '^',
        '%',
        '$',
        '#',
        '@',
        '!',
        '~',
        '`',
        '<',
        '>',
        '?',
        '[',
        ']',
        '{',
        '}',
        '|',
        ':' 
    ), '', $name );
    return $class;
}
?>