<?php
/**
 * Archive template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dwaplusjeden
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	if ( is_category() ) :
		get_template_part( 'template-parts/organisms/blog/blog-hero-taxonomy' );
		get_template_part( 'template-parts/organisms/blog/blog-allnews-taxonomy' );
	elseif ( is_tag() || is_date() || is_author() ) :
		get_template_part( 'template-parts/organisms/blog/blog-hero' );
		get_template_part( 'template-parts/organisms/blog/blog-new' );
		get_template_part( 'template-parts/organisms/blog/blog-allnews' );
	elseif ( have_posts() ) :
		?>
		<header class="page-header">
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header>
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', get_post_type() );
		endwhile;

		the_posts_navigation();
	else :
		get_template_part( 'template-parts/content', 'none' );
	endif;
	?>
</main>

<?php
get_footer();
