<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Template for displaying widgets in this left sidebar
 *
 * @file           sidebar-left.php
 * @package        Celestial Lite 
 * @since          Celestial Lite 1.0
 * @author         Styled Themes 
 * @copyright      2012-2013 Styledthemes.com
 * @license        license.txt
 */
  
?>

	<?php if ( is_active_sidebar( 'sidebar-6' ) ) : ?>
		<div id="secondary" class="widget-area span3" role="complementary">
			<div id="st-left" class="st-sidebar-list">
			<?php dynamic_sidebar( 'sidebar-6' ); ?>
			</div>
		</div><!-- #secondary -->
	<?php endif; ?>