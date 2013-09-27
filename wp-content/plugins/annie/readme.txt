=== Annie ===
Contributors: Columcille
Tags: annotation, highlight, footnote
Requires at least: 3.0.0
Tested up to: 3.5.1
Stable tag: 2.1.0

Provides comprehensive annotation tools for WordPress posts.

== Description ==

Annie provides comprehensive annotation options, including footnotes and highlighting. If Tippy is installed, footnotes can be displayed inline using tooltips. Also, footnotes are placed at the end of the post. For highlighting, you are able to use default highlighting styles or define your own.

== Installation ==

Upload the plugin into your wp-content/plugins directory
Activate the plugin through the dashboard
Visit the Annie Options page under the Settings section of your dashboard.

To customize the styles, copy the contents of wp-content/plugins/annie/annie.css to your own theme's stylesheet and add .annie_custom to each rule you want to customize. For example:
.annie_notes.annie_custom { etc }

To use Annie:
[hi]text[/hi] to highlight text using your default highlighting style
[hi style="red"]text[/hi] to highlight using the "red" style

[foot]This is my footnote text[/foot] to add a footnote wherever desired.

If you want to manually specify where your footnotes should display, use the [footnotes] shortcode. 

To define new highlighter styles, simply add a rule to your stylesheet following the naming pattern: annie_hilight_yourstyle. To create a new style called "green_italics" define it as:
.annie_hilight_green_italics {
	background-color: green;
	font-style: italics;
}

== Screenshots ==

1. Adding highlighting and footnotes to a post.
2. Seeing the results!

== Changelog ==

= 2.1.0 =
* Adds a new option to manually specify footnote reference.

= 2.0.3 =
* Fixes an issue with links in the notes going back to the text

= 2.0.2 =
* Fixed an issue with footnote text not showing up in pages

= 2.0.1 =
* Fixed some glitches with various html markup in footnotes.

= 2.0.0 =
* Annie now set up as a php class
* html styling now shows up in footnote tooltips

= 1.4.6 =
* Fixed an issue showing highlights from the toolbar.
* Improved showing footnotes in a tooltip.

= 1.4.5 =
* Minor updates.

= 1.4.4 =
* Fixed issue which prevented footnotes from showing at the end of pages.

= 1.4.3 =
* Notes in the bottom Notes section are now wrapped in a div with a bottom margin added between notes.

= 1.4.2 =
* Don't display the Notes section when only the post excerpt is being displayed

= 1.4.1 =
* Fixed an issue where html code was included in footnote text, causing the inline footnote to fail.

= 1.3.1 = 
* Removed alert that would show when activating the pop-up annotations.

= 1.3.0 =
* Added option to turn off footnotes display at the end of the post. Useful if the footnotes are being displayed with Tippy.
* Added [footnotes] shortcode to specify where in the post footnotes should be displayed. Note that any notes added after [footnotes] will not show up in the notes list.

= 1.2.0 =
* Styling changes for the highlighted text overlay
* Tippy compatibility updates

= 1.1.1 =
* Styling tweak

= 1.1.0 =
* Added new Toolbox feature
* Fixed issue when Annie is used on pages with multiple posts

= 1.0.0 = 
* Annie created
