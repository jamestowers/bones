<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

/*
1. library/bones.php
	- head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
	- custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once( 'library/bones.php' ); // if you remove this, bones will break
/*
2. library/custom-post-type.php
	- an example custom post type
	- example custom taxonomy (like categories)
	- example custom taxonomy (like tags)
*/
#require_once( 'library/custom-post-type.php' ); // you can disable this if you like
/*
3. library/admin.php
	- removing some default WordPress dashboard widgets
	- an example custom dashboard widget
	- adding custom login css
	- changing text in footer of admin
*/
// require_once( 'library/admin.php' ); // this comes turned off by default
/*
4. library/translation/translation.php
	- adding support for other languages
*/
// require_once( 'library/translation/translation.php' ); // this comes turned off by default

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );

/*
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
*/

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-600' => __('600px by 150px'),
        'bones-thumb-300' => __('300px by 100px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select 
the new images sizes you have just created from within the media manager 
when you add media to your content blocks. If you add more image sizes, 
duplicate one of the lines in the array and name it according to your 
new image size.
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<aside id="%1$s" class="widget box %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));

	
	register_sidebar(array(
		'id' => 'footer-sidebar',
		'name' => __( 'Footer Widgets', 'bonestheme' ),
		'description' => __( 'Room for 3 widgets just above the footer on every page', 'bonestheme' ),
		'before_widget' => '<aside id="%1$s" class="widget box %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
} // don't remove this bracket!



add_action( 'admin_init', 'my_remove_menu_pages' );
function my_remove_menu_pages() {
	global $user_ID;

  if ( !current_user_can( 'install_themes' ) ) {
		remove_menu_page('edit.php'); // Posts
		remove_menu_page('plugins.php'); // Plugins
		remove_menu_page('themes.php'); // Appearance
		remove_menu_page('tools.php'); // Tools
		remove_menu_page('mf_dispatcher'); // Tools
		remove_menu_page('wpcf7'); // Tools
  }
  remove_menu_page('upload.php'); // Media
  remove_menu_page('link-manager.php'); // Links
  remove_menu_page('edit-comments.php'); // Comments
}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
function remove_dashboard_widgets() {
	global $wp_meta_boxes;

	if ( !current_user_can( 'install_themes' ) ) {
  	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
  	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	}

}


if(!function_exists('log_it')){
	function log_it( $message ) {
		if( WP_DEBUG === true ){
			if( is_array( $message ) || is_object( $message ) ){
				error_log( print_r( $message, true ) );
			} else {
				error_log( $message );
			}
		}
	}
}

?>
