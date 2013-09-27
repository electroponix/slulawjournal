<?php
/** Primary Menu Callback */
function vortex_primary_menu_cb() {
	wp_page_menu();		 
}

/** Primary Menu */
if ( has_nav_menu( 'vortex-primary-menu' ) ) {

  $args = array(
  
	  'container' => 'div', 
	  'container_class' => 'menu', 
	  'theme_location' => 'vortex-primary-menu',
	  'menu_class' => 'sf-menu',
	  'depth' => 0,
	  'fallback_cb' => 'vortex_primary_menu_cb'
			  
  );

  wp_nav_menu( $args );

} else {

  vortex_primary_menu_cb();	

}
?>