<?php
/**
 * Global help CTA section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );
$field_name = ! empty( $args['field_name'] ) ? $args['field_name'] : 'help_cta';
$post_id    = array_key_exists( 'post_id', $args ) ? $args['post_id'] : 'option';
$section_id = sanitize_html_class( str_replace( '_', '-', $field_name ) );

$cta = $has_acf ? get_field( $field_name, $post_id ) : array();
$cta = is_array( $cta ) ? $cta : array();

$heading        = isset( $cta['heading'] ) ? $cta['heading'] : '';
$text           = isset( $cta['text'] ) ? $cta['text'] : '';
$primary_link   = isset( $cta['primary_link'] ) && is_array( $cta['primary_link'] ) ? $cta['primary_link'] : array();
$secondary_link = isset( $cta['secondary_link'] ) && is_array( $cta['secondary_link'] ) ? $cta['secondary_link'] : array();
$heading = is_scalar( $heading ) ? (string) $heading : '';
$text    = is_scalar( $text ) ? (string) $text : '';

if ( ! $heading && ! $text && empty( $primary_link['url'] ) && empty( $secondary_link['url'] ) ) {
	return;
}
?>

<section class="about-cta bg-white pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96"<?php echo $heading ? ' aria-labelledby="' . esc_attr( $section_id ) . '-heading"' : ''; ?>>
	<div class="container">
		<?php if ( $heading || $text ) : ?>
			<div class="row">
				<div class="col-12">
					<div class="d-flex flex-column gap-24 justify-content-center">
						<?php if ( $heading ) : ?>
							<h2 id="<?php echo esc_attr( $section_id ); ?>-heading" class="h5 fw-bolder c-body text-center"><?php echo wp_kses_post( $heading ); ?></h2>
						<?php endif; ?>
						<?php if ( $text ) : ?>
							<p class="p-l fw-bolder c-body text-center"><?php echo wp_kses_post( $text ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $primary_link['url'] ) || ! empty( $secondary_link['url'] ) ) : ?>
			<div class="row mt-32">
				<?php if ( ! empty( $primary_link['url'] ) && empty( $secondary_link['url'] ) ) : ?>
					<div class="col-12">
						<div class="d-flex justify-content-center w-100">
							<a<?php dwaplusjeden_link_attrs( $primary_link ); ?> class="c-btn c-btn-s c-btn-fill">
								<span><?php echo esc_html( $primary_link['title'] ?: $primary_link['url'] ); ?></span>
							</a>
						</div>
					</div>
				<?php elseif ( empty( $primary_link['url'] ) && ! empty( $secondary_link['url'] ) ) : ?>
					<div class="col-12">
						<div class="d-flex justify-content-center w-100">
							<a<?php dwaplusjeden_link_attrs( $secondary_link ); ?> class="c-btn c-btn-s c-btn-outline">
								<span><?php echo esc_html( $secondary_link['title'] ?: $secondary_link['url'] ); ?></span>
							</a>
						</div>
					</div>
				<?php else : ?>
					<div class="col-sm-10 col-md-8 col-xl-6 col-xxl-5 mx-auto">
						<div class="d-flex flex-column flex-lg-row gap-16 gap-lg-24">
							<a<?php dwaplusjeden_link_attrs( $primary_link ); ?> class="c-btn c-btn-s c-btn-fill w-100">
								<span><?php echo esc_html( $primary_link['title'] ?: $primary_link['url'] ); ?></span>
							</a>

							<a<?php dwaplusjeden_link_attrs( $secondary_link ); ?> class="c-btn c-btn-s c-btn-outline w-100">
								<span><?php echo esc_html( $secondary_link['title'] ?: $secondary_link['url'] ); ?></span>
							</a>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
