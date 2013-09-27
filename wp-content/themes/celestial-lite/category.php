<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Template for displaying category posts
 *
 * @file           category.php
 * @package        Celestial Lite
 * @since          Celestial Lite 1.0 
 * @author         Styled Themes 
 * @copyright      2012-2013 Styledthemes.com
 * @license        license.txt
 */
 

get_header(); ?>




<?php if (get_theme_mod('blog_left') ) : // Use this layout if the blog left is selected ?>

			<?php get_sidebar('left'); ?>	
			<section id="primary" class="span8 offset1">
				<div id="content" role="main">
					<?php if ( have_posts() ) : ?>
						<header class="page-header">
							<h1 class="page-title"><?php $current_category = single_cat_title("", true); ?></h1>
				
							<?php if ( $category_description = category_description() ) {
								echo apply_filters( 'category_archive_meta', '<div class="category-description">' . $category_description . '</div>' );
							} ?>
						</header><!-- .page-header -->		
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( '/partials/content', get_post_format() ); ?>
					<?php endwhile; ?>		
					<?php endif; ?>	
				</div><!-- #content -->
			</section><!-- #primary -->	

<?php else : // If the left sidebar is not selected - use this layout ?>

	
			<section id="primary" class="span8">
				<div id="content" role="main">
					<?php if ( have_posts() ) : ?>
						<header class="page-header">
							<h1 class="page-title"><?php $current_category = single_cat_title("", true); ?></h1>
				
							<?php if ( $category_description = category_description() ) {
								echo apply_filters( 'category_archive_meta', '<div class="category-description">' . $category_description . '</div>' );
							} ?>
						</header><!-- .page-header -->		
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( '/partials/content', get_post_format() ); ?>
					<?php endwhile; ?>		
					<?php endif; ?>	
				</div><!-- #content -->
			</section><!-- #primary -->	

<?php endif; ?>


	
	<?php if (get_theme_mod('blog_left') ) : // Use this layout if the blog left is selected ?>
	<?php else : // If the left sidebar is not selected - use this layout ?>
		<?php get_sidebar(); ?>
	<?php endif; ?>
	

	<?php get_footer(); ?>