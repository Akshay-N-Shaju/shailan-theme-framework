<?php 

include_once('app/stf-framework.php'); // Include framework
  
if(! function_exists('theme_setup')) {
function theme_setup(){

	// Post Thumbnails & Custom Image Sizes
	add_theme_support( 'post-thumbnails', array('post', 'page') ); // Add any other custom post types here
	set_post_thumbnail_size( '200', '200', true );

	// Navigation Menus
	add_theme_support( 'nav_menus' );
	register_nav_menu( 'topnav', 'Top Navigation' );
	register_nav_menu( 'main', 'Header Navigation' );
	register_nav_menu( 'footer', 'Footer Navigation' );
	
	// Automatic feed links
	add_theme_support( 'automatic-feed-links' );

	// Post Formats
	add_theme_support( 'post-formats', array( 'aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video', 'audio' ) );
	
	// Editor Style
	add_editor_style( 'editor.css' );
	
	// Enable custom background
	add_custom_background();
	
	// Languages
	load_theme_textdomain( 'stf', TEMPLATEPATH . '/lang' );
	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/lang/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

} add_action('after_setup_theme', 'theme_setup');
}

function top_nav_callback(){
	echo "<div id=\"shailan-dropdown-menu\" class=\"dm-align-right\"><table><tr><td>";
	echo "<ul class=\"dropdown dropdown-horizontal\">";

	$args = array(
	'depth'        => 0,
	'show_date'    => '',
	'date_format'  => get_option('date_format'),
	'child_of'     => 0,
	'exclude'      => '',
	'include'      => '',
	'title_li'     => '',
	'echo'         => 1,
	'authors'      => '',
	'sort_column'  => 'menu_order, post_title',
	'link_before'  => '',
	'link_after'   => '',
	'walker'       => '' );
	
	wp_list_pages( $args );
	
	echo "</ul></td></tr></table></div>";
}

function nav_callback(){

	echo "<div id=\"shailan-dropdown-menu\" class=\"dm-align-left\"><table><tr><td>";
	echo "<ul class=\"dropdown dropdown-horizontal\">";

	$args = array(
    'orderby'            => 'name',
    'order'              => 'ASC',
    'style'              => 'list',
    'show_count'         => 0,
    'hide_empty'         => 1,
    'use_desc_for_title' => 0,
    'exclude'            => '',
    'exclude_tree'       => '',
    'include'            => '',
    'hierarchical'       => true,
    'title_li'           => '',
    'echo'               => 1,
    'depth'              => 4,
    'current_category'   => 1,
    'pad_counts'         => 0,
    'taxonomy'           => 'category',
    'number'             => 12
	);
	
	wp_list_categories( $args );
		
	echo "</ul></td></tr></table></div>";
}