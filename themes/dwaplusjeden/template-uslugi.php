<?php
/**
 * Template Name: Strona usług
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
					'field_prefix' => 'uslugi_hero',
				)
			);
			get_template_part(
				'template-parts/organisms/global/global-services',
				null,
				array(
					'field_prefix' => 'uslugi_global_services',
					'parent_page_id' => 2245,
				)
			);
			get_template_part(
				'template-parts/organisms/global/cta-accordion-section',
				null,
				array(
					'field_prefix' => 'uslugi_cta',
				)
			);
			get_template_part(
				'template-parts/organisms/ofertadziedzinowa/od-services',
				null,
				array(
					'field_prefix' => 'uslugi_services',
				)
			);
			get_template_part( 'template-parts/organisms/global/trust-section' );
			get_template_part(
				'template-parts/organisms/global/proces-section',
				null,
				array(
					'field_prefix' => 'uslugi_process',
				)
			);
			get_template_part(
				'template-parts/organisms/oferta-branzowa/ob-call',
				null,
				array(
					'field_prefix' => 'uslugi_call',
				)
			);
			get_template_part(
				'template-parts/organisms/global/faq-section',
				null,
				array(
					'field_prefix' => 'uslugi_faq',
				)
			);
		endwhile;
		?>
	</main>

<?php
get_footer();
