<?php
/*
Plugin Name: Annie
Plugin URI: http://croberts.me/annie/
Description: Provides comprehensive annotation tools for WordPress posts.
Version: 2.1.0
Author: Chris Roberts
Author URI: http://croberts.me/
*/

/*  Copyright 2013 Chris Roberts (email : chris@dailycross.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class Annie {
	private $highlightText = array();
	private $footcount = 1;
	private $footnoteText = array();
	private $showToolbox = false;
	private $footnotesShowing = false;
	private $toolboxShowing = false;
	private $is_page_val = false;

	// Initialize everything
    public function __construct()
    {
        add_action('wp_print_styles', array($this, 'load_styles'));
		add_action('wp_print_scripts', array($this, 'load_scripts'));

		add_shortcode('hi', array($this, 'highlight_shortcode'));
		add_shortcode('foot', array($this, 'footnote_shortcode'));
		add_shortcode('footnotes', array($this, 'footnote_display_shortcode'));

		add_filter('the_content', array($this, 'process_content'), 20);
		add_action('wp_footer', array($this, 'toolbox'));

		add_action('admin_menu', array($this, 'addoptions'));
		add_action('admin_head', array($this, 'load_for_admin'));

		add_action('wp_head', array($this, 'load_globals'));

		add_filter('plugin_action_links', array($this, 'settings_link'), 10, 2);
	}

	public function settings_link($links, $file) { 
		if ($file == 'annie/annie.php') {
			$settings_link = '<a href="options-general.php?page=annie.php">Settings</a>'; 
			array_push($links, $settings_link);
		}
		
		return $links; 
	}

	public function addoptions()
	{
		require_once(plugin_dir_path(__FILE__) .'/annie_admin.php');
		add_options_page('Annie Plugin Options', 'Annie', 'manage_options', basename(__FILE__), 'annie_options_subpanel');
	}

	public function highlight_shortcode($annie_attributes, $annieText = '')
	{
		$default_style = get_option('annie_defaultHighlight', 'yellow');
		
		if ($default_style == "custom") {
			$default_style = get_option('annie_defaultHighlightCustom', 'yellow');
		}
		
		extract( shortcode_atts( array(
			'style' => $default_style
		), $annie_attributes ) );
		
		$hilight_text = '<span id="" class="annie_hilight_'. $style .' annie_custom annie_highlightText" highlight="annie_hilight_'. $style .'">'. $annieText .'</span>';
		$this->highlightText[] = $annieText;
		
		// Take care of any nested shortcodes
		$hilight_text = do_shortcode($hilight_text);
		
		$this->showToolbox = true;
		
		return $hilight_text;
	}

	public function footnote_shortcode($annie_attributes, $annieText = '')
	{
		global $post, $tippy;
		
		// Store the text in our array
		$this->footnoteText[$this->footcount] = $annieText;
		
		// No markup for footnotes; just the text.
		$annieShortcodeText = do_shortcode($annieText);
		$annie_cleanText = $annieShortcodeText;
		
		// $annie_cleanText = str_replace('[', '{', $annie_cleanText);
		
		// Format the footnote reference
		if (is_object($tippy) && get_option('annie_footnoteDisplay', 'link') == 'tooltip') {
			$annie_footnoteLink = get_permalink($post->ID) ."#foot_text_". $post->ID . "_". $this->footcount;
			$annie_footnoteTitle = $this->footcount;

			if (get_option('annie_footnoteFormat', 'numbers') == "other") {
				$annie_footnoteTitle = get_option('annie_footnoteFormatText', '*');
			}

			$annie_tippyValues = array(
				'header' => 'off',
				'title' => $annie_footnoteTitle,
				'href' => $annie_footnoteLink,
				'text' => $annie_cleanText,
				'class' => 'annie_footnoteRef annie_custom',
				'name' => 'foot_loc_'. $post->ID . '_'. $this->footcount,
				'item' => 'foot_tip_'. $post->ID . '_'. $this->footcount,
				'useDiv' => true
			);

			$annie_returnLink = $tippy->getLink($annie_tippyValues);
		} else {
			$annie_returnLink = '<a name="foot_loc_'. $post->ID . '_'. $this->footcount .'" class="annie_footnoteRef annie_custom" title="'. strip_tags($annie_cleanText) .'" href="'. get_permalink($post->ID) .'#foot_text_'. $post->ID . '_'. $this->footcount .'">'. $this->footcount .'</a>';
		}
		
		$this->footcount++;
		$this->showToolbox = true;

		return $annie_returnLink;
	}

	public function footnote_display_shortcode($annie_attributes = '', $annie_text = '')
	{
		$annie_returnText = $this->process_content('');
		
		$this->footnotesShowing = true;
		
		return $annie_returnText;
	}

	public function process_content($content)
	{
		global $post;
		
		if (!$this->footnotesShowing && (is_single() || $this->is_page_val) && get_option('annie_footnoteShowNotes', 'show') == 'show' && sizeof($this->footnoteText) > 0) {
			$footnoteHeader = get_option('annie_footnoteNotesHeader', 'Notes:');
			$content .= '<div class="annie_notes annie_custom"><span class="annie_noteHeader annie_custom">'. $footnoteHeader .'</span><br />';
			
			foreach ($this->footnoteText as $footnoteIndex => $footnoteText) {
				$linkTitle = $footnoteIndex;

				if (get_option('annie_footnoteFormat', 'numbers') == "other") {
					$linkTitle = get_option('annie_footnoteFormatText', '*');
				}

				$content .= "\n";
				$content .= '<div class="annie_note_container"><a name="foot_text_'. $post->ID . '_'. $footnoteIndex .'" href="#foot_loc_'. $post->ID . '_'. $footnoteIndex .'">'. $linkTitle .'</a>. '. $footnoteText .'</div>';
				$content .= "\n";
			}
			
			$content .= '</div>';
		}
		
		$this->footnoteText = array();
		$this->footcount = 1;
		
		return $content;
	}

	public function toolbox()
	{
		if (sizeof($this->highlightText) > 0) {
			$this->show_toolbox();
			
			echo '<div id="annie_highlightTextBox">';
			
			// Output the div with highlights
			foreach ($this->highlightText as $discard => $annie_text)
			{
				echo $annie_text ."<br /><br />";
			}
			echo '</div>';
		}
	}

	public function show_toolbox()
	{
		if (!$this->toolboxShowing && get_option('annie_showToolbox', 'true') == "true") {
			// Toolbox code
			$annie_toolboxMarkup = '
<div id="annie_toolbox" showing="full">
	<a id="annie_toggle_highlight" class="annie_toggle" onclick="annie_toggleHighlights(\''. plugins_url() .'\');"><img style="width: 14px; height: 14px;" src="' . plugins_url() . '/annie/images/star_green.png" alt="Hide Highlights" title="Hide Highlights" /></a> <a class="annie_toggle" onclick="annie_showHighlights();"><img style="width: 14px; height: 14px;" src="' . plugins_url() . '/annie/images/comments.png" alt="Read Highlighted Text" title="Read Highlighted Text" /></a>
	<div id="annie_toolbox_toggle" onclick="annie_toggleToolbox();">&laquo;</div>
</div>
';
			
			echo $annie_toolboxMarkup;
			
			$this->toolboxShowing = true;
		}
	}

	public function load_scripts()
	{
		// Load jQuery, if not already present
		wp_enqueue_script('jquery');
		
		// Load the Tippy script
		wp_register_script('Annie', plugins_url() .'/annie/annie.js', array('jquery'));
		wp_enqueue_script('Annie');
	}

	public function load_styles()
	{
		wp_register_style('Annie', plugins_url() .'/annie/annie.css');
		wp_enqueue_style('Annie');
	}

	public function load_for_admin()
	{
		echo '<link rel="stylesheet" type="text/css" href="'. plugins_url() .'/annie/annie.css">';
	}

	public function load_globals()
	{
		$this->is_page_val = is_page();
	}
}

$annie = new Annie();

?>