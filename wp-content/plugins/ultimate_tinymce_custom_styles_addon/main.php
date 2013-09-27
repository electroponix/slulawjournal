<?php
/*
Plugin Name: Ultimate TinyMCE Custom Styles Addon
Plugin URI: 
Description: Easily create custom styles which will be added to the dropdown style selector in TinyMCE.
Author: Josh Lobe
Version: 1.3
Author URI: http://joshlobe.com

*/

/*  Copyright 2012  Josh Lobe  (email : joshlobe@joshlobe.com)

    This software is not to be redistributed without express written consent from the copyright owner.
*/

/* Added by Josh for uninstalling all database values.  3-3-12
 * This function will remove all database entries created by the plugin.
 * This action is permenant, so I included an option so no information is lost accidentally.
*/

if ( isset( $_POST['uninstall2'], $_POST['uninstall_confirm2'] ) ) {
    ultimate_tinymce_styles_uninstall();
}

function ultimate_tinymce_styles_uninstall() {
	
	delete_option('jwl_userstyles_styles_css_field_id');
	delete_option('jwl_userstyles_styles_dropdown_field_id');
 
    // Do not change (this deactivates the plugin)
    $current2 = get_option('active_plugins');
    array_splice($current2, array_search( $_POST['plugin_styles'], $current2), 1 ); // Array-function!
    update_option('active_plugins', $current2);
    header('Location: plugins.php?deactivate=true');
}

