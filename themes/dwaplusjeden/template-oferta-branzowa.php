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
			get_template_part( 'template-parts/organisms/oferta-branzowa/ob-info' );
			get_template_part( 'template-parts/organisms/oferta-branzowa/ob-cta' );
			get_template_part( 'template-parts/organisms/oferta-branzowa/ob-offer' );
			get_template_part( 'template-parts/organisms/oferta-branzowa/ob-proces' );
			get_template_part( 'template-parts/organisms/oferta-branzowa/ob-call' );
			get_template_part( 'template-parts/organisms/oferta-branzowa/ob-faq' );
			get_template_part( 'template-parts/organisms/oferta-branzowa/ob-knowledge' );
			get_template_part( 'template-parts/organisms/oferta-branzowa/ob-more' );
		endwhile;
		?>
	</main>

<?php
get_footer();
