<?php
/**
 * Template Name: Strona branż
 *
 * @package dwaplusjeden
 */

get_header();
?>

	<main id="primary" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part(
				'template-parts/organisms/global/simple-hero-section',
				null,
				array(
					'field_prefix' => 'branze_hero',
				)
			);
			get_template_part(
				'template-parts/organisms/global/global-brand',
				null,
				array(
					'field_prefix' => 'branze_brand',
				)
			);
			get_template_part(
				'template-parts/organisms/global/cta-accordion-section',
				null,
				array(
					'field_prefix' => 'branze_cta',
				)
			);
			get_template_part( 'template-parts/organisms/global/trust-section' );
			get_template_part(
				'template-parts/organisms/oferta-branzowa/ob-offer',
				null,
				array(
					'field_prefix' => 'branze_offer',
				)
			);
			get_template_part(
				'template-parts/organisms/global/proces-section',
				null,
				array(
					'field_prefix' => 'branze_process',
				)
			);
			get_template_part(
				'template-parts/organisms/ofertadziedzinowa/od-call',
				null,
				array(
					'field_prefix' => 'branze_call',
				)
			);
			get_template_part(
				'template-parts/organisms/global/faq-section',
				null,
				array(
					'field_prefix' => 'branze_faq',
				)
			);
		endwhile;
		?>
	</main>

<?php
get_footer();
