<?php
if (!function_exists ('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}


/**
 * Register styles and scripts
 */

function flooring_admin_scripts_init() {

    wp_register_script('bootstrap.min', get_template_directory_uri().'/js/bootstrap.min.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse', 'jquery-ui-tabs', 'jquery-ui-droppable', 'jquery-ui-sortable' ) , false , false );

}
add_action('admin_init', 'flooring_admin_scripts_init');


class flooring_Import {

    public $message = "";
    public $attachments = false;


    function init_flooring_import() {
        if(isset($_REQUEST['import_option'])) {
            $import_option = $_REQUEST['import_option'];
            if($import_option == 'content'){
            }elseif($import_option == 'custom_sidebars') {
               // $this->import_custom_sidebars('custom_sidebars.txt');
            } elseif($import_option == 'widgets') {
                $this->import_widgets('widgets.txt');
            } elseif($import_option == 'options'){
                $this->import_options('options.txt');
            }elseif($import_option == 'menus'){
                $this->import_menus('menus.txt');
            }elseif($import_option == 'settingpages'){
                $this->import_settings_pages('settingpages.txt');
            }elseif($import_option == 'complete_content'){
                $this->import_options('options.txt');
                $this->import_widgets('widgets.txt');
                $this->import_menus('menus.txt');
                $this->import_settings_pages('settingpages.txt');
                $this->message = esc_html__("Content imported successfully", "webdevia");
            }
        }
    }

    public function flooring_import_content($file){
        ob_start();
        if (!class_exists('WP_Importer')) {
            $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
            require_once($class_wp_importer);
        }
        if (!class_exists('WP_Import')) {
            require_once(plugin_dir_path( __FILE__ ) . '/class.wordpress-importer.php');
        }
        $flooring_import = new WP_Import();
        set_time_limit(0);
        $path = plugin_dir_path( __FILE__ ) . '/files/' . $file;
        if(!file_exists($path)) {
            echo 'error';
            wp_send_json_error(esc_html__("Content file not found", "webdevia"));
        }

        print $path;
        $flooring_import->fetch_attachments = $this->attachments;
        $returned_value = $flooring_import->import($path);
        if(is_wp_error($returned_value)){
            $this->message = esc_html__("An Error Occurred During Import", "webdevia");
            echo 'error';
            wp_send_json_error(esc_html__("An Error Occurred During Content Import", "webdevia"));
        }
        else {
            $this->message = esc_html__("Content imported successfully", "webdevia");
        }
        ob_get_clean();
    }

    public function flooring_available_widgets() {

        global $wp_registered_widget_controls;

        $widget_controls = $wp_registered_widget_controls;

        $available_widgets = array();

        foreach ( $widget_controls as $widget ) {

            if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

                $available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
                $available_widgets[$widget['id_base']]['name'] = $widget['name'];

            }

        }

        return apply_filters( 'wie_available_widgets', $available_widgets );

    }

    public function import_widgets($file){

        if(!file_exists(dirname(__FILE__) . $file)) {
            echo 'error';
            wp_send_json_error(esc_html__("Widgets file not found", "webdevia"));
        } else {
            $myfile = fopen( dirname(__FILE__) . $file, "r" ) or wp_die( "Unable to open file!" );
            $data = fread( $myfile, filesize( dirname(__FILE__) . $file ) );
            fclose( $myfile );
        }

        /*
        $data = file_get_contents( "./demo-files/widgets.txt", FILE_USE_INCLUDE_PATH );
        $data = json_decode( $data );

        // Delete import file
        unlink( $file );*/

        $data = json_decode( $data );



        global $wp_registered_sidebars;

        // Have valid data?
        // If no data or could not decode
        if ( empty( $data ) || ! is_object( $data ) ) {
            echo 'error';
            wp_send_json_error(esc_html__( "Widgets import data file could not be read or is empty.", 'webdevia' ));
            wp_die(
                __( 'Import data could not be read. Please try a different file.', 'webdevia' ),
                '',
                array( 'back_link' => true )
            );
        }

        // Hook before import
        do_action( 'wie_before_import' );
        $data = apply_filters( 'import_widgets', $data );

        // Get all available widgets site supports
        $available_widgets = $this->flooring_available_widgets();

        // Get all existing widget instances
        $widget_instances = array();
        foreach ( $available_widgets as $widget_data ) {
            $widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
        }

        // Begin results
        $results = array();

        // Loop import data's sidebars
        foreach ( $data as $sidebar_id => $widgets ) {

            // Skip inactive widgets
            // (should not be in export file)
            if ( 'wp_inactive_widgets' == $sidebar_id ) {
                continue;
            }

            // Check if sidebar is available on this site
            // Otherwise add widgets to inactive, and say so
            if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
                $sidebar_available = true;
                $use_sidebar_id = $sidebar_id;
                $sidebar_message_type = 'success';
                $sidebar_message = '';
            } else {
                $sidebar_available = false;
                $use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
                $sidebar_message_type = 'error';
                $sidebar_message = __( 'Sidebar does not exist in theme (using Inactive)', 'widget-importer-exporter' );
            }

            // Result for sidebar
            $results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
            $results[$sidebar_id]['message_type'] = $sidebar_message_type;
            $results[$sidebar_id]['message'] = $sidebar_message;
            $results[$sidebar_id]['widgets'] = array();

            // Loop widgets
            foreach ( $widgets as $widget_instance_id => $widget ) {

                echo $sidebar_id .' - '. $widget_instance_id;

                $fail = false;

                // Get id_base (remove -# from end) and instance ID number
                $id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
                $instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

                // Does site support this widget?
                if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
                    $fail = true;
                    $widget_message_type = 'error';
                    $widget_message = __( 'Site does not support widget', 'widget-importer-exporter' ); // explain why widget not imported
                }

                // Filter to modify settings object before conversion to array and import
                // Leave this filter here for backwards compatibility with manipulating objects (before conversion to array below)
                // Ideally the newer wie_widget_settings_array below will be used instead of this
                $widget = apply_filters( 'wie_widget_settings', $widget ); // object

                // Convert multidimensional objects to multidimensional arrays
                // Some plugins like Jetpack Widget Visibility store settings as multidimensional arrays
                // Without this, they are imported as objects and cause fatal error on Widgets page
                // If this creates problems for plugins that do actually intend settings in objects then may need to consider other approach: https://wordpress.org/support/topic/problem-with-array-of-arrays
                // It is probably much more likely that arrays are used than objects, however
                $widget = json_decode( json_encode( $widget ), true );

                // Filter to modify settings array
                // This is preferred over the older wie_widget_settings filter above
                // Do before identical check because changes may make it identical to end result (such as URL replacements)
                $widget = apply_filters( 'wie_widget_settings_array', $widget );

                // Does widget with identical settings already exist in same sidebar?
                if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

                    // Get existing widgets in this sidebar
                    $sidebars_widgets = get_option( 'sidebars_widgets' );
                    $sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

                    // Loop widgets with ID base
                    $single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
                    foreach ( $single_widget_instances as $check_id => $check_widget ) {

                        // Is widget in same sidebar and has identical settings?
                        if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

                            $fail = true;
                            $widget_message_type = 'warning';
                            $widget_message = __( 'Widget already exists', 'widget-importer-exporter' ); // explain why widget not imported

                            break;

                        }

                    }

                }

                // No failure
                if ( ! $fail ) {

                    // Add widget instance
                    $single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
                    $single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
                    $single_widget_instances[] = $widget; // add it

                    // Get the key it was given
                    end( $single_widget_instances );
                    $new_instance_id_number = key( $single_widget_instances );

                    // If key is 0, make it 1
                    // When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
                    if ( '0' === strval( $new_instance_id_number ) ) {
                        $new_instance_id_number = 1;
                        $single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
                        unset( $single_widget_instances[0] );
                    }

                    // Move _multiwidget to end of array for uniformity
                    if ( isset( $single_widget_instances['_multiwidget'] ) ) {
                        $multiwidget = $single_widget_instances['_multiwidget'];
                        unset( $single_widget_instances['_multiwidget'] );
                        $single_widget_instances['_multiwidget'] = $multiwidget;
                    }

                    // Update option with new widget
                    update_option( 'widget_' . $id_base, $single_widget_instances );

                    // Assign widget instance to sidebar
                    $sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
                    $new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
                    $sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
                    update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

                    // Success message
                    if ( $sidebar_available ) {
                        $widget_message_type = 'success';
                        $widget_message = __( 'Imported', 'widget-importer-exporter' );
                    } else {
                        $widget_message_type = 'warning';
                        $widget_message = __( 'Imported to Inactive', 'widget-importer-exporter' );
                    }

                }

                // Result for widget instance
                $results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
                $results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = ! empty( $widget['title'] ) ? $widget['title'] : __( 'No Title', 'widget-importer-exporter' ); // show "No Title" if widget instance is untitled
                $results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
                $results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

            }

        }
    }


    public function import_options($file){
        $options = $this->file_options($file,'Options');
        update_option( 'flooring_options_array', $options);
        $this->message = esc_html__("Options imported successfully", "webdevia");
    }

    public function import_menus($file){
        global $wpdb;
        $flooring_terms_table = $wpdb->prefix . "terms";
        $flooring_terms_table = esc_sql( $flooring_terms_table );
        $this->menus_data = $this->file_options($file,'Menus');

        $locations = get_theme_mod('nav_menu_locations');
        $menuname = 'primary-menu';
        $menu_exists = wp_get_nav_menu_object( $menuname );
        $menu_id = $menu_exists->term_id;
        $locations['primary'] = $menu_id;

        set_theme_mod( 'nav_menu_locations', $locations );



    }
    public function import_settings_pages($file){
        $pages = $this->file_options($file,'Settings');

        foreach($pages as $flooring_page_option => $flooring_page_id){
            update_option( $flooring_page_option, $flooring_page_id);
        }

        $demo = 'demo-1';
        if (!empty($_POST['example']))
            $demo = $_POST['example'];

        switch($demo){
            case 'demo-1': $page = 'Home One';
                break;
            case 'demo-2': $page = 'Home 2-2';
                break;
	        case 'demo-3': $page = 'Home two';
		        break;
            case 'demo-4': $page = 'Home';
		        break;
            case 'demo-5': $page = 'Home';
		        break;
            default : $page = 'Home';
                break;
        }
        $home_page = get_option("page_on_front");
        if(!$home_page || !is_page($home_page)) {
            $home = get_page_by_title($page);
            update_option('page_on_front',$home->ID);
        }
        $blog_page = get_option("page_for_posts");
        if(!$blog_page || !is_page($blog_page)) {
            $blog = get_page_by_title('Blog');
            update_option('page_for_posts',$blog->ID);
        }
        $home_page = get_option('page_on_front');
        $value = get_post_meta($home_page, '_custom_options', true);
        $value_array = explode('|', $value);
        if(!empty($value_array) && count($value_array) != 0) {
            foreach ($value_array as $arrayer) {
                $contenter = explode('::',$arrayer);
                if(!empty($contenter) && count($contenter) != 0) {
                    flooring_save_option($contenter[0], $contenter[1]);
                }
            }
        }
        delete_post_meta($home_page, '_custom_options');
    }
    public function file_options($file,$text){
        $file_content = "";
        $file_for_import = plugin_dir_path( __FILE__ ) . '/files/' . $file;
        if ( file_exists($file_for_import) ) {
            $file_content = $this->flooring_file_contents($file_for_import);
        } else {
            $this->message = esc_html__("File doesn't exist", "webdevia");
            echo 'error';
            wp_send_json_error(esc_html__($text." file doesn't exist", "webdevia"));
        }
        if ($file_content) {
            $unserialized_content = unserialize($file_content);
            $json_array = json_decode($file_content);
            /*print_r($json_array);*/
            if (is_array($unserialized_content)) {
                if($text=='Options'){
                    echo 'error';
                    wp_send_json_error('Unserialized');
                }

            }
            // print_r($json_array);
            return $unserialized_content;
        }  else{
            echo 'error';
            wp_send_json_error(esc_html__( $text." import data file could not be read or is empty.", 'webdevia' ));
        }
        /*return false;*/
    }

    function flooring_file_contents( $path ) {
        $flooring_content = '';
        if ( function_exists('realpath') )
            $filepath = realpath($path);
        if ( !$filepath || !@is_file($filepath) ) {
            echo 'error';
            wp_send_json_error(esc_html__("File doesn't exist or not valid", "webdevia"));
            return '';
        }
        if( ini_get('allow_url_fopen') ) {
            $flooring_file_method = 'fopen';
        } else {
            $flooring_file_method = 'file_get_contents';
        }
        if ( $flooring_file_method == 'fopen' ) {
            $flooring_handle = fopen( $filepath, 'rb' );

            if( $flooring_handle !== false ) {
                while (!feof($flooring_handle)) {
                    $flooring_content .= fread($flooring_handle, 8192);
                }
                fclose( $flooring_handle );
            }
            return $flooring_content;
        } else {
            return file_get_contents($filepath);
        }
    }
}
global $my_flooring_Import;
$my_flooring_Import = new flooring_Import();



