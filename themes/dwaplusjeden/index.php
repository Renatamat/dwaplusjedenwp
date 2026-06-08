<?php
/**
 * Blog index template.
 *
 * @package dwaplusjeden
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	get_template_part( 'template-parts/organisms/blog/blog-hero' );
	get_template_part( 'template-parts/organisms/blog/blog-new' );
	get_template_part( 'template-parts/organisms/blog/blog-allnews' );
	?>
</main>

<?php
get_footer();
