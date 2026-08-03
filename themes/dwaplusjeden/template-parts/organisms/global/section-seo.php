<?php
/**
 * Reusable SEO section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );
$prefix  = ! empty( $args['field_prefix'] ) ? $args['field_prefix'] : 'seo';

if ( $has_acf && false === get_field( $prefix . '_enabled' ) ) {
	return;
}

$heading     = $has_acf ? get_field( $prefix . '_heading' ) : '';
$textdesc    = $has_acf ? get_field( $prefix . '_text_desc' ) : '';
$textheading = $has_acf ? get_field( $prefix . '_text_heading' ) : '';
$text        = $has_acf ? get_field( $prefix . '_text' ) : '';
$image       = $has_acf ? get_field( $prefix . '_image' ) : 0;
$image       = $image ?: 2398;
$has_text    = $text || $textdesc || $textheading;


if ( ! $heading && ! $has_text ) {
	return;
}

$is_left_layout     = false !== strpos( $prefix, 'left' );
$text_column_class  = 'col-lg-7 d-flex align-items-center';
$image_column_class = 'col-lg-5 d-flex align-items-center';

if ( $has_text && $image ) {
	if ( $is_left_layout ) {
		$text_column_class  .= ' order-2 order-lg-2';
		$image_column_class .= ' order-1 order-lg-1';
	} else {
		$text_column_class  .= ' order-2 order-lg-1';
		$image_column_class .= ' order-1 order-lg-2';
	}
}
?>

<section class="section-seo pt-56 pb-56 pt-lg-96 pb-lg-96"<?php echo $heading ? ' aria-labelledby="' . esc_attr( $prefix ) . '-heading"' : ''; ?>>
	<div class="container">
		<?php if ( $heading ) : ?>
			<div class="row">
				<div class="col-12">
					<h2 id="<?php echo esc_attr( $prefix ); ?>-heading" class="h5 fw-bolder c-body text-center w-100">
						<?php echo dwaplusjeden_kses_basic_content( $heading, true ); ?>
					</h2>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $has_text || $image ) : ?>
			<div class="row r-gap-24 mt-32 mt-sm-40 mt-lg-48 mt-xxxl-64">
				<div class="<?php echo esc_attr( $text_column_class ); ?>">
					<div class="section-seo__text p-m c-body pt-lg-56 w-100">
						<?php if ( $textdesc ) : ?>
							<?php echo dwaplusjeden_kses_basic_content( $textdesc ); ?>
						<?php endif; ?>
						<?php if ( $textheading ) : ?>
						<h3>
							<?php echo dwaplusjeden_kses_basic_content( $textheading, true ); ?>
						</h3>
						<?php endif; ?>
						<?php if ( $text ) : ?>
						<?php echo dwaplusjeden_kses_basic_content( $text ); ?>
						<?php endif; ?>
					</div>
				</div>

				<?php if ( $image ) : ?>
					<div class="<?php echo esc_attr( $image_column_class ); ?>">
						<div class="section-seo__image w-100">
							<?php dwaplusjeden_image( $image, 'full', '', wp_strip_all_tags( $heading ) ); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
