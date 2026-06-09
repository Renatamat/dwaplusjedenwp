<?php
/**
 * Partner program requirements section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || false === get_field( 'pp_requirements_enabled' ) ) {
	return;
}

$columns = array(
	array(
		'heading' => get_field( 'pp_requirements_scope_heading' ),
		'items'   => get_field( 'pp_requirements_scope_items' ),
	),
	array(
		'groups' => array(
			array(
				'heading' => get_field( 'pp_requirements_required_heading' ),
				'items'   => get_field( 'pp_requirements_required_items' ),
			),
			array(
				'heading' => get_field( 'pp_requirements_nice_heading' ),
				'items'   => get_field( 'pp_requirements_nice_items' ),
			),
		),
	),
);

$has_content = false;
foreach ( $columns as $column ) {
	if ( ! empty( $column['heading'] ) || ! empty( $column['items'] ) || ! empty( $column['groups'] ) ) {
		$has_content = true;
		break;
	}
}

if ( ! $has_content ) {
	return;
}

$render_items = static function ( $items ) {
	if ( ! $items ) {
		return;
	}
	?>
	<div class="d-flex flex-column gap-16">
		<?php foreach ( $items as $item ) : ?>
			<?php
			$text = ! empty( $item['text'] ) ? $item['text'] : '';

			if ( ! $text ) {
				continue;
			}
			?>
			<div class="pp-requirements-item a-slide-left" data-animate-delay="0.10">
				<div class="pp-requirements-item-icon">
					<svg class="i-sprite icon-16" aria-hidden="true" focusable="false">
						<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#check"></use>
					</svg>
				</div>
				<span class="p-s c-body"><?php echo wp_kses_post( $text ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
};
?>

<section class="pp-requirements pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="pp-requirements-wrapper">
					<?php if ( ! empty( $columns[0]['heading'] ) || ! empty( $columns[0]['items'] ) ) : ?>
						<div class="d-flex flex-column gap-24">
							<div class="d-flex flex-column gap-16">
								<?php if ( ! empty( $columns[0]['heading'] ) ) : ?>
									<span class="p-l fw-bolder c-body"><?php echo wp_kses_post( $columns[0]['heading'] ); ?></span>
								<?php endif; ?>
								<?php $render_items( $columns[0]['items'] ); ?>
							</div>
						</div>
					<?php endif; ?>

					<div class="d-flex flex-column gap-24">
						<?php foreach ( $columns[1]['groups'] as $group ) : ?>
							<?php if ( empty( $group['heading'] ) && empty( $group['items'] ) ) : ?>
								<?php continue; ?>
							<?php endif; ?>
							<div class="d-flex flex-column gap-16">
								<?php if ( ! empty( $group['heading'] ) ) : ?>
									<span class="p-l fw-bolder c-body"><?php echo wp_kses_post( $group['heading'] ); ?></span>
								<?php endif; ?>
								<?php $render_items( $group['items'] ); ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
