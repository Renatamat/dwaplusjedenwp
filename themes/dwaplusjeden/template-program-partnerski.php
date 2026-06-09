<?php
/**
 * Template Name: Program partnerski
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
					'field_prefix' => 'pp_hero',
				)
			);
			get_template_part( 'template-parts/organisms/program-partnerski/pp-desc' );
			get_template_part(
				'template-parts/organisms/global/info-section',
				null,
				array(
					'field_prefix' => 'pp_benefits',
				)
			);
			get_template_part( 'template-parts/organisms/program-partnerski/pp-requirements' );
			get_template_part( 'template-parts/organisms/program-partnerski/pp-proces' );
			get_template_part(
				'template-parts/organisms/global/help-cta-section',
				null,
				array(
					'field_name' => 'pp_cta',
					'post_id'    => get_the_ID(),
				)
			);
		endwhile;
		?>
	</main>

<?php
get_footer();
