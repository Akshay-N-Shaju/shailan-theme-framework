<?php
/** SHAILAN THEME FRAMEWORK 
 Author		: Matt Say

 Author URL	: http://shailan.com
 Version	: 1.0
 Contact	: metinsaylan (at) gmail (dot) com
*/

global $stf;
global $stf_default_options;
global $theme_data;
global $stf_widget_areas; 

define('STF_DIRECTORY', dirname(__FILE__) . '/');

$url = get_template_directory_uri();

$dir = str_replace('\\' ,'/', STF_DIRECTORY); 
$dir = preg_replace('|/+|', '/', $dir);
$dir = basename($dir);

if ( 0 === strpos($url, 'http') && is_ssl() ){
	$url = str_replace( 'http://', 'https://', $url );} 

define('STF_URL', $url . '/app/');
define('STF_APP', STF_DIRECTORY );

// Framework class
class Shailan_Framework{

	function __construct(){
		global $stf_widget_areas;
		global $stf_default_options;
		
		$stf_widget_areas = array();
		
		// Framework version
		$this->version = "1.0";
		
		// Get theme data
		$this->stylesheet = get_stylesheet();
		$theme_data = get_theme_data( get_stylesheet_directory() . '/style.css' );		
		$this->theme = $theme_data;
		$this->name = $this->theme['Name'];
		
		$this->is_child = false; // Am I a child?
		if(TEMPLATEPATH !== STYLESHEETPATH)
			$this->is_child = true; 
		
		// Load shortcodes, widgets, template tags
		require_once( "stf-loader.php" );
		
		// Load default options
		//locate_template( array('stf-options.php'), true, true );
		require_once( "stf-options.php" );
		
		$this->default_options = $options;
		foreach( $options as $option ){
			if( isset($option['id']) ){
				$stf_default_options[ $option['id'] ] = $option['std'];
			}
		}
		
		$this->settings = $this->get_settings();
		
		add_action( 'admin_init', array(&$this, 'theme_admin_init') );
		add_action( 'admin_menu', array(&$this, 'theme_admin_header') );
		add_action( 'wp_footer', array(&$this, 'framework_copyright') );
		
		if(is_admin()) {
			wp_enqueue_script( "jquery" );
			wp_enqueue_script( "tweetable", get_template_directory_uri() . '/app/scripts/jquery.tweetable.js', 'jquery' );
			wp_enqueue_style( "tweetable", get_template_directory_uri() . '/app/css/tweetable.css' );
			wp_enqueue_style( "google-droid-sans", "http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold&v1", false, "1.0", "all");
			wp_enqueue_style( "stf-admin-styles", get_template_directory_uri() . "/app/css/admin.css", false, "1.0", "all");
		}
			
		
	}
	
	function Shailan_Framework(){ // PHP 4 Constructor
		$this->__construct();
	}
	
	function get_settings(){
		// Get settings
		$settings = get_option('stf_settings');		
		
		if(FALSE === $settings){ // Options doesn't exist, install standard settings
			// Create settings array
			$settings = array();
			// Set default values
			foreach($this->default_options as $option){
				$settings[ $option['id'] ] = $option['std'];
			}
			$settings['stf_version'] = $this->version;
			// Save the settings
			update_option('stf_settings', $settings);
		} else { // Options exist, update if necessary
			// Everythings gonna be alright. Return.
			return $settings;
		}		
	}
	
	function register_theme_options($options){
		$this->default_options = $options;
	}
	
	function extend_options($options){
		$this->default_options = array_merge((array)$options, (array)$this->default_options);
	}
	
	function theme_admin_init(){
		$file_dir = get_bloginfo('template_directory');
		 
		wp_enqueue_style("stf-options-page", STF_URL . "css/options.css", false, "1.0", "all");
		wp_enqueue_style("stf-widgets-mod", STF_URL . "css/widgets.css", false, "1.0", "all");
		wp_enqueue_style("stf-options-tabs", STF_URL . "css/options-tabs.css", false, "1.0", "all");
		
		wp_enqueue_script("jquery");
		wp_enqueue_script("jwysiwyg", STF_URL . "scripts/jquery.wysiwyg.js", "jquery", "1.0", false);
		wp_enqueue_style("jwysiwyg-css", STF_URL . "scripts/jquery.wysiwyg.css", false, "1.0", "all");

	}
	
