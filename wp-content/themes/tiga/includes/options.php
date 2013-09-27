<?php
/**
 * Theme settings
 *
 * @package Tiga
 * @author Satrya
 * @license docs/license.txt
 * @since 0.0.1
 *
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );

}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 *  
 */

function optionsframework_options() {
	
	$tiga_background = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' 
	);
	
	$tiga_numbers = array(
		'2' => __( 'Two', 'tiga' ), 
		'3' => __( 'Three', 'tiga' ), 
		'4' => __( 'Four', 'tiga' ), 
		'5' => __( 'Five', 'tiga' ), 
		'6' => __( 'Six', 'tiga' ), 
		'7' => __( 'Seven', 'tiga' ), 
		'8' => __( 'Eight', 'tiga' ), 
		'9' => __( 'Nine', 'tiga' ), 
		'10' => __( 'Ten', 'tiga' ) 
	);
	
	$tiga_select = array(
		'enable' => __( 'Enable', 'tiga' ), 
		'disable' => __( 'Disable', 'tiga' ) 
	);

	$tiga_social = array(
		'tiga_post' => __( 'Single post', 'tiga' ),
		'tiga_page' => __( 'Page', 'tiga' ),
		'tiga_both' => __( 'Both', 'tiga' ),
		'tiga_none' => __( 'None', 'tiga' )
	);
	
	$imagepath =  get_template_directory_uri() . '/img/layouts/';
	$patternpath =  get_template_directory_uri() . '/img/bg/';
		
	$options = array();
	
	$options[] = array( 
		'name' => __( 'General', 'tiga' ),
		'type' => 'heading'
	);
								
	$options[] = array( 
		'name' => __( 'Custom Favicon', 'tiga' ),
		'desc' => __( 'Upload a favicon for your website, or specify the image address of your online favicon. (http://example.com/favicon.png)', 'tiga' ),
		'id' => 'tiga_custom_favicon',
		'type' => 'upload'
	);
						
	$options[] = array( 
		'name' => __( 'Iframe Blocker', 'tiga' ),
		'desc' => __( 'Iframe blocker is for block iframe to your site such as google image.', 'tiga' ),
		'id' => 'tiga_iframe_blocker',
		'std' => 'disable',
		'type' => 'select',
		'options' => $tiga_select
	);

	$options[] = array( 
		'name' => __( 'Disable credit links', 'tiga' ),
		'desc' => __( 'Are you sure want to disable the credit link for WordPress and theme author?', 'tiga' ),
		'id' => 'tiga_credits',
		'type' => 'checkbox'
	);
						
	/* ============================== End General Settings ================================= */					
	
	$options[] = array( 
		'name' => __( 'Theme', 'tiga' ),
		'type' => 'heading'
	);
						
	$options[] = array( 
		'name' => __( 'Global Layouts', 'tiga' ),
		'desc' => __( 'Left content, right content or one column', 'tiga' ),
		'id' => 'tiga_layouts',
		'std' => 'lcontent',
		'type' => 'images',
		'options' => array(
			'lcontent' => $imagepath . '2cr.png',
			'rcontent' => $imagepath . '2cl.png',
			'onecolumn' => $imagepath . '1col.png',
		)
	);

	$options[] = array( 
		'name' => __( 'Home Page Layouts', 'tiga' ),
		'desc' => __( 'Two columns or one column', 'tiga' ),
		'id' => 'tiga_home_layouts',
		'std' => 'one-col',
		'type' => 'images',
		'options' => array(
			'two-cols' => $imagepath . 'l-mag.png',
			'one-col' => $imagepath . 'l-standard.png'
		)
	);
	
	$options[] = array( 
		'name' => __( 'Background Pattern', 'tiga' ),
		'desc' => __( 'Available background pattern to customize your site', 'tiga' ),
		'id' => 'tiga_pattern',
		'std' => 'pattern-0',
		'type' => 'images',
		'options' => array(
			'pattern-0' => $patternpath . '0.png',
			'pattern-1' => $patternpath . '1.png',
			'pattern-2' => $patternpath . '2.png',
			'pattern-3' => $patternpath . '3.png',
			'pattern-4' => $patternpath . '4.png',
			'pattern-5' => $patternpath . '5.jpg',
			'pattern-6' => $patternpath . '6.jpg',
			'pattern-7' => $patternpath . '7.png',
			'pattern-8' => $patternpath . '8.png',
			'pattern-9' => $patternpath . '9.png',
			'pattern-10' => $patternpath . '10.png'
		)
	);
	
	/* ============================== End Theme Settings ================================= */	
	
	$options[] = array( 
		'name' => __( 'Typography', 'tiga' ),
		'type' => 'heading'
	);

	$options[] = array( 
		'name' => __( 'Disable custom typography', 'tiga' ),
		'desc' => __( 'Disable custom typography and use theme defaults.', 'tiga' ),
		'id' => 'tiga_disable_typography',
		'std' => true,
		'type' => 'checkbox' 
	);

	$options[] = array( 
		'name' => __( 'Content typography', 'tiga' ),
		'desc' => __( 'This font is used for content text.', 'tiga' ),
		'id' => 'tiga_content_font',
		'class' => 'hidden',
		'std' => array('size' => '13px','face' => '"Open Sans", sans-serif', 'color' => '#333333' ),
		'type' => 'typography',
		'options' => array(
			'sizes' => array( '12','13','14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24' ),
			'faces' => array(
				'"Open Sans", sans-serif' => 'Open Sans',
				'Arial, "Helvetica Neue", Helvetica, sans-serif' => 'Arial',
				'Georgia, Palatino, "Palatino Linotype", Times, "Times New Roman", serif' => 'Georgia',
				'Tahoma, Geneva, Verdana, sans-serif' => 'Tahoma',
				'"Helvetica Neue", Arial, Helvetica, sans-serif' => 'Helvetica',
				'Verdana, Geneva, sans-serif' => 'Verdana',
				'Times, "Times New Roman", Georgia, serif' => 'Times New Roman',
				'"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif' => 'Trebuchet MS',
				'Cambria, Georgia, serif' => 'Cambria',
				'Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif' => 'Calibri'
			),
			'styles' => array( 'normal' => 'Normal', 'bold' => 'Bold' )
		)
	);

	$options[] = array( 
		'name' => __( 'Content heading typography', 'tiga' ),
		'desc' => __( 'Select the headline font (h1,h2,h3 etc)', 'tiga' ),
		'id' => 'tiga_heading_font',
		'class' => 'hidden',
		'std' => array('size' => '13px','face' => '"Francois One", sans-serif', 'color' => '#333333' ),
		'type' => 'typography',
		'options' => array(
			'sizes' => false,
			'faces' => array(
				'"Francois One", sans-serif' => 'Francois Regular',
				'Arial, "Helvetica Neue", Helvetica, sans-serif' => 'Arial',
				'Georgia, Palatino, "Palatino Linotype", Times, "Times New Roman", serif' => 'Georgia',
				'Tahoma, Geneva, Verdana, sans-serif' => 'Tahoma',
				'"Helvetica Neue", Arial, Helvetica, sans-serif' => 'Helvetica',
				'Verdana, Geneva, sans-serif' => 'Verdana',
				'Times, "Times New Roman", Georgia, serif' => 'Times New Roman',
				'"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif' => 'Trebuchet MS',
				'Cambria, Georgia, serif' => 'Cambria',
				'Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif' => 'Calibri'
			),
			'styles' => array( 'normal' => 'Normal',  'bold' => 'Bold' )
		)
	);

	/* ============================== End Typography Settings ================================= */

	$options[] = array( 
		'name' => __( 'Page', 'tiga' ),
		'type' => 'heading'
	);
						
	$options[] = array( 
		'name' => __( 'Display social share button', 'tiga' ),
		'desc' => __( 'Display social share on single post and page', 'tiga' ),
		'id' => "tiga_social_share",
		'std' => 'tiga_post',
		'type' => "radio",
		'options' => $tiga_social
	);
						
	$options[] = array( 
		'name' => __( 'Display author box', 'tiga' ),
		'desc' => __( 'Check this option if you want display the author box on single posts', 'tiga' ),
		'id' => 'tiga_author_box',
		'type' => 'checkbox'
	);

	/* ============================== End Page Settings ================================= */

	$options[] = array( 
		'name' => __( 'Custom Code', 'tiga' ),
		'type' => 'heading'
	);

	$options[] = array( 
		'name' => __( 'Custom CSS', 'tiga' ),
		'desc' => __( 'Quickly add some CSS to your theme by adding it to this block.', 'tiga' ),
		'id' => 'tiga_custom_css',
		'std' => '',
		'type' => 'textarea'
	); 
						
	$options[] = array( 
		'name' => __( 'Header Code', 'tiga' ),
		'desc' => __( 'Add any custom script like the meta verification from various search engine. It will be inserted before the closing head tag of your theme', 'tiga' ),
		'id' => 'tiga_header_code',
		'type' => 'textarea'
	); 	
						
	$options[] = array( 
		'name' => __( 'Footer Code', 'tiga' ),
		'desc' => __( 'Add your analytic code or you can add any custom script here. It will be inserted before the closing body tag of your theme', 'tiga' ),
		'id' => 'tiga_footer_code',
		'type' => 'textarea'
	); 		 	 

	/* ============================== End Custom Code Settings ================================= */

	$options[] = array( 
		'name' => __( 'What\'s new?', 'tiga' ),
		'type' => 'heading'
	);

	$options[] = array(
		'name' => 'New in TIGA 1.9',
		'desc' => '
			<ol class="ol-decimal">
				<li><a href="#lang">Added Spanish Language</a></li>
				<li><a href="#tag">Fix H1 on home page</a></li>
				<li><a href="#select">Fix long select menu</a></li>
				<li><a href="#twitter">Remove the twitter widget</a></li>
				<li><a href="#support">Support</a></li>
			</ol>

			<h4 id="lang" class="heading">1. Added Spanish Language</h4>
			<p>Now Tiga support Spanish. Whoosah! Say thanks to <a href="http://wordpress.org/support/topic/header-logo-on-tiga-child-theme" target="_blank">josediez</a>.</p>

			<h4 id="tag" class="heading">2. Fix H1 on home page</h4>
			<p>Fix H1 on home page when user use logo.</p>

			<h4 id="tag" class="heading">3. Fix long select menu</h4>
			<p>Fix long select menu in the sidebar.</p>

			<h4 id="twitter" class="heading">4. Remove the twitter widget</h4>
			<p>Twitter just update their API and this cause the problem with the twitter widget. I decided to remove it now, please just use <a href="http://wordpress.org/plugins/recent-tweets-widget/" target="_blank">http://wordpress.org/plugins/recent-tweets-widget/</a></p>

			<h4 id="support" class="heading">5. Support</h4>
			<p>If you wish to contribute to all of my projects including this theme development & support, you can make a donation to the theme author.</p>
			<a href="http://satrya.me/donate/" target="_blank"><img src="' . get_template_directory_uri() . '/img/donate.gif"></a>
		',
		'type' => 'info'
	);

	return $options;
	
}
?>