<?php
/**
 * Template Name: Oferta dziedzinowa
 * @package dwaplusjeden
 */

get_header();
?>

	<main id="primary" class="site-main test">
		<?php
		while ( have_posts() ) :
			the_post();
            get_template_part( 'template-parts/organisms/ofertadziedzinowa/od-hero' );
			get_template_part( 'template-parts/organisms/ofertadziedzinowa/od-info' );
            get_template_part( 'template-parts/organisms/ofertadziedzinowa/od-cta' );
            get_template_part( 'template-parts/organisms/ofertadziedzinowa/od-services' );
            get_template_part( 'template-parts/organisms/global/trust-section' );
            get_template_part(
                'template-parts/organisms/global/proces-section',
                null,
                array(
                    'field_prefix' => 'od_process',
                )
            );
            get_template_part( 'template-parts/organisms/ofertadziedzinowa/od-call' );
            get_template_part(
                'template-parts/organisms/global/faq-section',
                null,
                array(
                    'field_prefix' => 'od_faq',
                )
            );
            get_template_part(
                'template-parts/organisms/global/knowledge-section',
                null,
                array(
                    'field_prefix' => 'od_knowledge',
                )
            );
            get_template_part( 'template-parts/organisms/ofertadziedzinowa/od-more' );
		endwhile;
		?>
	</main>

<?php
get_footer();
