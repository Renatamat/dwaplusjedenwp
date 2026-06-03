<?php
/**
 * Template Name: Rejestracja działalności
 * @package dwaplusjeden
 */

get_header();
?>

	<main id="primary" class="site-main test">
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part(
				'template-parts/organisms/global/simple-hero-section',
				null,
				array(
					'field_prefix' => 'rd_hero',
				)
			);
            get_template_part( 'template-parts/organisms/rejestracjadzialalnosci/rd-info' );
			get_template_part( 'template-parts/organisms/rejestracjadzialalnosci/rd-desc' );
			get_template_part(
				'template-parts/organisms/global/cta-button-section',
				null,
				array(
					'field_prefix' => 'rd_cta_button',
				)
			);
			get_template_part( 'template-parts/organisms/rejestracjadzialalnosci/rd-services' );
			get_template_part( 'template-parts/organisms/rejestracjadzialalnosci/rd-benefits' );
			get_template_part( 'template-parts/organisms/global/trust-section' );
			get_template_part(
                'template-parts/organisms/global/faq-section',
                null,
                array(
                    'field_prefix' => 'rd_faq',
                )
            );
            get_template_part(
                'template-parts/organisms/global/knowledge-section',
                null,
                array(
                    'field_prefix' => 'rd_knowledge',
                )
            );
            get_template_part(
                'template-parts/organisms/global/more-section',
                null,
                array(
                    'field_prefix' => 'rd_more',
                )
            );
		endwhile;
		?>
	</main>

<?php
get_footer();
