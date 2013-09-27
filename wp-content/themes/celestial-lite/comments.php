<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Template for displaying comments
 *
 * @file           comments.php
 * @package        Celestial Lite
 * @since          Celestial Lite 1.0 
 * @author         Styled Themes 
 * @copyright      2012-2013 Styledthemes.com
 * @license        license.txt
 */
 
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	
	<?php if ( have_comments() ) : ?>
		<h4 class="comments-title">
			<?php
				printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'celestial' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h4>

		<ol id="comment-list">
			<?php wp_list_comments( array( 'callback' => 'styledthemes_comment', 'style' => 'ol' ) ); ?>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'celestial' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'celestial' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'celestial' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'celestial' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form(); ?>	
	
	
</div><!-- #comments .comments-area -->