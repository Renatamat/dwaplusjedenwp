<?php
/**
 * Blog taxonomy archive hero section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$term        = get_queried_object();
$title       = '';
$description = '';

if ( $term instanceof WP_Term ) {
	$title       = $term->name;
	$description = term_description( $term->term_id, $term->taxonomy );
}

if ( ! $title ) {
	$title = get_the_archive_title();
}

if ( ! $description ) {
	$description = __( 'Praktyczne porady, aktualności prawne i wiedza ekspertów o księgowości i prowadzeniu firmy', 'dwaplusjeden' );
}
?>

<section class="blog-hero pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132" aria-labelledby="blog-hero-taxonomy-heading">
	<div class="container">
		<div class="row">
			<div class="col-12 offset-xxxl-1 col-xxxl-10 mx-auto">
				<div class="d-flex flex-column gap-48">
					<div class="d-flex flex-column gap-8">
						<h1 id="blog-hero-taxonomy-heading" class="h6 fw-bolder c-body w-100"><?php echo esc_html( $title ); ?></h1>
						<?php if ( $description ) : ?>
						<div class="row">
  							<div class="col-12 col-xl-8">
								<p class="p-m w-100"><?php echo wp_kses_post( wp_strip_all_tags( $description ) ); ?></p>
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
