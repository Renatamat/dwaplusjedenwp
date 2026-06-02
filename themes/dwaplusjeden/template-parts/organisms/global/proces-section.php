<?php
/**
 * Reusable process section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );
$prefix  = ! empty( $args['field_prefix'] ) ? $args['field_prefix'] : 'process';

if ( $has_acf && false === get_field( $prefix . '_enabled' ) ) {
	return;
}

$heading = $has_acf ? get_field( $prefix . '_heading' ) : '';
$text    = $has_acf ? get_field( $prefix . '_text' ) : '';
$items   = array(
	array(
		'title' => $has_acf ? get_field( $prefix . '_step_1_title' ) : '',
		'text'  => $has_acf ? get_field( $prefix . '_step_1_text' ) : '',
	),
	array(
		'title' => $has_acf ? get_field( $prefix . '_step_2_title' ) : '',
		'text'  => $has_acf ? get_field( $prefix . '_step_2_text' ) : '',
	),
	array(
		'title' => $has_acf ? get_field( $prefix . '_step_3_title' ) : '',
		'text'  => $has_acf ? get_field( $prefix . '_step_3_text' ) : '',
	),
	array(
		'title' => $has_acf ? get_field( $prefix . '_step_4_title' ) : '',
		'text'  => $has_acf ? get_field( $prefix . '_step_4_text' ) : '',
	),
);
?>

<section class="od-proces pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="' . esc_attr( $prefix ) . '-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="d-flex flex-column align-items-center gap-8">
					<?php if ( $heading ) : ?>
						<h2 id="<?php echo esc_attr( $prefix ); ?>-heading" class="h5 fw-bolder c-body text-center"><?php echo wp_kses_post( $heading ); ?></h2>
					<?php endif; ?>
					<?php if ( $text ) : ?>
						<p class="p-m text-center"><?php echo wp_kses_post( $text ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<?php if ( $items ) : ?>
			<div class="row mt-48 mt-xxxl-64">
				<div class="col-12">
					<div class="od-proces-container a-process-sequence">
						<?php foreach ( $items as $index => $item ) : ?>
							<?php
							$title = isset( $item['title'] ) ? $item['title'] : '';
							$body  = isset( $item['text'] ) ? $item['text'] : '';
							?>
							<div class="od-proces-item a-process-item">
								<div class="od-proces-item-number a-process-number">
									<span class="h6 fw-bolder c-body"><?php echo esc_html( $index + 1 ); ?></span>
								</div>
								<div class="d-flex flex-column gap-8 a-process-copy">
									<?php if ( $title ) : ?>
										<h3 class="p-m fw-bolder c-body text-center"><?php echo wp_kses_post( $title ); ?></h3>
									<?php endif; ?>
									<?php if ( $body ) : ?>
										<p class="p-s text-center"><?php echo wp_kses_post( $body ); ?></p>
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
