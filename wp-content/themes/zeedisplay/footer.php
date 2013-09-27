	<div class="clear"></div>
		
		<?php if(is_active_sidebar('sidebar-footer')) : ?>
		<div id="bottombar">
			<ul>
				<?php dynamic_sidebar('sidebar-footer'); ?>
			</ul>
			<div class="clear"></div>
		</div>
		<?php endif; ?>
		
		<?php themezee_footer_before(); // hook before #footer ?>
		<div id="footer">
			<?php 
				$options = get_option('themezee_options');
				if ( isset($options['themeZee_general_footer']) and $options['themeZee_general_footer'] <> "" ) { 
					echo $options['themeZee_general_footer']; } 
			?>
			<div class="credit_link"><?php themezee_credit_link(); ?></div>
			<div class="clear"></div>
		</div>
		<?php themezee_footer_after(); // hook after #footer ?>
	
	</div><!-- end #wrap -->
</div><!-- end #wrapper -->
<?php themezee_wrapper_after(); // hook after #wrapper ?>

<?php wp_footer(); ?>
</body>
</html>