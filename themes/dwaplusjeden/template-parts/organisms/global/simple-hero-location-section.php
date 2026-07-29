<?php
/**
 * Reusable simple hero section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );
$prefix  = ! empty( $args['field_prefix'] ) ? $args['field_prefix'] : 'hero';

if ( $has_acf && false === get_field( $prefix . '_enabled' ) ) {
	return;
}

$heading = $has_acf ? get_field( $prefix . '_heading' ) : '';
$text    = $has_acf ? get_field( $prefix . '_text' ) : '';
$link    = $has_acf ? dwaplusjeden_get_acf_link( $prefix . '_link', get_the_ID() ) : array();
$second_link = $has_acf ? dwaplusjeden_get_acf_link( $prefix . '_secondary_link', get_the_ID() ) : array();

if ( ! $heading && ! $text && empty( $link['url'] ) && empty( $second_link['url'] ) ) {
	return;
}
?>

<section class="od-hero pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="' . esc_attr( $prefix ) . '-heading"' : ''; ?>>
	<div class="container">
		<?php if ( $heading || $text ) : ?>
			<div class="row">
				<div class="col-12">
					<div class="d-flex flex-column gap-8">
						<?php if ( $heading ) : ?>
							<h1 id="<?php echo esc_attr( $prefix ); ?>-heading" class="h4 fw-bolder c-body text-center"><?php echo wp_kses_post( $heading ); ?></h1>
						<?php endif; ?>
						<?php if ( $text ) : ?>
							<p class="p-m c-black text-center"><?php echo wp_kses_post( $text ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $link['url'] ) || ! empty( $second_link['url'] ) ) : ?>
			<div class="row mt-32 mt-sm-40 mt-lg-48 mt-xxxl-64">
				<div class="col-md-10 col-lg-6 col-xxxl-4 mx-auto">
					<div class="d-flex flex-column flex-sm-row gap-16 w-100">
						<?php if ( ! empty( $link['url'] ) ) : ?>
							<a<?php dwaplusjeden_link_attrs( $link ); ?> class="c-btn c-btn-s c-btn-outline w-100">
								<span><?php echo esc_html( $link['title'] ?: $link['url'] ); ?></span>
							</a>
						<?php endif; ?>
						<?php if ( ! empty( $second_link['url'] ) ) : ?>
							<a<?php dwaplusjeden_link_attrs( $second_link ); ?> class="c-btn c-btn-s c-btn-fill w-100">
								<span><?php echo esc_html( $second_link['title'] ?: $second_link['url'] ); ?></span>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
