<html><head>
<title>TinyMCE Custom Styles</title>
<link rel=StyleSheet href="pop-upstyle.css" type="text/css" media="screen">
</head>

<BODY BGCOLOR="#F2F9FA" TEXT="#000000" LINK="#99CCFF" VLINK="#99CCFF" ALINK="#99CCFF" leftmargin=0 rightmargin=0 topmargin=0 bottommargin=0 marginheight=0 marginwidth=0>

<!-- OUTER TABLE-->
<TABLE cellpadding=0 cellspacing=0 border="0" bordercolor="666666" width="100%" height="100%"><tr><td ALIGN="CENTER" VALIGN="TOP">

<!-- CONTENT TABLE -->
<TABLE cellpadding=0 cellspacing=0 border="0" bordercolor="666666" width="80%"><tr><td ALIGN="left" VALIGN="TOP">
<br>

<span class="title" style="padding:0px 5px 0px 5px;background-color:#CCFCD9;border:1px solid #339966;"><strong>TinyMCE Custom Styles:</strong></span>
<br />
Create custom styles to add to your wordpress visual editor styles dropdown box.  This plugin will do three things:
<ol><li>Adds the style to the dropdown selector.</li><li>Applies the style to a highlighted selection; or allows you to select the style and begin entering content using the selected style.</li><li>Aplies the style to the front-end of the website.</li></ol>

<br /><br />

<span class="title" style="padding:0px 5px 0px 5px;background-color:#CCFCD9;border:1px solid #339966;"><strong>Usage:</strong></span>
<br />
Okay... the meat and potatoes.<br><br>
The Wordpress tinymce editor is setup to use JSON encoding.  This is another type of programmers language.  Rather than force you to learn JSON, I haved decided to allow the styles to be created using basic PHP Array syntax, and all of the conversions will be done behind the scenes.<br /><br />

Don't worry if you don't have any PHP experience!  I'm going to give you detailed examples below.<br /><br />

<span class="title" style="padding:0px 5px 0px 5px;background-color:#CCFCD9;border:1px solid #339966;"><strong>Some things to remember:</strong></span>
<br />
1. The entire code will be enclosed in an array.  Your code will always begin with <b>array(</b> and it will end with an <b>)</b><br /><br />
2. If a mistake is made when entering the code, it might "break" the tinymce editor.  If you go to edit a post/page (after creating your styles), and the editor has vanished, it is because there is a mistake in the code.  Go back, and check it again.  Also, you can always delete the entire code to "reset" the entry.<br /><br />
3. Each property and value must be enclosed in a single apostrophe, and separated by an equals sign and a greater than sign.  For example, 'title' => 'Bold Red Text'<br /><br />
4. Each property and value pair must be separated by a comma.  For example, 'color' => '#FF0000'<b>,</b> 'font' => 'arial'<b>,</b> etc...<br /><br />
5. Pay careful attention when working with the styles of each custom style.  You will be using another Array to enter your various css attributes.  So, your "styles" property/value pair will actually consist of another array for the value.  For example; <b>'styles' => Array(...)</b><br /><br />
6. Lastly, separate each complete style with a comma, before beginning a new custom style.<br /><br />
7. Please remember to utilize my free <a target="_blank" href="http://www.forum.joshlobe.com">support forum</a> if you get stuck.<br /><br />

<span class="title" style="padding:0px 5px 0px 5px;background-color:#CCFCD9;border:1px solid #339966;"><strong>Examples:</strong></span>
<br />
1. Let's create a button for <b>Bold Red Text</b>.<br /><br />
Array( Array( 'title' => 'Bold Red Text', 'inline' => 'span', 'styles' => Array( 'color' => '#ff0000', 'font-weight' => 'bold')))<br /><br />

2. Let's create a button for <b>Bold Blue Text</b>.<br /><br />
Array( Array( 'title' => 'Bold Blue Text', 'inline' => 'span', 'styles' => Array( 'color' => '#470CF9', 'font-weight' => 'bold'))).<br /><br />

3. Now, let's combine these buttons into a single array, adding both to the dropdown box.<br /><br />
Array( Array( 'title' => 'Bold Red Text', 'inline' => 'span', 'styles' => Array( 'color' => '#ff0000', 'fontWeight' => 'bold')), Array( 'title' => 'Bold Blue Text', 'inline' => 'span', 'styles' => Array( 'color' => '#470CF9', 'font-weight' => 'bold')))<br /><br />

4. Here is an example creating a button (for like a download link).<br /><br />
Array( Array( 'title' => 'Download Link', 'selector' => 'a', 'styles' => Array( 'color' => '#FFFFFF', 'background-color' => '#38FC35', 'border' => '1px solid #0E990C', 'padding' => '5px', 'border-radius' => '5px')))<br /><br />

<br /><br />
<img src="images/customstyles4.png" border="1px solid #000000" /><br />
<em>Example of a single style added to the editor.  Remember to enclose this with <b>Array(</b> at the beginning and <b>)</b> at the end, if you only use one button in your editor.  This is intended to show an example of each style array.</em><br /><br />

</td></tr></table>
<!-- CONTENT TABLE -->

</td></tr><tr><td ALIGN="center" VALIGN="bottom"><!-- OUTER TABLE -->

<!-- CLOSE BUTTON -->
<form>
<input type=button value="Close Window" onClick='self.close()'>
</form>

</td></tr></table>
<!-- OUTER TABLE-->

</BODY>
</HTML>