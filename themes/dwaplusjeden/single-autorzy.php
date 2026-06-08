<?php
/**
 * The template for displaying single authors.
 *
 * @package dwaplusjeden
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/organisms/author/author' );
		get_template_part( 'template-parts/organisms/author/author-article' );
	endwhile;
	?>
</main>

<?php
get_footer();
