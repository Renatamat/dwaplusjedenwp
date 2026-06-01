<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package dwaplusjeden
 */

?>

	<footer id="colophon" class="site-footer pt-80 pt-lg-132">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="border-footer">
						<?php get_template_part( 'template-parts/organisms/global/footer-cta' ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php get_template_part( 'template-parts/organisms/global/footer-main' ); ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