	function theme_admin_header(){
		global $menu;
	
		if ( @$_GET['page'] == "stf-options" ) {
		
			if ( @$_REQUEST['action'] && 'save' == $_REQUEST['action'] ) {
				// Save settings
				// Get settings array
				$settings = get_option('stf_settings'); 
				
				if(FALSE === $settings){ $settings = array(); }
				
				// Set updated values
				foreach($this->default_options as $option){					
					if($option['type'] == 'checkbox' && empty( $_REQUEST[ $option['id'] ] )) {
						$settings[ $option['id'] ] = 'off';
					} else {
						$settings[ $option['id'] ] = $_REQUEST[ $option['id'] ]; 
					}
				}
				
				// Save the settings
				update_option('stf_settings', $settings);
				
				// Update instance settings array
				$this->settings = $settings;
									
				header("Location: admin.php?page=stf-options&saved=true");
				die;
			} else if( @$_REQUEST['action'] && 'reset' == $_REQUEST['action'] ) {
				
				// Start a new settings array
				$settings = array();
				
				// Set standart values
				foreach($this->default_options as $option){
					$settings[$option['id']] = $option['std']; }
				
				// Save the settings
				update_option('stf_settings', $settings);
				
				// Update instance settings array
				$this->settings = $settings;
				
				header("Location: admin.php?page=theme-options&reset=true");
				die;
			}
		}

		$menu[56] = array( '', 'read', 'separator1', '', 'wp-menu-separator' );
		add_menu_page( $this->name . " Options", $this->name, "administrator", "stf-options", array(&$this, 'theme_admin_page'), get_template_directory_uri() . "/app/css/images/layout_content.png", 57 );
		
	}
	
	function theme_admin_page(){
	
		$options = $this->default_options;
		$current = $this->get_settings();
		$title = $this->name . ' Theme Settings';	
		
		$navigation = "";
		$footer_text = "<a href=\"" . $this->theme['URI'] . "\">". $this->name . "</a> is powered by <a href=\"http://shailan.com/wordpress/themes/framework\" title=\"Shailan Theme Framework\">Shailan Theme Framework</a>";
		
		// Render theme options page
		include_once( STF_APP . "stf-page-options.php" );
		
	}
	
	function framework_copyright(){ ?>
		<div id="theme-copyright"><small>Powered by <a href="http://wordpress.org" rel="external" target="_blank">Wordpress</a> <span class="amp">&</span> <a href="http://shailan.com/wordpress/themes/framework" title="Wordpress themes, plugins, widgets and more" rel="external" target="_blank">Shailan</a></small></div>
	<?php }
	
};

$stf = new Shailan_Framework();

function stf_get_setting( $key, $default = FALSE ){
	$settings = get_option('stf_settings');
	
	if(isset($settings[$key])){
		$value = $settings[$key];
		return $value;
	} elseif(stf_get_default_setting( $key )) {
		return stf_get_default_setting( $key );
	} else { 	
		return $default;
	}
}

function stf_get_default_setting( $key ){
	global $stf_default_options;
	if( isset( $stf_default_options[$key] ) ){
		return $stf_default_options[$key];
	} else {
		return FALSE;
	}
}

function stf_update_setting( $key, $value ){
	$settings = get_option('stf_settings');
	$settings[$key] = $value;
	update_option('stf_settings', $settings);
}

function stf_adminbar_button() {
    global $wp_admin_bar, $wpdb;
    if ( !is_super_admin() || !is_admin_bar_showing() )
        return;

    $wp_admin_bar->add_menu( array( 'parent' => 'appearance', 'title' => 'Theme Options', 'href' => admin_url('admin.php?page=stf-options') ) );
}
add_action( 'admin_bar_menu', 'stf_adminbar_button', 1000 );


