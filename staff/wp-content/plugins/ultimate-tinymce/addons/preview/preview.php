<?php ob_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
		include ('../jwl_call_wp_load.php');
?>
<!--
<script type="text/javascript" src="../../tinymce/tiny_mce_popup.js"></script>
-->
<script type="text/javascript" src="jscripts/embed.js"></script>
<script type="text/javascript"><!--
document.write('<base href="' + tinyMCEPopup.getWindowArg("base") + '">');
// -->
</script>
<title>{#preview.preview_desc}</title>
</head>
<body id="content">
<script type="text/javascript">
	document.write(tinyMCEPopup.editor.getContent());
</script>
</body>
</html>
