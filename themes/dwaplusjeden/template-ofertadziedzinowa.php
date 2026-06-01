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
            get_template_part( 'template-parts/organisms/ofertadziedzinowa/od-trust' );
            get_template_part( 'template-parts/organisms/ofertadziedzinowa/od-proces' );
            get_template_part( 'template-parts/organisms/ofertadziedzinowa/od-call' );
            get_template_part( 'template-parts/organisms/ofertadziedzinowa/od-faq' );
            get_template_part( 'template-parts/organisms/ofertadziedzinowa/od-knowledge' );
            get_template_part( 'template-parts/organisms/ofertadziedzinowa/od-more' );
		endwhile;
		?>
	</main>

<?php
get_footer();
