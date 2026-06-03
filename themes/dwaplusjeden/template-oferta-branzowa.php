<?php
/**
 * Template Name: Oferta branżowa
 *
 * @package dwaplusjeden
 */

get_header();
?>

	<main id="primary" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/organisms/oferta-branzowa/breadcrumb' );
			get_template_part( 'template-parts/organisms/oferta-branzowa/ob-hero' );
			get_template_part(
				'template-parts/organisms/global/info-section',
				null,
				array(
					'field_prefix' => 'ob_info',
				)
			);
			get_template_part(
				'template-parts/organisms/global/cta-accordion-section',
				null,
				array(
					'field_prefix' => 'ob_cta',
				)
			);
			get_template_part( 'template-parts/organisms/global/trust-section' );
			get_template_part( 'template-parts/organisms/oferta-branzowa/ob-offer' );
			get_template_part(
				'template-parts/organisms/global/proces-section',
				null,
				array(
					'field_prefix' => 'ob_process',
				)
			);
			get_template_part( 'template-parts/organisms/oferta-branzowa/ob-call' );
			get_template_part(
				'template-parts/organisms/global/faq-section',
				null,
				array(
					'field_prefix' => 'ob_faq',
				)
			);
			get_template_part(
				'template-parts/organisms/global/knowledge-section',
				null,
				array(
					'field_prefix' => 'ob_knowledge',
				)
			);
			get_template_part(
				'template-parts/organisms/global/more-section',
				null,
				array(
					'field_prefix' => 'ob_more',
				)
			);
		endwhile;
		?>
	</main>

<?php
get_footer();