if(!function_exists('flooring_dataImport'))
{
    function flooring_dataImport()
    {
        global $my_flooring_Import;

        if ($_POST['import_attachments'] == 1)
            $my_flooring_Import->attachments = true;
        else
            $my_flooring_Import->attachments = false;

        $demo = 'demo-1';
        if (!empty($_POST['example']))
            $demo = $_POST['example'];

        switch($demo){
            case 'demo-1': $folder = "main-demo-1/";
                break;
            case 'demo-2': $folder = "main-demo-2/";
                break;
	        case 'demo-3': $folder = "main-demo-3/";
		        break;
            case 'demo-4': $folder = "main-demo-4/";
		        break;
            case 'demo-5': $folder = "main-demo-5/";
		        break;
                case 'demo-6': $folder = "main-demo-6/";
		        break;
        }
        //$folder = "main/";

        $my_flooring_Import->flooring_import_content($folder.$_POST['xml']);

        wp_die();
    }

    add_action('wp_ajax_flooring_dataImport', 'flooring_dataImport');
}


if(!function_exists('flooring_menuImport'))
{
    function flooring_menuImport()
    {
        global $my_flooring_Import;

        if ($_POST['delete_menus'] == 1){
            delete_nav_menus();
        }

        if ($_POST['import_attachments'] == 1)
            $my_flooring_Import->attachments = true;
        else
            $my_flooring_Import->attachments = false;

       /* $folder = "files/";
        if (!empty($_POST['example']))
            $folder = $_POST['example']."/";*/
            $demo = 'demo-1';
        if (!empty($_POST['example']))
            $demo = $_POST['example'];

        switch($demo){
            case 'demo-1': $folder = "main-demo-1/";
                break;
            case 'demo-2': $folder = "main-demo-2/";
                break;
	        case 'demo-3': $folder = "main-demo-3/";
		        break;
            case 'demo-4': $folder = "main-demo-4/";
		        break;
            case 'demo-5': $folder = "main-demo-5/";
		        break;
                case 'demo-6': $folder = "main-demo-6/";
		        break;
        }

        $my_flooring_Import->flooring_import_content($folder.'menus.xml');


        $locations = get_theme_mod('nav_menu_locations');
        $menuname = 'main-menu';
        $demo = 'demo-1';
        if (!empty($_POST['example']))
            $demo = $_POST['example'];

        switch($demo){
            case 'demo-1': $menuname = 'main-menu';
                break;
            case 'demo-2': $menuname = 'menu';
                break;
	        case 'demo-3': $menuname = 'main-menu';
		        break;
            case 'demo-4': $menuname = 'main-menu';
		        break;
            case 'demo-5': $menuname = 'main-menu';
		        break;
                case 'demo-6': $menuname = 'main-menu';
		        break;
        }
        $menu_exists = wp_get_nav_menu_object( $menuname );
        $menu_id = $menu_exists->term_id;
        $locations['primary'] = $menu_id;

        set_theme_mod( 'nav_menu_locations', $locations );
        wp_die();
    }

    add_action('wp_ajax_flooring_menuImport', 'flooring_menuImport');
}

