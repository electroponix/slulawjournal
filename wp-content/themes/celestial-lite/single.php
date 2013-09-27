<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Template for displaying single posts
 *
 * @file           single.php
 * @package        Celestial Lite
 * @since          Celestial Lite 1.0 
 * @author         Styled Themes 
 * @copyright      2012-2013 Styledthemes.com
 * @license        license.txt
 */
 
get_header(); ?>


<?php if (get_theme_mod('blog_left') ) : // Use this layout if the blog left is selected ?>

<?php get_sidebar( 'left' ); ?>

	<section id="primary" class="span8 offset1">
		<div id="content" role="main">
		
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( '/partials/content', 'single' ); ?>
				
				<div class="navigation">
			        <div class="previous"><?php previous_post_link( '&#8249; %link' ); ?></div>
                    <div class="next"><?php next_post_link( '%link &#8250;' ); ?></div>
		        </div><!-- .navigation -->
				<?php comments_template( '', true ); ?>
				
			<?php endwhile; // end of the loop. ?>
	</div><!-- #content -->
	</section><!-- #primary -->

	

<?php else : // If the left sidebar is not selected - use this layout ?>	

	<section id="primary" class="site-content span8">
		<div id="content" role="main">
		
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( '/partials/content', 'single' ); ?>
				
				<div class="navigation">
			        <div class="previous"><?php previous_post_link( '&#8249; %link' ); ?></div>
                    <div class="next"><?php next_post_link( '%link &#8250;' ); ?></div>
		        </div><!-- .navigation -->
				<?php comments_template( '', true ); ?>
				
			<?php endwhile; // end of the loop. ?>
	</div><!-- #content -->
	</section><!-- #primary -->

	<?php get_sidebar(); ?>
	
<?php endif; ?>
	
<?php get_footer(); ?>