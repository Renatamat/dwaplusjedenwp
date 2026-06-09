<?php
/**
 * Partner program description section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || false === get_field( 'pp_desc_enabled' ) ) {
	return;
}

$heading = get_field( 'pp_desc_heading' );
$text    = get_field( 'pp_desc_text' );
$link    = dwaplusjeden_get_acf_link( 'pp_desc_link', get_the_ID() );
$image   = get_field( 'pp_desc_image' );

if ( ! $heading && ! $text && empty( $link['url'] ) && ! $image ) {
	return;
}
?>

<section class="pp-desc pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="pp-desc-heading"' : ''; ?>>
	<div class="container">
		<div class="row r-gap-24 r-gap-lg-48">
			<div class="offset-xxxl-1 col-lg-6 col-xxxl-5 order-2 order-lg-1">
				<div class="d-flex flex-column gap-24 pp-desc-content">
					<?php if ( $heading ) : ?>
						<h2 id="pp-desc-heading" class="h6 fw-bolder c-body a-slide-left" data-animate-delay="0.08"><?php echo wp_kses_post( $heading ); ?></h2>
					<?php endif; ?>

					<?php if ( $text ) : ?>
						<p class="p-m pr-xxxl-48 a-slide-left" data-animate-delay="0.18"><?php echo wp_kses_post( $text ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $link['url'] ) ) : ?>
						<a<?php dwaplusjeden_link_attrs( $link ); ?> class="c-btn c-btn-s c-btn-fill pp-desc-btn a-slide-left" data-animate-delay="0.12">
							<span><?php echo esc_html( $link['title'] ?: $link['url'] ); ?></span>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $image ) : ?>
				<div class="col-lg-6 order-1 order-lg-2">
					<div class="pp-desc-image">
						<?php dwaplusjeden_image( $image, 'full', '', wp_strip_all_tags( $heading ) ); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
