<?php
/**
 * Template Name: Blank page (single)
 *
 * @package dwaplusjeden
 */

get_header();
?>

	<main id="primary" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/organisms/blank/blank-header' );
			get_template_part( 'template-parts/organisms/blank/blank-content' );

			if ( function_exists( 'get_field' ) && get_field( 'blank_help_cta_enabled' ) ) {
				get_template_part( 'template-parts/organisms/global/help-cta-section' );
			}
		endwhile;
		?>
	</main>

<?php
get_footer();
