<?php
/**
 * Shared process section.
 *
 * @package dwaplusjeden
 *
 * @var array $args Section configuration.
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) ) {
	return;
}

$prefix     = $args['prefix'] ?? '';
$heading_id = $args['heading_id'] ?? $prefix . '-heading';

if ( ! $prefix || ! get_field( $prefix . '_enabled' ) ) {
	return;
}

$heading = get_field( $prefix . '_heading' );
$text    = get_field( $prefix . '_text' );
$items   = get_field( $prefix . '_items' );
?>

<section class="od-proces pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="' . esc_attr( $heading_id ) . '"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="d-flex flex-column align-items-center gap-8">
					<?php if ( $heading ) : ?>
						<h2 id="<?php echo esc_attr( $heading_id ); ?>" class="h5 fw-bolder c-body text-center"><?php echo esc_html( $heading ); ?></h2>
					<?php endif; ?>
					<?php if ( $text ) : ?>
						<p class="p-m text-center"><?php echo esc_html( $text ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<?php if ( $items ) : ?>
			<div class="row mt-48 mt-xxxl-64">
				<div class="col-12">
					<div class="od-proces-container a-process-sequence">
						<?php foreach ( $items as $index => $item ) : ?>
							<div class="od-proces-item a-process-item">
								<div class="od-proces-item-number a-process-number">
									<span class="h6 fw-bolder c-body"><?php echo esc_html( $index + 1 ); ?></span>
								</div>
								<div class="d-flex flex-column gap-8 a-process-copy">
									<?php if ( ! empty( $item['title'] ) ) : ?>
										<span class="p-m fw-bolder c-body text-center"><?php echo esc_html( $item['title'] ); ?></span>
									<?php endif; ?>
									<?php if ( ! empty( $item['text'] ) ) : ?>
										<p class="p-s text-center"><?php echo esc_html( $item['text'] ); ?></p>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
