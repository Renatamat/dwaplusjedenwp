<?php
/**
 * About page reasons section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );

if ( $has_acf && false === get_field( 'about_info_enabled' ) ) {
	return;
}

$heading = $has_acf ? get_field( 'about_info_heading' ) : '';
$items   = $has_acf ? get_field( 'about_info_items' ) : array();

if ( ! $heading && ! $items ) {
	return;
}
?>

<section class="about-info pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96"<?php echo $heading ? ' aria-labelledby="about-info-heading"' : ''; ?>>
	<div class="container">
		<?php if ( $heading ) : ?>
			<div class="row">
				<div class="col-12">
					<h2 id="about-info-heading" class="h6 fw-bolder c-body text-center w-100"><?php echo wp_kses_post( $heading ); ?></h2>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $items ) : ?>
			<div class="row mt-48">
				<div class="col-lg-8 mx-auto">
					<div class="d-flex flex-column gap-16">
						<?php foreach ( $items as $item ) : ?>
							<?php $text = isset( $item['text'] ) ? $item['text'] : ''; ?>
							<?php if ( $text ) : ?>
								<div class="about-info-item a-fade-in-up">
									<div class="about-info-item-icon">
										<svg class="i-sprite icon-16" aria-hidden="true" focusable="false">
											<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#check"></use>
										</svg>
									</div>
									<span class="p-m c-body"><?php echo wp_kses_post( $text ); ?></span>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
