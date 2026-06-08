<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package dwaplusjeden
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/organisms/blog-single/blog-single-title' );
		get_template_part( 'template-parts/organisms/blog-single/blog-single-content' );
		get_template_part( 'template-parts/organisms/blog-single/blog-single-cta' );
		get_template_part( 'template-parts/organisms/blog-single/blog-single-more' );
	endwhile;
	?>
</main>

<?php
get_footer();