if(!function_exists('flooring_widgetsImport'))
{
    function flooring_widgetsImport()
    {
        global $my_flooring_Import;

        $demo = 'demo-1';
        if (!empty($_POST['example']))
            $demo = $_POST['example'];

        switch($demo){
            case 'demo-1': $folder = "/files/main-demo-1/";
                break;
            case 'demo-2': $folder = "/files/main-demo-2/";
                break;
            case 'demo-3': $folder = "/files/main-demo-3/";
                break;
            case 'demo-4': $folder = "/files/main-demo-4/";
                break;
            case 'demo-5': $folder = "/files/main-demo-5/";
                break;
                case 'demo-6': $folder = "/files/main-demo-6/";
                break;
        }
        //$folder = "/files/main/";

        $my_flooring_Import->import_widgets($folder.'widgets.txt');

        wp_die();
    }

    add_action('wp_ajax_flooring_widgetsImport', 'flooring_widgetsImport');
}

if(!function_exists('flooring_optionsImport'))
{
    function flooring_optionsImport()
    {
        global $my_flooring_Import;

        $folder = "/files/";
        if (!empty($_POST['example']))
            $folder = $_POST['example']."/";

        $my_flooring_Import->import_options($folder.'options.txt');

        wp_die();
    }

    add_action('wp_ajax_flooring_optionsImport', 'flooring_optionsImport');
}

