<?php
/**
 * Template Name: O nas
 *
 * @package dwaplusjeden
 */

get_header();
?>

	<main id="primary" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/organisms/about/about-hero' );
			get_template_part( 'template-parts/organisms/about/about-mission' );
			get_template_part(
				'template-parts/organisms/global/info-section',
				null,
				array(
					'field_prefix' => 'about_values',
				)
			);
			get_template_part( 'template-parts/organisms/about/about-team' );
			get_template_part( 'template-parts/organisms/about/about-info' );
			get_template_part( 'template-parts/organisms/about/about-cta' );
		endwhile;
		?>
	</main>

<?php
get_footer();
