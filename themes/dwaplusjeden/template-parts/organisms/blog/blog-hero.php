<?php
/**
 * Blog hero section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$posts_page_id = (int) get_option( 'page_for_posts' );
$title         = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Poradnik podatkowy', 'dwaplusjeden' );
$description   = $posts_page_id ? get_the_excerpt( $posts_page_id ) : '';

if ( ! $description ) {
	$description = __( 'Praktyczne porady, aktualności prawne i wiedza ekspertów o księgowości i prowadzeniu firmy', 'dwaplusjeden' );
}
?>

<section class="blog-hero pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132" aria-labelledby="blog-hero-heading">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-xl-6 mx-auto">
				<div class="d-flex flex-column gap-48">
					<div class="d-flex flex-column gap-8">
						<h1 id="blog-hero-heading" class="h5 fw-bolder c-body text-center w-100"><?php echo esc_html( $title ); ?></h1>
						<?php if ( $description ) : ?>
							<p class="p-m text-center w-100"><?php echo esc_html( $description ); ?></p>
						<?php endif; ?>
					</div>
					<form class="d-flex flex-column flex-md-row gap-16" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<label class="InputWrap InputWrap-s InputWrap--noicon w-100">
							<span class="screen-reader-text"><?php esc_html_e( 'Szukaj w blogu', 'dwaplusjeden' ); ?></span>
							<div class="position-relative">
								<div class="InputBox" aria-hidden="true">
									<span class="InputPlaceholder"><?php esc_html_e( 'Napisz czego szukasz', 'dwaplusjeden' ); ?></span>
								</div>
								<span class="wpcf7">
									<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>">
								</span>
							</div>
						</label>
						<button type="submit" class="c-btn c-btn-s c-btn-outline">
							<span><?php esc_html_e( 'Szukaj', 'dwaplusjeden' ); ?></span>
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
