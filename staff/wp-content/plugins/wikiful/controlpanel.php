<?php
function wikiful_options() {
	global $wikiful,$current_user;

	$wikiful_options[] = array(  "name" => "Integration Settings",
            "type" => "heading",
			"desc" => "Customize the way Wikiful integrates with Wordpress.");
	
	$wikiful_options[] = array(	"name" => $wikiful->name." URL",
			"desc" => "The default site URL of your ".$wikiful->name." installation. <br />To include a wiki in a Wordpress page, simply include the tag:<br /><strong>[wikiful url=http://my-wiki.com]</strong><br />in your Wordpress page, where my-wiki.com is the URL to your wiki.",
			"id" => $wikiful->slug."_url",
			"type" => "text");
	
	$wikiful_options[] = array(  "name" => "Styling Settings",
            "type" => "heading",
			"desc" => "This section customizes the look and feel.");
	/*
	$wikiful_options[] = array(	"name" => "Don't load jQuery",
			"desc" => "If you have a theme using jQuery, you can avoid loading it twice by ticking this box",
			"id" => $wikiful->slug."_jquery",
			"type" => "checkbox");
			*/
	$wikiful_options[] = array(	"name" => "Custom styles",
			"desc" => 'Enter your custom CSS styles here',
			"id" => $wikiful->slug."_css",
			"type" => "textarea");
	/*
	$wikiful_options[] = array(	"name" => "Load ".$wikiful->name." styles",
			"desc" => 'Select if you want to load the '.$wikiful->name.' style.css style sheet',
			"id" => $wikiful->slug."_style",
			"type" => "checkbox");
			*/
	$wikiful_options[] = array(  "name" => "Other Settings",
            "type" => "heading",
			"desc" => "This section customizes miscellaneous settings.");
	$wikiful_options[] = array(	"name" => "Debug",
			"desc" => "If you have problems with the plugin, activate the debug mode to generate a debug log for our support team",
			"id" => $wikiful->slug."_debug",
			"type" => "checkbox");
	$wikiful_options[] = array(	"name" => "Footer",
			"desc" => "Tick this box to show a footer on your Wikiful page, showing your support to our development team.",
			"id" => $wikiful->slug."_footer",
			"type" => "checkbox");
	
	return $wikiful_options;
}

function wikiful_add_admin() {
	global $wikiful;

	$wikiful_options=wikiful_options();

	if (isset($_GET['page']) && ($_GET['page'] == $wikiful->slug)) {
		
		if ( isset($_REQUEST['action']) && 'install' == $_REQUEST['action'] ) {
			delete_option('wikiful_log');
			foreach ($wikiful_options as $value) {
				if( isset($value['id']) && isset( $_REQUEST[ $value['id'] ] ) ) {
					update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
				}
			}
			$wikiful->install();
			if (function_exists('wikiful_sso_update')) wikiful_sso_update();
			header("Location: options-general.php?page=".$wikiful->slug."&installed=true");
			die;
		}
	}

	add_options_page($wikiful->name, $wikiful->name, 'administrator', $wikiful->slug,'wikiful_admin');
}

function wikiful_admin() {
	global $wikiful;
	
	$controlpanelOptions=wikiful_options();

	if ( isset($_REQUEST['installed']) ) echo '<div id="message" class="updated fade"><p><strong>'.$wikiful->name.' installed.</strong></p></div>';
	if ( isset($_REQUEST['error']) ) echo '<div id="message" class="updated fade"><p>The following error occured: <strong>'.$_REQUEST['error'].'</strong></p></div>';
	
	?>
<div class="wrap">
<div id="cc-left" style="position:relative;float:left;width:80%">
<h2><b><?php echo $wikiful->name; ?></b></h2>

	<?php
	$wikiful_version=get_option("wikiful_version");
	$submit='Update';
	?>
<form method="post">

<?php require(dirname(__FILE__).'/includes/cpedit.inc.php')?>

<p class="submit"><input name="install" type="submit" value="<?php echo $submit;?>" /> <input
	type="hidden" name="action" value="install"
/></p>
</form>
<hr />
<?php  
	if ($wikiful_version && get_option('wikiful_debug')) {
		echo '<h2 style="color: green;">Debug log</h2>';
		echo '<textarea rows=10 cols=80>';
		$r=get_option('wikiful_log');
		if ($r) {
			$v=$r;
			foreach ($v as $m) {
				echo date('H:i:s',$m[0]).' '.$m[1].chr(13).chr(10);
				echo $m[2].chr(13).chr(10);
			}
		}
		echo '</textarea><hr />';
	}
?>

</div> <!-- end cc-left -->
<?php
	require(dirname(__FILE__).'/includes/support-us.inc.php');
	zing_support_us($wikiful->slug,$wikiful->slug,$wikiful->slug,$wikiful->version);
}
add_action('admin_menu', 'wikiful_add_admin'); ?>