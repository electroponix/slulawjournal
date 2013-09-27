<?php
/**
 * Theme additional functions.
 * 
 * @package Tiga
 * @author Satrya
 * @license docs/license.txt
 * @since 1.7
 *
 */

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since 1.4
 */
function tiga_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'tiga' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'tiga_title', 10, 2 );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since 0.0.1
 */
function tiga_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'tiga' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with 
 * an ellipsis and tiga_continue_reading_link().
 *
 * @since 0.0.1
 */
function tiga_auto_excerpt_more( $more ) {
	return ' &hellip;' . tiga_continue_reading_link();
}
add_filter( 'excerpt_more', 'tiga_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * @since 0.0.1
 */
function tiga_custom_excerpt_more( $output ) {

	if ( has_excerpt() && ! is_attachment() ) {
		$output .= tiga_continue_reading_link();
	}
	return $output;

}
add_filter( 'get_the_excerpt', 'tiga_custom_excerpt_more' );

/**
 * Stop more link from jumping to middle of page
 *
 * @since 0.0.1
 */
function tiga_remove_more_jump_link($link) {

	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;

}
add_filter( 'the_content_more_link', 'tiga_remove_more_jump_link' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since 0.0.1
 */
function tiga_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'multi-author';
	}

	return $classes;

}
add_filter( 'body_class', 'tiga_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since 0.0.1
 */
function tiga_enhanced_image_navigation( $url, $id ) {

	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;

}
add_filter( 'attachment_link', 'tiga_enhanced_image_navigation', 10, 2 );

/**
 * Customize tag cloud widget
 *
 * @since 0.0.1
 */
function tiga_new_tag_cloud( $args ) {
	$args['largest'] 	= 12;
	$args['smallest'] 	= 12;
	$args['unit'] 		= 'px';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'tiga_new_tag_cloud' );

/**
 * HTML5 tag for image and caption
 *
 * @since 0.2.1
 */
function tiga_html5_caption( $output, $attr, $content ) {

	/* We're not worried abut captions in feeds, so just return the output here. */
	if ( is_feed() )
		return $output;

	/* Set up the default arguments. */
	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);

	/* Merge the defaults with user input. */
	$attr = shortcode_atts( $defaults, $attr );

	/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
		return $content;

	/* Set up the attributes for the caption <div>. */
	$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="wp-caption ' . esc_attr( $attr['align'] ) . '"';
	$attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';

	/* Open the caption <figure>. */
	$output = '<figure' . $attributes .'>';

	/* Allow shortcodes for the content the caption was created for. */
	$output .= do_shortcode( $content );

	/* Append the caption text. */
	$output .= '<figcaption class="wp-caption-text">' . $attr['caption'] . '</figcaption>';

	/* Close the caption </figure>. */
	$output .= '</figure>';

	/* Return the formatted, clean caption. */
	return $output;

}
add_filter( 'img_caption_shortcode', 'tiga_html5_caption', 10, 3 );

/**
 * Removes default styles set by WordPress recent comments widget.
 *
 * @since 0.0.1
 */
function tiga_remove_recent_comments_style() {

	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );

}
add_action( 'widgets_init', 'tiga_remove_recent_comments_style' );
?>