<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package marcela
 */
?>

	</div><!-- #content -->

	<?php if(is_page ( 30 ) ) { ?>
		<footer id="colophon" class="site-footer" role="contentinfo">
			
			<?php get_template_part( 'menu', 'social' ); ?>

			<div class="site-info">
				<p>© All rights reserved 1998-<?php echo date('Y'); ?> - Contact: +33 6 14492873 - <a href="mailto:marcceba2@yahoo.es">marcceba2@yahoo.es</a></p>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	<?php } ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
