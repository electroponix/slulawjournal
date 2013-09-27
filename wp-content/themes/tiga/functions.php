<?php
/**
 * Theme functions file
 *
 * Contains all of the Theme's setup functions, custom functions,
 * custom Widgets, custom hooks, and Theme settings.
 * 
 * @package Tiga
 * @author Satrya
 * @license docs/license.txt
 * @since 0.0.1
 *
 */

/* Defines constants used by the theme. */
add_action( 'after_setup_theme', 'tiga_constants' );

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'tiga_setup' );

/* Load additional libraries a little later. */
add_action( 'after_setup_theme', 'tiga_load_libraries', 11 );

/**
 * Defines constants used by the theme.
 * 
 * @since 1.7
 */
function tiga_constants() {

	/* Sets the theme version number. */
	define( 'TIGA_VERSION', 1.9 );

	/* Sets the path to the theme directory. */
	define( 'THEME_DIR', get_template_directory() );

	/* Sets the path to the theme directory URI. */
	define( 'THEME_URI', get_template_directory_uri() );

	/* Sets the path to the admin directory. */
	define( 'TIGA_ADMIN', trailingslashit( THEME_DIR ) . 'admin' );

	/* Sets the path to the includes directory. */
	define( 'TIGA_INCLUDES', trailingslashit( THEME_DIR ) . 'includes' );

	/* Sets the path to the img directory. */
	define( 'TIGA_IMAGE', trailingslashit( THEME_URI ) . 'img' );

	/* Sets the path to the css directory. */
	define( 'TIGA_CSS', trailingslashit( THEME_URI ) . 'css' );

	/* Sets the path to the js directory. */
	define( 'TIGA_JS', trailingslashit( THEME_URI ) . 'js' );

}

/**
 * Theme setup function. This function adds support for theme features and defines the default theme
 * actions and filters.
 * 
 * @since 0.0.1
 */
function tiga_setup() {

	global $content_width;
		
	/* Set the content width based on the theme's design and stylesheet. */
	if ( ! isset( $content_width ) ) $content_width = 620;

	/* Embed width defaults. */
	add_filter( 'embed_defaults', 'tiga_embed_defaults' );
	
	/* Make tiga available for translation. */
	load_theme_textdomain( 'tiga', trailingslashit( THEME_DIR ) . 'languages' );

	/* WordPress theme support */
	add_editor_style();
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 
		'custom-background',
		array(
			'default-image' => trailingslashit( TIGA_IMAGE ) . 'pattern.png',
		)
	);
	register_nav_menus( 
		array(
			'primary' => __( 'Primary Navigation', 'tiga' ),
			'secondary' => __( 'Secondary Navigation', 'tiga' )
		) 
	);
	add_theme_support( 'post-thumbnails' );

	/* Add support for custom headers. */
	$args = array(
		'width'         => 200,
		'height'        => 80,
		'flex-height'   => true,
		'flex-width'    => true,		
		'header-text'   => false,
		'uploads'       => true,
	);
	add_theme_support( 'custom-header', $args );

	/* Add custom image sizes. */
	add_action( 'init', 'tiga_add_image_sizes' );
	/* Add custom image sizes custom name. */
	add_filter( 'image_size_names_choose', 'tiga_custom_name_image_sizes' );

	/* Enqueue styles & scripts. */
	add_action( 'wp_enqueue_scripts', 'tiga_enqueue_scripts' );

	/* Deregister wp-pagenavi plugin style. */
	add_action( 'wp_print_styles', 'tiga_deregister_styles', 100 );

	/* Comment reply js */
	add_action( 'comment_form_before', 'tiga_enqueue_comment_reply_script' );

	/* Remove gallery inline style */
	add_filter( 'use_default_gallery_style', '__return_false' );

	/* Allow shortcode in widget. */
	add_filter( 'widget_text', 'do_shortcode' );

	/* Register additional widgets. */
	add_action( 'widgets_init', 'tiga_register_widgets' );

	/* Register custom sidebar. */
	add_action( 'widgets_init', 'tiga_register_custom_sidebars' );

	/* Theme settings location. */
	add_filter( 'options_framework_location', 'tiga_theme_settings_location' );

} // end tiga_setup

