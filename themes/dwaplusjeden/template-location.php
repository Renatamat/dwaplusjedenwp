<?php
/**
 * Template Name: Strona lokalizacja
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
				'template-parts/organisms/global/simple-hero-location-section',
				null,
				array(
					'field_prefix' => 'location_hero',
				)
			);
			get_template_part(
				'template-parts/organisms/homepage/hp-hero-slider',
				null,
				array(
					'field_prefix' => 'location_slider',
				)
			);
			get_template_part(
				'template-parts/organisms/homepage/hp-services',
				null,
				array(
					'field_prefix' => 'location_services',
				)
			);
			get_template_part(
				'template-parts/organisms/global/cta-accordion-section',
				null,
				array(
					'field_prefix' => 'location_cta',
				)
			);
			get_template_part(
				'template-parts/organisms/homepage/hp-info',
				null,
				array(
					'field_prefix' => 'location_info',
				)
			);
			get_template_part( 'template-parts/organisms/global/trust-section' );
			get_template_part(
				'template-parts/organisms/global/proces-section',
				null,
				array(
					'field_prefix' => 'location_process',
				)
			);
			get_template_part(
				'template-parts/organisms/oferta-branzowa/ob-call',
				null,
				array(
					'field_prefix' => 'location_call',
				)
			);
			get_template_part(
				'template-parts/organisms/global/faq-section',
				null,
				array(
					'field_prefix' => 'location_faq',
				)
			);
			get_template_part(
				'template-parts/organisms/global/section-seo',
				null,
				array(
					'field_prefix' => 'location_seo_right',
				)
			);
			get_template_part(
				'template-parts/organisms/global/section-seo',
				null,
				array(
					'field_prefix' => 'location_seo_left',
				)
			);
			get_template_part(
				'template-parts/organisms/global/knowledge-section',
				null,
				array(
					'field_prefix' => 'location_knowledge',
				)
			);
		endwhile;
		?>
	</main>

<?php
get_footer();
