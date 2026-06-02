<?php
/**
 * Template Name: Rejestracja działalności
 * @package dwaplusjeden
 */

get_header();
?>

	<main id="primary" class="site-main test">
		<?php
		while ( have_posts() ) :
			the_post();
            
		endwhile;
		?>
	</main>

<?php
get_footer();