/**
 * Loads some additional functions.
 *
 * @since 1.7
 */
function tiga_load_libraries() {

	define( 'OPTIONS_FRAMEWORK_DIRECTORY', trailingslashit( get_template_directory_uri() ) . 'admin/' );
	require_once dirname( __FILE__ ) . '/admin/options-framework.php';

	/* Options panel extras. */
	require( trailingslashit( get_template_directory() ) . 'includes/options-functions.php' );

	/* Loads the additional theme functions. */
	require( trailingslashit( TIGA_INCLUDES ) . 'theme-functions.php' );

	/* Loads the custom template tags. */
	require( trailingslashit( TIGA_INCLUDES ) . 'templates.php' );

	/* Loads the theme hooks. */
	require( trailingslashit( TIGA_INCLUDES ) . 'hooks.php' );

	/* Loads the theme metabox. */
	if( is_admin() ) 
		require( trailingslashit( TIGA_INCLUDES ) . 'metabox.php' );

}

/**
 * Overwrites the default widths for embeds.  This is especially useful for making sure videos properly
 * expand the full width on video pages.  This function overwrites what the $content_width variable handles
 * with context-based widths.
 *
 * @since 1.0
 */
function tiga_embed_defaults( $args ) {
	
	$args['width'] = 620;
	
	$layout = of_get_option( 'tiga_layouts' );

	if ( 'onecolumn' == $layout )
		$args['width'] = 700;

	return $args;
}

/**
 * Adds custom image sizes.
 *
 * @since 1.0
 */
function tiga_add_image_sizes() {
	add_image_size( 'tiga-140px' , 140, 140, true );
	add_image_size( 'tiga-300px' , 300, 130, true );
	add_image_size( 'tiga-700px' , 700, 300, true );
	add_image_size( 'tiga-620px' , 620, 350, true );
	add_image_size( 'tiga-460px' , 460, 300, true );
}

/**
 * Adds custom image sizes custom name.
 *
 * @since 1.0
 */
function tiga_custom_name_image_sizes( $sizes ) {
    $sizes['tiga-140px'] = __( 'Small Thumbnail', 'tiga' );
    $sizes['tiga-300px'] = __( 'Medium Thumbnail', 'tiga' );
    $sizes['tiga-700px'] = __( 'Featured', 'tiga' );
    $sizes['tiga-620px'] = __( 'Medium Featured', 'tiga' );
    $sizes['tiga-460px'] = __( 'Home Slides', 'tiga' );
 
    return $sizes;
}

/**
 * Enqueue scripts
 *
 * @since 0.0.1
 */
function tiga_enqueue_scripts() {
	global $post;

	wp_enqueue_style( 'tiga-font', 'http://fonts.googleapis.com/css?family=Francois+One|Open+Sans:400italic,400,700', '', TIGA_VERSION, 'all' );

	wp_enqueue_style( 'tiga-style', get_stylesheet_uri(), '', TIGA_VERSION, 'all' );

	wp_enqueue_script( 'jquery' );

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'tiga-keyboard-image-navigation', trailingslashit( TIGA_JS ) . 'vendor/keyboard-image-navigation.js', array( 'jquery' ), TIGA_VERSION, true );
	}
	
	if ( is_singular() && of_get_option('tiga_social_share') ) {
		wp_enqueue_script( 'tiga-social-share', trailingslashit( TIGA_JS ) . 'vendor/social-share.js', array( 'jquery' ), TIGA_VERSION, true );
	}
	
	wp_enqueue_script( 'tiga-plugins', trailingslashit( TIGA_JS ) . 'plugins.js', array('jquery'), TIGA_VERSION, true );
	
	wp_enqueue_script( 'tiga-methods', trailingslashit( TIGA_JS ) . 'methods.js', array('jquery'), TIGA_VERSION, true );

}