if(!function_exists('flooring_otherImport'))
{
    function flooring_otherImport()
    {
        global $my_flooring_Import;

       /* if (!empty($_POST['example']))
            $folder = $_POST['example']."/";*/

            $demo = 'demo-1';
        if (!empty($_POST['example']))
            $demo = $_POST['example'];

        switch($demo){
            case 'demo-1': $folder = "main-demo-1/";
                break;
            case 'demo-2': $folder = "main-demo-2/";
                break;
	        case 'demo-3': $folder = "main-demo-3/";
		        break;
            case 'demo-4': $folder = "main-demo-4/";
		        break;
                case 'demo-5': $folder = "main-demo-5/";
		        break;
                case 'demo-6': $folder = "main-demo-6/";
		        break;
        }

        $my_flooring_Import->import_settings_pages($folder.'settingpages.txt');

        wp_die();
    }

    add_action('wp_ajax_flooring_otherImport', 'flooring_otherImport');
}

if (!function_exists('flooring_import_options')) {
    function flooring_import_options()
    {

        $demo = 'demo-1';
        if (!empty($_POST['example']))
            $demo = $_POST['example'];

        switch($demo){
            case 'demo-1':
                $file = 'a:64:{s:22:"flooring_primary_color";s:18:"rgba(182,112,42,1)";s:24:"flooring_secondary_color";s:18:"rgba(209,154,32,1)";s:18:"flooring_logo_path";s:84:"http://themes.webdevia.com/flooring/wp-content/themes/flooring/images/logo-white.png";s:26:"flooring_favicon_icon_path";s:81:"http://themes.webdevia.com/flooring/wp-content/themes/flooring/images/favicon.png";s:19:"flooring_menu_style";s:8:"creative";s:17:"flooring_facebook";s:1:"#";s:16:"flooring_twitter";s:1:"#";s:20:"flooring_google_plus";s:1:"#";s:26:"flooring_body_font_familly";s:9:"Open Sans";s:25:"flooring_body_font_weight";s:3:"300";s:31:"flooring_main-text-font-subsets";s:5:"latin";s:26:"flooring_head_font_familly";s:9:"Open Sans";s:34:"flooring_heading-font-weight-style";s:3:"700";s:34:"flooring_heading-text-font-subsets";s:5:"latin";s:32:"flooring_navigation_font_familly";s:9:"Open Sans";s:37:"flooring_navigation-font-weight-style";s:3:"400";s:37:"flooring_navigation-text-font-subsets";s:5:"latin";s:25:"flooring_theme_custom_css";s:0:"";s:24:"flooring_theme_custom_js";s:0:"";s:23:"flooring_footer_columns";s:12:"four_columns";s:21:"flooring_nav_bg_color";s:16:"rgba(0,0,0,0.45)";s:18:"flooring_copyright";s:37:"© 2022 Flooring All rights reserved.";s:28:"flooring_bg_single_post_path";s:0:"";s:14:"flooring_phone";s:4:"0000";s:26:"flooring_font-weight-style";s:3:"400";s:23:"flooring_text-transform";s:4:"none";s:23:"flooring_body-font-size";s:7:"default";s:26:"flooring_heading-transform";s:4:"none";s:29:"flooring_navigation-transform";s:4:"none";s:29:"flooring_navigation-font-size";s:7:"default";s:18:"flooring_nav_color";s:19:"rgba(255,255,255,1)";s:24:"flooring_nav_hover_color";s:18:"rgba(182,112,42,1)";s:26:"navigation_bg_color_sticky";s:15:"rgba(0,0,0,0.8)";s:23:"navigation_color_sticky";s:19:"rgba(255,255,255,1)";s:29:"navigation_color_hover_sticky";s:0:"";s:24:"flooring_show_adress_bar";s:2:"on";s:23:"flooring_footer_bg_path";s:0:"";s:14:"google_map_key";s:39:"AIzaSyDcmvSA1VvwVKgtNBzsswD3rzafLCrRcuk";s:15:"footer_bg_color";s:16:"rgba(56,56,56,1)";s:17:"footer_text_color";s:19:"rgba(255,255,255,1)";s:24:"flooring_body_font_style";s:6:"normal";s:23:"flooring_body_font_size";s:4:"12px";s:30:"flooring_body_font_weight_list";s:7:"300,400";s:39:"flooring_heading-font-weight-style-list";s:3:"700";s:29:"flooring_navigation_font_size";s:4:"12px";s:42:"flooring_navigation-font-weight-style-list";s:3:"400";s:23:"flooring_bg_single_page";s:0:"";s:22:"flooring_show_min_cart";s:3:"off";s:25:"flooring_page_title_style";s:7:"style_1";s:25:"footer_copyright_bg_color";s:0:"";s:27:"footer_copyright_text_color";s:0:"";s:20:"flooring_menu_sticky";s:3:"off";s:16:"socialmedia_name";s:0:"";s:11:"social_icon";s:0:"";s:23:"flooring_footer_bg_size";s:6:"repeat";s:21:"flooring_footer_style";s:6:"style1";s:11:"logo_height";s:2:"50";s:23:"flooring_headings_color";s:0:"";s:16:"flooring_address";s:0:"";s:13:"flooring_work";s:0:"";s:6:"button";s:0:"";s:20:"flooring_button_link";s:0:"";s:27:"flooring_language_area_html";s:1:" ";s:31:"flooring_header_contain_to_grid";s:1:"1";}';
           break;
            case 'demo-2':
                $file = 'a:64:{s:22:"flooring_primary_color";s:18:"rgba(182,112,42,1)";s:24:"flooring_secondary_color";s:18:"rgba(209,154,32,1)";s:18:"flooring_logo_path";s:87:"https://themes.webdevia.com/flooring/demo-2/wp-content/uploads/sites/2/2022/07/logo.png";s:26:"flooring_favicon_icon_path";s:81:"http://themes.webdevia.com/flooring/wp-content/themes/flooring/images/favicon.png";s:19:"flooring_menu_style";s:8:"creative";s:17:"flooring_facebook";s:1:"#";s:16:"flooring_twitter";s:1:"#";s:20:"flooring_google_plus";s:1:"#";s:26:"flooring_body_font_familly";s:9:"Open Sans";s:25:"flooring_body_font_weight";s:3:"300";s:31:"flooring_main-text-font-subsets";s:5:"latin";s:26:"flooring_head_font_familly";s:9:"Open Sans";s:34:"flooring_heading-font-weight-style";s:3:"700";s:34:"flooring_heading-text-font-subsets";s:5:"latin";s:32:"flooring_navigation_font_familly";s:9:"Open Sans";s:37:"flooring_navigation-font-weight-style";s:3:"400";s:37:"flooring_navigation-text-font-subsets";s:5:"latin";s:25:"flooring_theme_custom_css";s:0:"";s:24:"flooring_theme_custom_js";s:0:"";s:23:"flooring_footer_columns";s:12:"four_columns";s:21:"flooring_nav_bg_color";s:16:"rgba(0,0,0,0.45)";s:18:"flooring_copyright";s:37:"© 2022 Flooring All rights reserved.";s:28:"flooring_bg_single_post_path";s:0:"";s:14:"flooring_phone";s:4:"0000";s:26:"flooring_font-weight-style";s:3:"400";s:23:"flooring_text-transform";s:4:"none";s:23:"flooring_body-font-size";s:7:"default";s:26:"flooring_heading-transform";s:4:"none";s:29:"flooring_navigation-transform";s:4:"none";s:29:"flooring_navigation-font-size";s:7:"default";s:18:"flooring_nav_color";s:19:"rgba(255,255,255,1)";s:24:"flooring_nav_hover_color";s:18:"rgba(182,112,42,1)";s:26:"navigation_bg_color_sticky";s:15:"rgba(0,0,0,0.8)";s:23:"navigation_color_sticky";s:19:"rgba(255,255,255,1)";s:29:"navigation_color_hover_sticky";s:0:"";s:24:"flooring_show_adress_bar";s:2:"on";s:23:"flooring_footer_bg_path";s:0:"";s:14:"google_map_key";s:39:"AIzaSyDcmvSA1VvwVKgtNBzsswD3rzafLCrRcuk";s:15:"footer_bg_color";s:16:"rgba(56,56,56,1)";s:17:"footer_text_color";s:19:"rgba(255,255,255,1)";s:24:"flooring_body_font_style";s:6:"normal";s:23:"flooring_body_font_size";s:4:"12px";s:30:"flooring_body_font_weight_list";s:7:"300,400";s:39:"flooring_heading-font-weight-style-list";s:3:"700";s:29:"flooring_navigation_font_size";s:4:"12px";s:42:"flooring_navigation-font-weight-style-list";s:3:"400";s:23:"flooring_bg_single_page";s:0:"";s:22:"flooring_show_min_cart";s:3:"off";s:25:"flooring_page_title_style";s:7:"style_1";s:25:"footer_copyright_bg_color";s:0:"";s:27:"footer_copyright_text_color";s:0:"";s:20:"flooring_menu_sticky";s:3:"off";s:16:"socialmedia_name";s:0:"";s:11:"social_icon";s:0:"";s:23:"flooring_footer_bg_size";s:6:"repeat";s:21:"flooring_footer_style";s:6:"style1";s:11:"logo_height";s:2:"50";s:23:"flooring_headings_color";s:0:"";s:16:"flooring_address";s:0:"";s:13:"flooring_work";s:0:"";s:6:"button";s:0:"";s:20:"flooring_button_link";s:0:"";s:27:"flooring_language_area_html";s:1:" ";s:31:"flooring_header_contain_to_grid";s:1:"1";}';
                break;
	        case 'demo-3':
		        $file = 'a:64:{s:22:"flooring_primary_color";s:18:"rgba(182,112,42,1)";s:24:"flooring_secondary_color";s:18:"rgba(209,154,32,1)";s:18:"flooring_logo_path";s:84:"http://themes.webdevia.com/flooring/wp-content/themes/flooring/images/logo-white.png";s:26:"flooring_favicon_icon_path";s:81:"http://themes.webdevia.com/flooring/wp-content/themes/flooring/images/favicon.png";s:19:"flooring_menu_style";s:8:"creative";s:17:"flooring_facebook";s:1:"#";s:16:"flooring_twitter";s:1:"#";s:20:"flooring_google_plus";s:1:"#";s:26:"flooring_body_font_familly";s:9:"Open Sans";s:25:"flooring_body_font_weight";s:3:"300";s:31:"flooring_main-text-font-subsets";s:5:"latin";s:26:"flooring_head_font_familly";s:9:"Open Sans";s:34:"flooring_heading-font-weight-style";s:3:"700";s:34:"flooring_heading-text-font-subsets";s:5:"latin";s:32:"flooring_navigation_font_familly";s:9:"Open Sans";s:37:"flooring_navigation-font-weight-style";s:3:"400";s:37:"flooring_navigation-text-font-subsets";s:5:"latin";s:25:"flooring_theme_custom_css";s:0:"";s:24:"flooring_theme_custom_js";s:0:"";s:23:"flooring_footer_columns";s:12:"four_columns";s:21:"flooring_nav_bg_color";s:16:"rgba(0,0,0,0.45)";s:18:"flooring_copyright";s:37:"© 2022 Flooring All rights reserved.";s:28:"flooring_bg_single_post_path";s:0:"";s:14:"flooring_phone";s:4:"0000";s:26:"flooring_font-weight-style";s:3:"400";s:23:"flooring_text-transform";s:4:"none";s:23:"flooring_body-font-size";s:7:"default";s:26:"flooring_heading-transform";s:4:"none";s:29:"flooring_navigation-transform";s:4:"none";s:29:"flooring_navigation-font-size";s:7:"default";s:18:"flooring_nav_color";s:19:"rgba(255,255,255,1)";s:24:"flooring_nav_hover_color";s:18:"rgba(182,112,42,1)";s:26:"navigation_bg_color_sticky";s:15:"rgba(0,0,0,0.8)";s:23:"navigation_color_sticky";s:19:"rgba(255,255,255,1)";s:29:"navigation_color_hover_sticky";s:0:"";s:24:"flooring_show_adress_bar";s:2:"on";s:23:"flooring_footer_bg_path";s:0:"";s:14:"google_map_key";s:39:"AIzaSyDcmvSA1VvwVKgtNBzsswD3rzafLCrRcuk";s:15:"footer_bg_color";s:16:"rgba(56,56,56,1)";s:17:"footer_text_color";s:19:"rgba(255,255,255,1)";s:24:"flooring_body_font_style";s:6:"normal";s:23:"flooring_body_font_size";s:4:"12px";s:30:"flooring_body_font_weight_list";s:7:"300,400";s:39:"flooring_heading-font-weight-style-list";s:3:"700";s:29:"flooring_navigation_font_size";s:4:"12px";s:42:"flooring_navigation-font-weight-style-list";s:3:"400";s:23:"flooring_bg_single_page";s:0:"";s:22:"flooring_show_min_cart";s:3:"off";s:25:"flooring_page_title_style";s:7:"style_1";s:25:"footer_copyright_bg_color";s:0:"";s:27:"footer_copyright_text_color";s:0:"";s:20:"flooring_menu_sticky";s:3:"off";s:16:"socialmedia_name";s:0:"";s:11:"social_icon";s:0:"";s:23:"flooring_footer_bg_size";s:6:"repeat";s:21:"flooring_footer_style";s:6:"style1";s:11:"logo_height";s:2:"50";s:23:"flooring_headings_color";s:0:"";s:16:"flooring_address";s:0:"";s:13:"flooring_work";s:0:"";s:6:"button";s:0:"";s:20:"flooring_button_link";s:0:"";s:27:"flooring_language_area_html";s:1:" ";s:31:"flooring_header_contain_to_grid";s:1:"1";}';
                 break;
           case 'demo-4':  
                  $file = 'a:57:{s:22:"flooring_primary_color";s:0:"";s:24:"flooring_secondary_color";s:0:"";s:18:"flooring_nav_color";s:19:"rgba(255,255,255,1)";s:24:"flooring_nav_hover_color";s:0:"";s:18:"flooring_logo_path";s:87:"https://themes.webdevia.com/flooring/demo-2/wp-content/uploads/sites/2/2022/07/logo.png";s:26:"flooring_favicon_icon_path";s:0:"";s:19:"flooring_menu_style";s:8:"creative";s:22:"flooring_show_min_cart";s:0:"";s:17:"flooring_facebook";s:0:"";s:16:"flooring_twitter";s:0:"";s:20:"flooring_google_plus";s:0:"";s:26:"flooring_body_font_familly";s:9:"Open Sans";s:25:"flooring_body_font_weight";s:3:"300";s:31:"flooring_main-text-font-subsets";s:9:"latin-ext";s:26:"flooring_head_font_familly";s:5:"Chivo";s:34:"flooring_heading-font-weight-style";s:3:"700";s:34:"flooring_heading-text-font-subsets";s:5:"latin";s:32:"flooring_navigation_font_familly";s:9:"Work Sans";s:37:"flooring_navigation-font-weight-style";s:3:"600";s:37:"flooring_navigation-text-font-subsets";s:9:"latin-ext";s:25:"flooring_theme_custom_css";s:0:"";s:24:"flooring_theme_custom_js";s:0:"";s:23:"flooring_footer_columns";s:12:"four_columns";s:21:"flooring_nav_bg_color";s:13:"rgba(0,0,0,0)";s:18:"flooring_copyright";s:37:"© 2022 Flooring All rights reserved.";s:28:"flooring_bg_single_post_path";s:0:"";s:23:"flooring_bg_single_page";s:96:"http://themes.webdevia.com/flooring/demo-2/wp-content/uploads/sites/2/2019/11/Repeat-Grid-38.png";s:14:"google_map_key";s:0:"";s:26:"navigation_bg_color_sticky";s:19:"rgba(255,255,255,1)";s:23:"navigation_color_sticky";s:19:"rgba(255,255,255,1)";s:29:"navigation_color_hover_sticky";s:0:"";s:15:"footer_bg_color";s:13:"rgba(2,2,2,1)";s:17:"footer_text_color";s:0:"";s:24:"flooring_show_adress_bar";s:0:"";s:16:"socialmedia_name";s:0:"";s:11:"social_icon";s:0:"";s:14:"flooring_phone";s:0:"";s:23:"flooring_footer_bg_path";s:87:"http://themes.webdevia.com/flooring/demo-2/wp-content/uploads/sites/2/2019/11/motif.jpg";s:24:"flooring_body_font_style";s:6:"normal";s:23:"flooring_body_font_size";s:4:"16px";s:30:"flooring_body_font_weight_list";s:11:"400,600,700";s:39:"flooring_heading-font-weight-style-list";s:7:"400,700";s:25:"flooring_page_title_style";s:7:"style_1";s:29:"flooring_navigation_font_size";s:4:"14px";s:42:"flooring_navigation-font-weight-style-list";s:11:"400,600,700";s:20:"flooring_menu_sticky";s:0:"";s:23:"flooring_footer_bg_size";s:6:"repeat";s:25:"footer_copyright_bg_color";s:13:"rgba(0,0,0,1)";s:27:"footer_copyright_text_color";s:19:"rgba(255,255,255,1)";s:21:"flooring_footer_style";s:6:"style2";s:11:"logo_height";s:2:"40";s:23:"flooring_headings_color";s:0:"";s:16:"flooring_address";s:0:"";s:13:"flooring_work";s:0:"";s:6:"button";s:0:"";s:20:"flooring_button_link";s:0:"";s:27:"flooring_language_area_html";s:1:" ";}';
                   break;
           case 'demo-5' :
            $file=array(
            'flooring_primary_color' => 'rgba(157,130,86,1)',
            'flooring_secondary_color' => '',
            'flooring_nav_color' => 'rgba(255,255,255,1)',
            'flooring_nav_hover_color' =>' rgba(157,130,86,1)',
            'footer_bg_color' => 'rgba(64,62,70,1)',
            'flooring_logo_path' => 'http://themes.webdevia.com/flooring/store-tile/wp-content/uploads/sites/4/2021/06/logo@2x-3.png',
            'flooring_favicon_icon_path' => '',
            'flooring_menu_style' => 'creative',
            'flooring_show_min_cart' => '1',
            'flooring_facebook' => '',
            'flooring_twitter' => '',
            'flooring_google_plus' => '',
            'flooring_body_font_familly' => 'Lato',
            'flooring_body_font_weight' => '400',
            'flooring_main-text-font-subsets' => 'latin-ext',
            'flooring_head_font_familly' =>  'Nunito Sans',
            'flooring_heading-font-weight-style' => '900',
            'flooring_heading-text-font-subsets' => 'latin-ext',
            'flooring_navigation_font_familly' => 'Nunito Sans',
            'flooring_navigation-font-weight-style' => '600',
            'flooring_navigation-text-font-subsets' => 'latin-ext',
            'flooring_theme_custom_css' => '',
            'flooring_theme_custom_js' => '',
            'flooring_footer_columns' => 'four_columns',
            'flooring_nav_bg_color' => 'rgba(255,255,255,0)',
            'flooring_copyright' => '&copy; 2021 All rights reserved.',
            'logo_height' => '57',
            'flooring_bg_single_post_path' => 'http://themes.webdevia.com/flooring/store-tile/wp-content/uploads/sites/4/2021/06/service-bg.jpg',
            'flooring_bg_single_page' => 'http://themes.webdevia.com/flooring/store-tile/wp-content/uploads/sites/4/2021/06/service-bg.jpg',
            'google_map_key' => '',
            'flooring_headings_color' => 'rgba(22,22,24,1)',
            'navigation_bg_color_sticky' => 'rgba(60,59,65,1)',
            'navigation_color_sticky' => 'rgba(255,255,255,1)',
            'navigation_color_hover_sticky' => 'rgba(157,130,86,1)',
            'footer_text_color' => 'rgba(255,255,255,1)',
            'footer_copyright_bg_color' => '',
            'footer_copyright_text_color' => '',
            'flooring_menu_sticky' => '1',
            'flooring_show_adress_bar' => '',
            'socialmedia_name' => '',
            'social_icon' => '',
            'flooring_address' => '',
            'flooring_work' => '',
            'flooring_phone' => '',
            'button' => '',
            'flooring_button_link' => '',
            'flooring_language_area_html' => '',                   
            'flooring_footer_bg_path' => '',
            'flooring_footer_bg_size' => 'repeat',
            'flooring_footer_style' => 'style1',
            'flooring_body_font_style' => 'normal',
            'flooring_body_font_size' => '16px',
            'flooring_body_font_weight_list' => '400,700,900',
            'flooring_heading-font-weight-style-list' => '600,700,800,900',
            'flooring_navigation_font_size' => '16px',
            'flooring_navigation-font-weight-style-list' =>'',
            'flooring_theme_custom_css'=> '.creative-layout .sticky {background: var(--topbar-sticky-bg);}a.btn-border {
                  background: rgb(0 0 0 / 77%);
                border-radius: 26px;
                color: #d7bc91;
                position: relative;
                margin-bottom: 7px;
                border: none;
              }
              .top-bar-left .menu-text a {
                padding: 0;
              }
              /* Mobile Logo */
              .title-bar .title-bar-title img {
                max-height: 57px;
              }
              a.btn-border:after {
                position: absolute;
                top: -2px;
                bottom: -2px;
                left: -2px;
                right: -2px;
                background: linear-gradient(to right, #ffc739, #c78a25);
                content: "";
                z-index: -1;
                border-radius: 26px;
                  transition: all .5s ease-in-out;
              }
              a.btn-border:hover:after {
                    background: linear-gradient(to right, #ffc739 50%, #c78a25 120%);
              }
              
              .overflow-visible {
                  overflow: visible;
              }
              .numbers-movedup {
                margin-left: -25px;
                margin-right: -25px;
                z-index: 9;
                box-shadow: 0 5px 20px rgb(0 0 0 / 10%);
              }
              @media only screen and (min-with: 664px) and (max-with:1024px) {
              .numbers-movedup {
                  transform: translate(12%, 40px) scale(1.135);
              }
              }
              @media only screen and (min-width: 1024px) {
                  .numbers-movedup {
                    transform: translate(22%, 80px) scale(1.35);
                  }
              }
              .numbers-movedup .vc_column-inner {
                padding: 15px !important;
              }
              .numbers-movedup .wd-fucts {
                margin-bottom: 0;
              }
              .numbers-movedup .wd-fucts .icon {
                display: none;
              }
              .numbers-movedup .wd-fucts .title {
                padding-top: 0;
              }
              
              .wd-image-text.style4 .service-img-box {
                border: 1px solid #DDD;
                transition: .3s;
                border-radius: 6px;
                overflow: hidden;
                box-shadow: 0 5px 20px rgb(0 0 0 / 4%);
              }
              
              .wd-image-text.style4 .service-img-box:hover {
                border: 1px solid #DDD;
                transition: .3s;
                border-radius: 6px;
                overflow: hidden;
                box-shadow: 0 10px 50px rgb(0 0 0 / 16%);
              }
              h1, h2, h3, h4, h5, h6, .menu-list a {
                font-family: "Playfair Display";
                font-weight: 900;
              }
              .wd-heading h2 span:after, .wd-heading h3 span:after, .wd-heading h4 span:after, .wd-heading h5 span:after, .wd-heading h6 span:after,
              .free-quote input.wpcf7-submit,
              .woocommerce .products .product.type-product .button {
                background: linear-gradient(
              45deg
              , #ffd183, #ce9e49);
                 background: linear-gradient( 
              45deg
               , #ffd183, #ce9e49);
                font-weight: 700;
                letter-spacing: 0;
                font-size: 17px;
                  color: #000;
                  border-radius: 30px;
              }
              .woocommerce .products .product.type-product .woocommerce-LoopProduct-link {
                text-align: left;
              }
              .woocommerce .products .product.type-product .woocommerce-LoopProduct-link .woocommerce-loop-product__title {
                font-size: 20px;
              }
              .wd-footer > div {
                padding-top: 30px;
                padding-bottom: 50px;
              }
              .wd-copyright {
                background-color: #3c3b41;
              }
              .wd-copyright.footer-style1 > .row {
                border-top: none;
              }
            ' );
                  break; 
                  case 'demo-6' :
                    $file=array ( 'flooring_primary_color' => '', 'flooring_secondary_color' => '', 'flooring_nav_color' => 'rgba(51,51,51,1)', 'flooring_nav_hover_color' => '', 'footer_bg_color' => 'rgba(25,25,25,1)', 'flooring_logo_path' => 'https://themes.webdevia.com/flooring/woodworking/wp-content/uploads/sites/3/2014/08/logo-woody.jpg', 'flooring_favicon_icon_path' => '', 'flooring_menu_style' => 'corporate', 'flooring_show_min_cart' => '1', 'flooring_facebook' => '', 'flooring_twitter' => '', 'flooring_google_plus' => '', 'flooring_body_font_familly' => 'Lato', 'flooring_body_font_weight' => '400', 'flooring_main-text-font-subsets' => 'latin-ext', 'flooring_head_font_familly' => 'Nunito Sans', 'flooring_heading-font-weight-style' => '900', 'flooring_heading-text-font-subsets' => 'latin-ext', 'flooring_navigation_font_familly' => 'Nunito Sans', 'flooring_navigation-font-weight-style' => '600', 'flooring_navigation-text-font-subsets' => 'latin-ext', 'flooring_theme_custom_css' => '', 'flooring_theme_custom_js' => '', 'flooring_footer_columns' => 'four_columns', 'flooring_nav_bg_color' => 'rgba(255,255,255,1)', 'flooring_copyright' => '© 2022 All rights reserved.', 'flooring_bg_single_post_path' => '', 'flooring_bg_single_page' => '', 'google_map_key' => '', 'navigation_bg_color_sticky' => 'rgba(255,255,255,1)', 'navigation_color_sticky' => 'rgba(51,51,51,1)', 'navigation_color_hover_sticky' => 'rgba(182,112,42,1)', 'footer_text_color' => 'rgba(255,255,255,1)', 'footer_copyright_bg_color' => '', 'footer_copyright_text_color' => '', 'flooring_menu_sticky' => '1', 'flooring_show_adress_bar' => '', 'socialmedia_name' => '', 'social_icon' => '', 'flooring_phone' => '+1-458-362-1258', 'flooring_footer_bg_path' => '', 'flooring_footer_bg_size' => 'repeat', 'flooring_footer_style' => 'style1', 'flooring_body_font_style' => 'normal', 'flooring_body_font_size' => '16px', 'flooring_body_font_weight_list' => '400,700,900', 'flooring_heading-font-weight-style-list' => '400,600,700,800,900', 'flooring_navigation_font_size' => '16px', 'flooring_navigation-font-weight-style-list' => '', 'flooring_address' => '547 Nice St, San Diego, CA, USA', 'flooring_work' => 'Office Hour: 09:00am - 4:00pm', 'button' => 'Request Quote', 'flooring_button_link' => '/flooring/woodworking/contact', 'flooring_language_area_html' => ' ', 'flooring_headings_color' => 'rgba(51,31,0,1)', 'logo_height' => '', );
                          break;               
        }


        $options_array = array();

        if($demo == 'demo-5' or $demo == 'demo-6') {
            $options_array = $file;
        } else {
            $options_array = unserialize($file);
        }
       
        update_option("flooring_options_array",$options_array);

    }
    add_action('wp_ajax_flooring_import_options', 'flooring_import_options');
}

function delete_nav_menus(){
    $menus_list=get_terms( 'nav_menu', array( 'hide_empty' => false ) );
    foreach($menus_list as $menu){
        wp_delete_nav_menu($menu->term_id);
    }
}