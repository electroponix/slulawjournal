<?php
if (! function_exists('annie_options_subpanel')) {
  function annie_options_subpanel() {
    global $wpdb, $table_prefix, $annie;

    if (isset($_POST['info_update'])) {
		update_option('annie_footnoteDisplay', $_POST['annie_footnoteDisplay']);
		update_option('annie_footnoteShowNotes', $_POST['annie_footnoteShowNotes']);
		update_option('annie_footnoteNotesHeader', $_POST['annie_footnoteNotesHeader']);
		update_option('annie_footnoteFormat', $_POST['annie_footnoteFormat']);
		update_option('annie_footnoteFormatText', $_POST['annie_footnoteFormatText']);
		update_option('annie_defaultHighlight', $_POST['annie_defaultHighlight']);
		update_option('annie_defaultHighlightCustom', $_POST['annie_defaultHighlightCustom']);
		update_option('annie_showToolbox', $_POST['annie_showToolbox']);
		
		echo '<div class="updated"><p><strong>Your options have been updated.</strong></p></div>';
    }
?>

<style type="text/css">
	div.annieOptionSection {
		margin: 10px 0 20px 10px;
		width: 800px;
	}
	
	span.annieOptionLabel {
		font-size: 16px;
	}
	
	div.annieOptions {
		margin-left: 15px;
	}
	
	div.annieOptionLeft {
		width: 125px;
		float: left;
	}
	
	div.annieOptionRight {
		float: left;
	}
	
	div.clearOptions {
		margin-bottom: 5px;
		clear: both;
	}
</style>

<div class="wrap">
	<h2>Annie Options</h2>
	<br />
	<form method="post">

	<span class="annieOptionLabel">Annie Footnote Display Options</span><br />
	<div class="annieOptionSection">
	   <div class="annieOptions">
        	Should the footnote references be simple links or tooltips + links? (Tooltip requires <a href="http://croberts.me/tippy/">Tippy</a>)<br /><br />
			<input id="annie_footnote_link" name="annie_footnoteDisplay"  type="radio" value="link" <?php if (get_option('annie_footnoteDisplay', 'link') == "link") echo "checked" ?> />
				<label for="annie_footnote_link" title="Link only">
					Footnote references are simple links
				</label><br />

			<input id="annie_footnote_tooltip" name="annie_footnoteDisplay" type="radio" value="tooltip" <?php if (get_option('annie_footnoteDisplay', 'link') == "tooltip") echo "checked" ?> />
				<label for="annie_footnote_tooltip" title="Use Tooltip + link">
					Footnote references show a tooltip (Requires <a href="http://croberts.me/tippy/">Tippy</a>)
				</label><br /><br />
		</div>
		
		<div class="annieOptions">
			<input id="annie_footnoteFormat_numbers" name="annie_footnoteFormat" type="radio" value="numbers" <?php if (get_option('annie_footnoteFormat', 'numbers') == "numbers") echo 'checked="checked"'; ?> /> <label for="annie_footnoteFormat_numbers">Footnote reference uses numbers</label><br />

			<input id="annie_footnoteFormat_other" name="annie_footnoteFormat" type="radio" value="other" <?php if (get_option('annie_footnoteFormat', 'numbers') == "other") echo 'checked="checked"'; ?> /> <label for="annie_footnoteFormat_other">Footnote reference custom defined</label>: <input type="text" value="<?php echo get_option('annie_footnoteFormatText', '*'); ?>" name="annie_footnoteFormatText" id="annie_footnoteFormatText" size="4" /><br /><br />
		</div>

		<div class="annieOptions">
			<input id="annie_footnote_showNotes" name="annie_footnoteShowNotes"  type="checkbox" value="show" <?php if (get_option('annie_footnoteShowNotes', 'show') == "show") echo "checked" ?> />
			
			<label for="annie_footnote_showNotes" title="Show Notes in Post">
				Footnote text should be included in the post. You might turn this off when using Tippy if you want to only display notes in the popup.
			</label><br /><br />
		</div>
		
		<div class="annieOptions">
        	What should be the header text for your footnotes at the bottom of the post:<br />
			<label for="annie_footnoteNotesHeader" title="Footnote Header Text">
				Footnote Header Text: 
			</label>
			<input id="annie_footnoteNotesHeader" name="annie_footnoteNotesHeader" size="20" type="text" value="<?php echo get_option('annie_footnoteNotesHeader', 'Notes:'); ?>" /><br />
			
		</div>
		
	</div>
	
	<span class="annieOptionLabel">Annie Highlighting Display Options</span><br />
	<div class="annieOptionSection">
		<div class="annieOptions">
        	What should be the default highlighting style?<br /><br />
			<input id="annie_defaultHighlight_yellow" name="annie_defaultHighlight"  type="radio" value="yellow" <?php if (get_option('annie_defaultHighlight', 'yellow') == "yellow") echo "checked" ?> />
				<label for="annie_defaultHighlight_yellow">
					<span class="annie_hilight_yellow">Yellow</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_red" name="annie_defaultHighlight"  type="radio" value="red" <?php if (get_option('annie_defaultHighlight', 'yellow') == "red") echo "checked" ?> />
				<label for="annie_defaultHighlight_red">
					<span class="annie_hilight_red">Red</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_green" name="annie_defaultHighlight"  type="radio" value="green" <?php if (get_option('annie_defaultHighlight', 'yellow') == "green") echo "checked" ?> />
				<label for="annie_defaultHighlight_green">
					<span class="annie_hilight_green">Green</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_blue" name="annie_defaultHighlight"  type="radio" value="blue" <?php if (get_option('annie_defaultHighlight', 'yellow') == "blue") echo "checked" ?> />
				<label for="annie_defaultHighlight_blue">
					<span class="annie_hilight_blue">Blue</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_yellow_underline" name="annie_defaultHighlight"  type="radio" value="yellow_underline" <?php if (get_option('annie_defaultHighlight', 'yellow') == "yellow_underline") echo "checked" ?> />
				<label for="annie_defaultHighlight_yellow_underline">
					<span class="annie_hilight_yellow_underline">Yellow Underline</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_red_underline" name="annie_defaultHighlight"  type="radio" value="red_underline" <?php if (get_option('annie_defaultHighlight', 'yellow') == "red_underline") echo "checked" ?> />
				<label for="annie_defaultHighlight_red_underline">
					<span class="annie_hilight_red_underline">Red Underline</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_green_underline" name="annie_defaultHighlight"  type="radio" value="green_underline" <?php if (get_option('annie_defaultHighlight', 'yellow') == "green_underline") echo "checked" ?> /> 
				<label for="annie_defaultHighlight_green_underline">
					<span class="annie_hilight_green_underline">Green Underline</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_blue_underline" name="annie_defaultHighlight"  type="radio" value="blue_underline" <?php if (get_option('annie_defaultHighlight', 'yellow') == "blue_underline") echo "checked" ?> />
				<label for="annie_defaultHighlight_blue_underline">
					<span class="annie_hilight_blue_underline">Blue Underline</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_custom" name="annie_defaultHighlight"  type="radio" value="custom" <?php if (get_option('annie_defaultHighlight', 'yellow') == "custom") echo "checked" ?> />
				<label for="annie_defaultHighlight_custom">
					Custom
				</label>
				
				<input id="annie_defaultHighightCustom" name="annie_defaultHighlightCustom" size="20" type="text" value="<?php echo get_option('annie_defaultHighlightCustom', ''); ?>" /><br />
				<br />
				
			To add a custom style, it needs to be called something like <i>annie_hilight_yourstyle</i> in your stylesheet and in the box above enter <i>yourstyle</i>. The style name in your stylesheet must begin with <i>annie_hilight_</i> and in the box above only enter the part that comes after <i>annie_hilight_</i>. I.e., for a style called <i>annie_hilight_yellow_red</i>, you would put <i>yellow_red above</i>.<br />
		</div>
		
	</div>
	
	<span class="annieOptionLabel">Annie Toolbox Options</span><br />
	<div class="annieOptionSection">
	   <div class="annieOptions">
        	Do you want to display the Annie toolbox at the bottom of the screen? The toolbox allows users to turn highlighting on and off. It also allows users to view just the highlighted text. The toolbox will only display if there is highlighted text. Styling can be adjusted in your stylesheet.<br /><br />
			<input id="annie_showToolbox_true" name="annie_showToolbox"  type="radio" value="true" <?php if (get_option('annie_showToolbox', 'true') == "true") echo "checked" ?> />
				<label for="annie_showToolbox_true">
					Show the toolbox
				</label><br />

			<input id="annie_showToolbox_false" name="annie_showToolbox" type="radio" value="false" <?php if (get_option('annie_showToolbox', 'true') == "false") echo "checked" ?> />
				<label for="annie_showToolbox_false">
					Do not show the toolbox
				</label><br /><br />
		</div>
		
	</div>

    <input type="submit" name="info_update" value="Update Options" /><br /><br />

	</form>
</div>

<?php
  }
}
?>