/**
 * Deregister default wp-pagenavi style
 *
 * @since 0.0.1
 */
function tiga_deregister_styles() {
	wp_deregister_style( 'wp-pagenavi' );
}

/**
 * Comment reply js
 *
 * @since 0.2
 */
function tiga_enqueue_comment_reply_script() {

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

/**
 * Registers extra widgets.
 * 
 * @since 1.0
 */
function tiga_register_widgets() {

	require_once( trailingslashit( TIGA_INCLUDES ) . 'widget-social.php' );
	register_widget( 'tiga_social' );

	require_once( trailingslashit( TIGA_INCLUDES ) . 'widget-subscribe.php' );
	register_widget( 'tiga_subscribe' );

	require_once( trailingslashit( TIGA_INCLUDES ) . 'widget-fbfans.php' );
	register_widget( 'tiga_fb_box' );

}

/**
 * Registers custom sidebars.
 * 
 * @since 0.0.1
 */
function tiga_register_custom_sidebars() {

    register_sidebar(array(
    	'id'			=> 'primary',
		'name'          => __( 'Primary', 'tiga'),
		'description'   => __( 'Primary sidebar, appears on all pages.', 'tiga' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	));
	
	register_sidebar(array(
		'id'			=> 'subsidiary',
		'name'          => __( 'Subsidiary', 'tiga'),
		'description'   => __( 'Subsidiary sidebar, appears on the footer side of your site.', 'tiga' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	));

	register_sidebar(array(
		'id'			=> 'above-content',	
		'name'          => __( 'Above Single Post Content', 'tiga'),
		'description'   => __( 'This sidebar appears on the single post, above the content.', 'tiga' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	));

	register_sidebar(array(
		'id'			=> 'below-content',	
		'name'          => __( 'Below Single Post Content', 'tiga'),
		'description'   => __( 'This sidebar appears on the single post, below the content.', 'tiga' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	));

	register_sidebar(array(
		'id'			=> 'home',	
		'name'          => __( 'Custom Home Page', 'tiga'),
		'description'   => __( 'This sidebar appears on custom home page template.', 'tiga' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	));

}

/**
 * Count the number of widgets to enable dynamic classes
 *
 * @since 1.0
 */
function tiga_dynamic_sidebar_class( $sidebar_id ) {

	$sidebars = wp_get_sidebars_widgets();
	$get_count = count( $sidebars[$sidebar_id] );

	$class = '';

	switch ( $get_count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
		case '4':
			$class = 'four';
			break;
	}

	if ( $class )
		echo $class;

}

/**
 * Tiga site title.
 *
 * @since 1.4
 */
function tiga_site_title() {	

	$titletag  = ( is_front_page() ) ? 'h1' : 'h2';

	if ( get_header_image() ) {
		echo '<' . $titletag . ' class="site-logo">' . "\n";
			echo '<a href="' . get_home_url() . '" title="' . get_bloginfo( 'name' ) . '" rel="home">' . "\n";
				echo '<img class="logo" src="' . get_header_image() . '" alt="' . get_bloginfo( 'name' ) . '" />' . "\n";
			echo '</a>' . "\n";
		echo '</' . $titletag . '>' . "\n";
	} else {
		echo '<' . $titletag . ' class="site-title">' . "\n";
			echo '<a href="' . get_home_url() . '" title="' . get_bloginfo( 'name' ) . '" rel="home">' . get_bloginfo( 'name' ) . '</a>' . "\n";
		echo '</' . $titletag . '>' . "\n";
		echo '<div class="site-description">' . get_bloginfo( 'description' ) . '</div>';
	}

}

/**
 * Theme settings.
 *
 * @since 1.7
 */
function tiga_theme_settings_location() {
	return array( 'includes/options.php' );
}
?>