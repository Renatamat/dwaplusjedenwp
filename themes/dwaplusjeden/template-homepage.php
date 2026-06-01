<?php
/**
 * Template Name: Strona główna
 *
 * @package dwaplusjeden
 */

get_header();
?>

	<main id="primary" class="site-main test">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/organisms/homepage/hp-hero' );
			get_template_part( 'template-parts/organisms/homepage/hp-hero-slider' );
			get_template_part( 'template-parts/organisms/homepage/hp-services' );
			get_template_part( 'template-parts/organisms/homepage/hp-cta' );
			get_template_part( 'template-parts/organisms/homepage/hp-info' );
			get_template_part( 'template-parts/organisms/homepage/hp-blog' );
		endwhile;
		?>
	</main>

<?php
get_footer();
