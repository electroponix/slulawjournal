<?php
/**
 * Menu Primary Template
 * 
 * @package 	Tiga
 * @author		Satrya
 * @license		license.txt
 * @since 		1.4
 *
 */

if ( has_nav_menu( 'primary' ) ) : ?>

	<nav class="site-navigation main-navigation" role="navigation">

		<h5 class="assistive-text"><?php _e( 'Menu', 'tiga' ); ?></h5>
		<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'tiga' ); ?>"><?php _e( 'Skip to content', 'tiga' ); ?></a></div>

		<?php
			wp_nav_menu( 
				array(  
					'container' => '',
					'menu_class' => 'main-nav',
					'theme_location' => 'primary'
				) 
			); 
		?>
			
	</nav><!-- end .site-navigation .main-navigation -->

<?php endif; ?>