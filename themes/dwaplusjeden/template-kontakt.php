<?php
/**
 * Template Name: Kontakt
 *
 * @package dwaplusjeden
 */

get_header();
?>

	<main id="primary" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/organisms/contact/contact-header' );
			get_template_part( 'template-parts/organisms/contact/contact-form' );
			get_template_part( 'template-parts/organisms/contact/contact-popup' );
			get_template_part(
				'template-parts/organisms/global/faq-section',
				null,
				array(
					'field_prefix' => 'contact_faq',
				)
			);
		endwhile;
		?>
	</main>

<?php
get_footer();