function jwl_ultimate_tinymce_styles_form_uninstall() {
	?>
    <form method="post">
	<input id="plugin_styles" name="plugin_styles" type="hidden" value="ultimate_tinymce_custom_styles_addon/main.php" /> <?php  // The value must match the folder/file of the plugin.
    if ( isset( $_POST['uninstall2'] ) && ! isset( $_POST['uninstall_confirm2'] ) ) { 
	?><div id="message" class="error">
  			<p>
    		<?php _e('You must also check the confirm box before options will be uninstalled and deleted.','jwl-ultimate-tinymce-styles'); ?>
  			</p>
		</div>
 	  <?php
    }
	_e('The options for this plugin are not removed upon deactivation to ensure that no data is lost unintentionally.<br /><br />
	If you wish to remove all plugin information from your database be sure to run this uninstall utility first.<br /><br />
	This is a great way to "reset" the plugin, in case you experience problems with the editor.<br /><br />
    This option is NOT reversible.<br /><br /><br />','jwl-ultimate-tinymce-styles'); ?>
	<input name="uninstall_confirm2" type="checkbox" value="1" /> <?php _e('Please confirm before proceeding<br /><br />','jwl-ultimate-tinymce-styles'); ?>
	<input class="button-primary" name="uninstall2" type="submit" value="<?php _e('Uninstall','jwl-ultimate-tinymce-styles'); ?>" />
	</form>
<?php
}
/* End Uninstalling Database Values */




/* Display a plugin update notice that can be dismissed.  This notice is displayed only on Custom Styles page until dismissed. */
add_action('admin_notices', 'jwl_admin_notice_custom');
function jwl_admin_notice_custom() {
	global $current_user ;
		$user_id = $current_user->ID;
		/* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'jwl_ignore_notice_custom') ) {
		if ( current_user_can( 'manage_options' ) ) {
			if (jwl_custom_is_my_plugin_screen()) {
				echo '<div class="updated" style="background-color:#FFFFE0 !important; border:1px solid #E6DB55 !important;"><p>';
				printf(__('<span style="color:green;">Thank you for choosing Ultimate Tinymce Custom Styles.</span><br />Please visit the <a href="admin.php?page=ultimate-tinymce-styles">Ultimate Tinymce Custom Styles Settings Page</a> to begin customization of your styles.<br /><br /><a href="admin.php?page=ultimate-tinymce-styles%1$s">Hide this Message</a>'), '&jwl_nag_ignore_custom=0');
				echo "</p></div>";
			}
		}
	}
}
add_action('admin_init', 'jwl_nag_ignore_custom');
function jwl_nag_ignore_custom() {
	global $current_user;
		$user_id = $current_user->ID;
		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset($_GET['jwl_nag_ignore_custom']) && '0' == $_GET['jwl_nag_ignore_custom'] ) {
			 add_user_meta($user_id, 'jwl_ignore_notice_custom', 'true', true);
	}
}
function jwl_custom_is_my_plugin_screen() {  
    $screen = get_current_screen();  
    if (is_object($screen) && $screen->id == 'settings_page_ultimate-tinymce-styles') {  
        return true;  
    } else {  
        return false;  
    }  
}



// *************  SETUP PAGE FUNCTIONS CLASS ****************** //
//avoid direct calls to this file where wp core files not present
if (!function_exists ('add_action')) {
header('Status: 403 Forbidden');
header('HTTP/1.1 403 Forbidden');
exit();
}

define('JWL_CUSTOM_STYLES', 'ultimate-tinymce-styles');

//class that reperesent the complete plugin
class jwl_styles_plugin {

	//constructor of class, PHP4 compatible construction for backward compatibility
	function jwl_styles_plugin() {
		add_filter('screen_layout_columns', array(&$this, 'on_screen_layout_columns'), 10, 2);
		add_action('admin_menu', array(&$this, 'on_admin_menu'));
		add_action('admin_post_save_ultimate-tinymce-styles-general', array(&$this, 'on_save_changes'));
	}
	
	//for WordPress 2.8 we have to tell, that we support 2 columns !
	function on_screen_layout_columns($columns, $screen) {
		if ($screen == $this->pagehook) {
		$columns[$this->pagehook] = 2;
		}
		return $columns;
	}

	//extend the admin menu
	function on_admin_menu() {
	//add our own option page, you can also add it to different sections or use your own one
	$this->pagehook = add_options_page('Ultimate TinyMCE Custom Styles', __('Ultimate TinyMCE Custom Styles','jwl-ultimate-tinymce-styles'), 'manage_options', JWL_CUSTOM_STYLES, array(&$this, 'jwl_styles_page'));
	//register callback gets call prior your own page gets rendered
	add_action('load-'.$this->pagehook, array(&$this, 'jwl_styles_load_page'));
	add_action('admin_print_scripts-'.$this->pagehook, array(&$this, 'jwl_styles_register_head_scripts'));
	}
	function jwl_styles_register_head_scripts() {
		$url5 = plugin_dir_url( __FILE__ ) . 'js/pop-up.js';  // Added for popup help javascript
		echo "<script language='JavaScript' type='text/javascript' src='$url5'></script>\n";  // Added for popup help javascript
	}
	
	//will be executed if wordpress core detects this page has to be rendered
	function jwl_styles_load_page() {
	//ensure, that the needed javascripts been loaded to allow drag/drop, expand/collapse and hide/show of boxes
	wp_enqueue_script('common');
	wp_enqueue_script('wp-lists');
	wp_enqueue_script('postbox');
	
	//add several metaboxes now, all metaboxes registered during load page can be switched off/on at "Screen Options" automatically, nothing special to do therefore
	add_meta_box('jwl_resources', 'Resources', array(&$this, 'jwl_resources'), $this->pagehook, 'side', 'core');
	add_meta_box('jwl_example', 'Example', array(&$this, 'jwl_example'), $this->pagehook, 'side', 'core');
	add_meta_box('custom_styles_create_styles', 'Create Styles', array(&$this, 'jwl_create_styles'), $this->pagehook, 'normal', 'core');
	add_meta_box('custom_styles_create_styles_reference', 'Reference', array(&$this, 'jwl_reference'), $this->pagehook, 'normal', 'core');
	add_meta_box('custom_styles_uninstall', 'Delete Database Entries (Reset Plugin)', array(&$this, 'jwl_ultimate_tinymce_styles_form_uninstall'), $this->pagehook, 'normal', 'core');
	}
	
	//executed to show the plugins complete admin page
	function jwl_styles_page() {
	//we need the global screen column value to beable to have a sidebar in WordPress 2.8
	global $screen_layout_columns;
	//add a 3rd content box now for demonstration purpose, boxes added at start of page rendering can't be switched on/off,
	//may be needed to ensure that a special box is always available
	//add_meta_box('howto-metaboxes-contentbox-3', 'Contentbox 3 Title (impossible to hide)', array(&$this, 'on_contentbox_3_content'), $this->pagehook, 'normal', 'core');
	//define some data can be given to each metabox during rendering
	$data = array('My Data 1', 'My Data 2', 'Available Data 1');
	?>
	<div id="ultimate-tinymce-styles-general" class="wrap">
	<?php screen_icon('options-general'); ?>
	<h2>Ultimate Tinymce Custom Styles Plugin Page</h2>
	<form action="admin-post.php" method="post">
	<?php wp_nonce_field('ultimate-tinymce-styles-general'); ?>
	<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>
	<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>
	<input type="hidden" name="action" value="save_howto_metaboxes_general" />
    </form>
	<div id="poststuff" class="metabox-holder<?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
	<div id="side-info-column" class="inner-sidebar">
	<?php do_meta_boxes($this->pagehook, 'side', $data); ?>
	</div>
	<div id="post-body" class="has-sidebar">
	<div id="post-body-content" class="has-sidebar-content">
	<?php do_meta_boxes($this->pagehook, 'normal', $data); ?>
	<p>
	<!-- <input type="submit" value="Save Changes" class="button-primary" name="Submit"/> -->
	</p>
	</div>
	</div>
	<br class="clear"/>
	</div>
	</div>
	<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready( function($) {
	// close postboxes that should be closed
	$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
	// postboxes setup
	postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
	});
	//]]>
	</script>
	<?php
	}
	
	//executed if the post arrives initiated by pressing the submit button of form
	function on_save_changes() {
	//user permission check
	if ( !current_user_can('manage_options') )
		wp_die( __('Cheatin&#8217; uh?') );
		//cross check the given referer
		check_admin_referer('ultimate-tinymce-styles-general');
		wp_redirect($_POST['_wp_http_referer']);
	}
	
	function jwl_resources($data) {
	?>
		<img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/support.png" style="margin-bottom: -8px;" />
                <a href="http://forum.joshlobe.com/member.php?action=register&referrer=1" target="_blank"><?php _e('Get help from the Support Forum.','jwl-ultimate-tinymce-styles'); ?></a><br /><br />
                
                <img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/email.png" style="margin-bottom: -8px;" />
                <a href="http://www.joshlobe.com/contact-me/" target="_blank"><?php _e('Email me directly using my contact form.','jwl-ultimate-tinymce-styles'); ?></a><br /><br />
                <img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/rss.png" style="margin-bottom: -8px;" />
                <a href="http://www.joshlobe.com/feed/" target="_blank"><?php _e('Subscribe to my RSS Feed.','jwl-ultimate-tinymce-styles'); ?></a><br /><br />
                <img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/follow.png" style="margin-bottom: -8px;" />
                <?php _e('Follow me on ','jwl-ultimate-tinymce-styles'); ?><a target="_blank" href="http://www.facebook.com/joshlobe"><?php _e('Facebook','jwl-ultimate-tinymce-styles'); ?></a><?php _e(' and ','jwl-ultimate-tinymce-styles'); ?><a target="_blank" href="http://twitter.com/#!/joshlobe"><?php _e('Twitter','jwl-ultimate-tinymce-styles'); ?></a>.<br />
	<?php
	}
	function jwl_example($data) {
		_e('Here is a working example showing three different buttons added to the dropdown.  You may use it as a reference.<br /><br />','jwl-ultimate-tinymce-styles'); ?>
                <span style="color:red;">Array(</span> <span style="color:green;">Array(  'title' => 'Callout Box',  'block' => 'div',  'styles' => Array( 'color' => '#E85CF2', 'background-color' => '#AEF9F9', 'padding' => '5px', 'width' => '200px', 'border' => '1px solid #E85CF2', 'margin' => 'auto'), 'wrapper' => true)</span><span style="color:red;">,</span> <span style="color:#9D2BA5;">Array( 'title' => 'Bold Red Text', 'inline' => 'span', 'styles' => Array( 'color' => '#ff0000', 'fontWeight' => 'bold'))</span><span style="color:red;">,</span> <span style="color:#997509;">Array( 'title' => 'Download Link', 'selector' => 'a', 'styles' => Array( 'color' => '#FFFFFF', 'background-color' => '#38FC35', 'border' => '1px solid #0E990C', 'padding' => '5px', 'border-radius' => '5px'))</span><span style="color:red;">)</span><br /><br />I've included three different types of styles above; a block element, an inline span element, and a selector element using the "a" tag (for links).  I've also color coded each style to help visually see the separation. <?php
	}
	function jwl_create_styles($data) {
		sort($data);
		?> <form action="options.php" method="post" name="jwl_custom_styles"> <?php
		do_settings_sections('ultimate-tinymce-styles2');
		settings_fields('jwl_options_group_styles'); ?><br />
		<center><input class="button-primary" type="submit" name="Save" value="<?php _e('Apply Changes','jwl-ultimate-tinymce-styles'); ?>" id="submitbutton" /></center><br /></form><br /><br /><?php
		_e('Load a default array as an example. (Progressively more challenging)', 'jwl-ultimate-tinymce-styles');
		echo '<br />';
		?><form method="post"><input class="button" type="submit" name="load_example1" value="<?php _e('Load Example 1','jwl-ultimate-tinymce-styles'); ?>" id="load_example1" /><input class="button" type="submit" name="load_example2" value="<?php _e('Load Example 2','jwl-ultimate-tinymce-styles'); ?>" id="load_example2" /><input class="button" type="submit" name="load_example3" value="<?php _e('Load Example 3','jwl-ultimate-tinymce-styles'); ?>" id="load_example3" /></form><?php
	}
	function jwl_reference($data) {
		sort($data);
		jwl_custom_styles_reference();
	}
	function jwl_ultimate_tinymce_styles_form_uninstall() {
		jwl_ultimate_tinymce_styles_form_uninstall();
	}

}

$my_jwl_styles_plugin = new jwl_styles_plugin();
// *********  END CLASS **********
if (isset($_POST['load_example1'])) {
	update_option('jwl_userstyles_styles_css_field_id', '[{"title":"Download Link","selector":"a","styles":{"color":"#FFFFFF","background-color":"#38FC35","border":"1px solid #0E990C","padding":"5px","border-radius":"5px"}}]');
}
if (isset($_POST['load_example2'])) {
	update_option('jwl_userstyles_styles_css_field_id', '[{"title":"Bold Red Text","inline":"span","styles":{"color":"#ff0000","fontWeight":"bold"}},{"title":"Bold Blue Text","inline":"span","styles":{"color":"#470CF9","font-weight":"bold"}}]');
}
if (isset($_POST['load_example3'])) {
	update_option('jwl_userstyles_styles_css_field_id', '[{"title":"Highlights"},{"title":"Highlight Green","inline":"span","styles":{"background-color":"#B8F9BB","border":"1px solid #419B44","padding":"2px 5px 2px 5px","border-radius":"3px"}},{"title":"Highlight Blue","inline":"span","styles":{"background-color":"#BFF8FC","border":"1px solid #506EF4","padding":"2px 5px 2px 5px","border-radius":"3px"}},{"title":"Highlight Yellow","inline":"span","styles":{"background-color":"#FFFF35","border":"1px solid #E5D02D","padding":"2px 5px 2px 5px","border-radius":"3px"}},{"title":"Highlight Violet","inline":"span","styles":{"background-color":"#F7CAE8","border":"1px solid #F731B5","padding":"2px 5px 2px 5px","border-radius":"3px"}},{"title":"Highlight Red","inline":"span","styles":{"background-color":"#FCB3AE","border":"1px solid #F73325","padding":"2px 5px 2px 5px","border-radius":"3px"}}]');
}

// Set our language localization folder (used for adding translations)
function jwl_ultimate_tinymce_styles() {
 load_plugin_textdomain('jwl-ultimate-tinymce-styles', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'jwl_ultimate_tinymce_styles' );

//  Add settings link to plugins page menu
//  This can be duplicated to add multiple links
function add_ultimatetinymce_styles_settings_link($links3, $file3) {
	static $this_plugin3;
	if (!$this_plugin3) $this_plugin3 = plugin_basename(__FILE__);
 
		if ($file3 == $this_plugin3){
		$settings_link_styles = '<a href="admin.php?page=ultimate-tinymce-styles">'.__("Settings",'jwl-ultimate-tinymce-styles').'</a>';
		$settings_link2_styles = '<a href="http://forum.joshlobe.com/member.php?action=register&referrer=1">'.__("Support Forum",'jwl-ultimate-tinymce-styles').'</a>';
		array_unshift($links3, $settings_link_styles, $settings_link2_styles);
		}
	return $links3;
}
add_filter('plugin_action_links', 'add_ultimatetinymce_styles_settings_link', 10, 2 );

function jwl_settings_api_init_styles() {
 	// This creates each settings option group.  These are used as headers in our admin panel settings page.
	
	add_settings_section('jwl_setting_section_styles2', '', 'jwl_userstyles_callback_function2', 'ultimate-tinymce-styles2');
	
	add_settings_field('jwl_userstyles_styles_dropdown_field_id', __('Enable "Style Select" button','jwl-ultimate-tinymce-styles'), 'jwl_userstyles_styles_dropdown_callback_function', 'ultimate-tinymce-styles2', 'jwl_setting_section_styles2');
	add_settings_field('jwl_userstyles_styles_css_field_id', __('Enter your Array for the Dropdown','jwl-ultimate-tinymce-styles'), 'jwl_userstyles_styles_css_callback_function', 'ultimate-tinymce-styles2', 'jwl_setting_section_styles2');
	
	register_setting('jwl_options_group_styles','jwl_userstyles_styles_css_field_id', 'jwl_str2json');
	register_setting('jwl_options_group_styles','jwl_userstyles_styles_dropdown_field_id', 'jwl_str2json');

}
add_action('admin_init', 'jwl_settings_api_init_styles');

function jwl_userstyles_callback_function2() {
 	_e('<p>&nbsp;&nbsp;&nbsp;Create your custom styles.</p>','jwl-ultimate-tinymce-styles');
}

function jwl_custom_styles_reference() {
	?>
    Please use this as a reference when creating your custom styles.
   <br /><br />
   <table cellpadding="10px" cellspacing="10px">
   <tr>
   <td>Step 1</td><td><b>title</b><br />[required]</td><td>label for this dropdown item</td>
   </tr><tr>
   <td>Step 2</td><td><b>selector | block | inline</b> [required]</td><td><b>selector</b> - limits the style to a specific HTML tag, and will apply the style to an existing tag instead of creating one.<br /><b>block</b> - creates a new block-level element with the style applied, and will replace the existing block element around the cursor.<br /><b>inline</b> - creates a new inline element with the style applied, and will wrap whatever is selected in the editor, not replacing any tags.</td>
   </tr><tr>
   <td>Step 3</td><td><b>styles</b><br />[required]</td><td>array of inline styles to apply to the element.</td>
   </tr><tr>
   <td>Step 4</td><td><b>wrapper</b><br />[optional, default=false]</td><td>if set to true, creates a new block-level element around any selected block-level elements.</td>
   </tr>
   </table>
<?php 
}

function jwl_userstyles_styles_css_callback_function() {
 	echo '<textarea name="jwl_userstyles_styles_css_field_id" value=" rows="15" class="long-text" style="width:380px; height:200px;">';
	$jwl_userstyles_json = get_option('jwl_userstyles_styles_css_field_id');
	$jwl_userstyles_string = jwl_json2str($jwl_userstyles_json);
	echo $jwl_userstyles_string;
	echo '</textarea>';
	?><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/userstyles_css.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:10px;margin-bottom:-5px;" title="Click for Help" /></a><?php
	_e('<br />* Create an Array of buttons.<br />* See the Help section for further explanation and specific examples.');
}

function jwl_userstyles_styles_dropdown_callback_function() {
	echo '<input name="jwl_userstyles_styles_dropdown_field_id" id="dropdown" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_userstyles_styles_dropdown_field_id'), false ) . ' /> Enable <strong><em>only</em></strong> if there is not a style select button in the content editor.';
}

function jwl_dropdown_styles_button($buttons) { $jwl_dropdown = get_option('jwl_userstyles_styles_dropdown_field_id'); if ($jwl_dropdown == "1") $buttons[] = 'styleselect'; return $buttons; } add_filter("mce_buttons_2", "jwl_dropdown_styles_button");
	
function jwl_str2json($reg_string) {
/*  DESCRIPTION: Converts a regular string into a JSON string
	USAGE: jwl_str2json($string_to_convert);
	IMPORTANT: 
	1. The function needs to get rid of all spaces, as per JSON
	structure. However, this needs to be done carefully because values
	containing spaces (such as "Times New Roman") can get affected with
	a massive replacement. 
	2. Theunction catches (and gets rid of) up to five consecutive spaces.
	Any number greater than that will prevent the string from being properly
	converted.
	3. This function relies on WP filters for escaping and sanitizing input.
*/
	$reg_string = str_replace( array( ' => ', ' , ', ', ', ' ( ', '( ', ' (', ' ) ', ' )', ' )', '  ', '   ', '    ' ), array( ':', ',', ',', '(', '(', '(', ')', ')', ')', ' ' ), $reg_string );
	$reg_string_c = str_ireplace( array( 'Array('), array( '{'), $reg_string );
	$reg_string_c = str_replace( array( ')', "''", "'" ), array( '}', '"', '"' ), $reg_string_c );
	if (stripos ($reg_string, 'Array(Array(') !== false ) {
		$reg_string_c = substr_replace ( $reg_string_c, '[', strpos ($reg_string_c, '{'), 1 );
		$reg_string_c = substr_replace ( $reg_string_c, ']', strrpos ($reg_string_c, '}'), 1 );
	}
	return $reg_string_c;
}


function jwl_json2str($json_string) {
/*	DESCRIPTION: Converts a JSON string into a regular string
	USAGE: jwl_json2str($string_to_convert);
	IMPORTANT: To avoid breaking URLS upon conversion, all instances of
	'http:' are first changed to 'http@' temporarily and then back to
	'http:' AFTER replacing all ':' with '=>'. 
*/
	$json_string = str_replace( array( 'http:', '{', '}', '"', ':', 'http@', ',' ), array( 'http@', 'Array( ', ')', '\'', ' => ', 'http:', ', ' ), $json_string );
	if (strpos ($json_string, '[') !== false ) {
		$json_string = str_replace ( '[', 'Array( ', $json_string );
		$json_string = str_replace ( ']', ')', $json_string );
	}
	if (strpos ($json_string, "''") !== false ) {
		$json_string = str_replace( "''", '"', $json_string );

	}
	return $json_string;
}

function user_styles_dropdown($user_styles) {
	$user_styles['style_formats'] = get_option('jwl_userstyles_styles_css_field_id');
	return $user_styles;
}
add_filter( 'tiny_mce_before_init', 'user_styles_dropdown' );

?>