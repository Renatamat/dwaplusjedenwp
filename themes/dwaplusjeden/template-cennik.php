<?php
/**
 * Template Name: Cennik
 *
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
					'field_prefix' => 'cennik_hero',
				)
			);
			get_template_part(
				'template-parts/organisms/global/pakiety-section',
				null,
				array(
					'field_prefix' => 'cennik_packages',
				)
			);
			get_template_part(
				'template-parts/organisms/global/cta-button-section',
				null,
				array(
					'field_prefix' => 'cennik_cta_button',
				)
			);
			get_template_part(
                'template-parts/organisms/global/faq-section',
                null,
                array(
                    'field_prefix' => 'cennik_outside_package',
                )
            );
			get_template_part( 'template-parts/organisms/global/trust-section' );
			get_template_part(
                'template-parts/organisms/global/faq-section',
                null,
                array(
                    'field_prefix' => 'cennik_faq',
                )
            );
		endwhile;
		?>
	</main>

<?php
get_footer();
