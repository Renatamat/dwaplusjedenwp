<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package dwaplusjeden
 */

get_header();
?>

	<main id="primary" class="site-main">

	<section class="page404 pt-96 pb-96">
		<div class="container">
			<div class="row">
				<div class="col-xl-8 col-xxxl-6 mx-auto">
					<div class="page404-container">
						<div class="d-flex flex-column align-items-center">
							<span class="page404-header">404</span>
							<div class="d-flex flex-column gap-32 align-items-center">
								<div class="d-flex flex-column gap-16 align-items-center">
									<span class="h6 fw-bolder c-body text-center">Nie znaleziono strony</span>
									<p class="p-l text-center">Nie możemy odnaleźć strony, której szukasz.<br>
									Sprawdź adres strony lub przejdź na stronę główną</p>
								</div>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="c-btn c-btn-s c-btn-fill">
									<span>Strona główna</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	</main><!-- #main -->

<?php
get_footer();
