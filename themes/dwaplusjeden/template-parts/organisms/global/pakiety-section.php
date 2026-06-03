<?php
/**
 * Reusable pricing packages section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );
$prefix  = ! empty( $args['field_prefix'] ) ? $args['field_prefix'] : 'packages';

if ( $has_acf && false === get_field( $prefix . '_enabled' ) ) {
	return;
}

$heading  = $has_acf ? get_field( $prefix . '_heading' ) : '';
$packages = $has_acf ? get_field( $prefix . '_packages' ) : array();

if ( ! $heading && ! $packages ) {
	return;
}

$active_index = 0;
?>

<section class="pakiety pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="' . esc_attr( $prefix ) . '-heading"' : ''; ?>>
	<div class="container">
		<?php if ( $heading ) : ?>
			<div class="row">
				<div class="col-12">
					<h2 id="<?php echo esc_attr( $prefix ); ?>-heading" class="h6 fw-bolder c-body w-100 text-center"><?php echo wp_kses_post( $heading ); ?></h2>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( $packages ) : ?>
		<div class="container-fluid">
			<div class="row mt-24">
				<div class="col-auto mx-auto">
					<div class="pakiety-bar" role="tablist">
						<?php foreach ( $packages as $index => $package ) : ?>
							<?php
							$package_id = $package instanceof WP_Post ? $package->ID : (int) $package;

							if ( ! $package_id ) {
								continue;
							}

							$package_label = get_the_title( $package_id );
							$package_slug  = sanitize_title( $package_label );

							if ( ! $package_label || ! $package_slug ) {
								continue;
							}

							$is_active = $index === $active_index;
							?>
							<div class="pakiety-bar-item<?php echo $is_active ? ' --active' : ''; ?>" data-option="<?php echo esc_attr( $package_slug ); ?>" aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>">
								<span class="p-m fw-bolder"><?php echo esc_html( $package_label ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row mt-64">
				<div class="col-12">
					<?php foreach ( $packages as $index => $package ) : ?>
						<?php
						$package_id = $package instanceof WP_Post ? $package->ID : (int) $package;

						if ( ! $package_id ) {
							continue;
						}

						$package_label = get_the_title( $package_id );
						$package_slug  = sanitize_title( $package_label );
						$options       = get_field( 'pricing_package_options', $package_id ) ?: array();
						$features      = get_field( 'pricing_package_features', $package_id ) ?: array();
						$columns       = (int) get_field( 'pricing_package_columns', $package_id );
						$columns       = $columns ? $columns : 4;
						$columns       = in_array( $columns, array( 2, 3, 4 ), true ) ? $columns : 4;

						if ( ! $package_slug || ! $options ) {
							continue;
						}
						?>
						<div class="pakiety-content grid-<?php echo esc_attr( (string) $columns ); ?>" data-option="<?php echo esc_attr( $package_slug ); ?>"<?php echo $index === $active_index ? '' : ' hidden'; ?>>
							<?php foreach ( $options as $option_index => $option ) : ?>
								<?php
								$title          = ! empty( $option['title'] ) ? $option['title'] : '';
								$price          = ! empty( $option['price'] ) ? $option['price'] : '';
								$price_suffix   = ! empty( $option['price_suffix'] ) ? $option['price_suffix'] : '';
								$note           = ! empty( $option['note'] ) ? $option['note'] : '';
								$description    = ! empty( $option['description'] ) ? $option['description'] : '';
								$is_highlighted = ! empty( $option['highlighted'] );
								$highlight_text = ! empty( $option['highlight_text'] ) ? $option['highlight_text'] : '';
								$button         = ! empty( $option['button'] ) ? $option['button'] : array();
								$select_label   = ! empty( $option['select_label'] ) ? $option['select_label'] : '';
								$select_options = ! empty( $option['select_options'] ) ? $option['select_options'] : array();
								$active_features = ! empty( $option['active_features'] ) && is_array( $option['active_features'] ) ? $option['active_features'] : array();

								if ( ! $title && ! $price && ! $description && ! $features ) {
									continue;
								}
								?>
								<div class="pakiety-content-item<?php echo $is_highlighted ? ' --popular' : ''; ?>">
									<?php if ( $is_highlighted && $highlight_text ) : ?>
										<div class="pakiet-content-item-popular-text">
											<span class="p-s fw-bolder c-white"><?php echo esc_html( $highlight_text ); ?></span>
										</div>
									<?php endif; ?>

									<div class="pakiety-content-item-wrapper">
										<div class="pakiety-content-item-content">
											<div class="d-flex flex-column">
												<?php if ( $title ) : ?>
													<span class="p-l fw-bolder c-body"><?php echo esc_html( $title ); ?></span>
												<?php endif; ?>
												<?php if ( $price || $price_suffix ) : ?>
													<div class="d-flex gap-8 align-items-end">
														<?php if ( $price ) : ?>
															<span class="p-l fw-bolder"><?php echo esc_html( $price ); ?></span>
														<?php endif; ?>
														<?php if ( $price_suffix ) : ?>
															<span class="p-s"><?php echo esc_html( $price_suffix ); ?></span>
														<?php endif; ?>
													</div>
												<?php endif; ?>
												<?php if ( $note || $description ) : ?>
													<div class="d-flex flex-column gap-8">
														<?php if ( $note ) : ?>
															<span class="p-xs fw-bolder"><?php echo esc_html( $note ); ?></span>
														<?php endif; ?>
														<?php if ( $description ) : ?>
															<p class="p-xs"><?php echo wp_kses_post( $description ); ?></p>
														<?php endif; ?>
													</div>
												<?php endif; ?>
											</div>

											<?php if ( $select_label && $select_options ) : ?>
												<div class="d-flex flex-column">
													<span class="p-xs"><?php echo esc_html( $select_label ); ?></span>
													<div class="InputWrap InputWrap-l">
														<div class="position-relative">
															<span class="wpcf7">
																<select name="<?php echo esc_attr( $prefix . '_' . $package_slug . '_' . $option_index . '_count' ); ?>">
																	<?php foreach ( $select_options as $select_option ) : ?>
																		<?php
																		$select_value = ! empty( $select_option['value'] ) ? $select_option['value'] : '';
																		$select_text  = ! empty( $select_option['label'] ) ? $select_option['label'] : $select_value;

																		if ( '' === $select_value && '' === $select_text ) {
																			continue;
																		}
																		?>
																		<option value="<?php echo esc_attr( $select_value ); ?>"<?php selected( ! empty( $select_option['selected'] ) ); ?>><?php echo esc_html( $select_text ); ?></option>
																	<?php endforeach; ?>
																</select>
															</span>
														</div>
														<span class="InputPlaceholder-hint"></span>
													</div>
												</div>
											<?php endif; ?>

											<?php if ( ! empty( $button['url'] ) ) : ?>
												<a<?php dwaplusjeden_link_attrs( $button ); ?> class="c-btn c-btn-s c-btn-outline w-100">
													<span><?php echo esc_html( $button['title'] ?: $button['url'] ); ?></span>
												</a>
											<?php endif; ?>
										</div>

										<?php if ( $features ) : ?>
											<div class="pakiety-content-item-separator"></div>
											<div class="d-flex flex-column gap-16 pakiety-content-item-points">
												<?php foreach ( $features as $feature_index => $feature ) : ?>
													<?php
													$feature_text = ! empty( $feature['text'] ) ? $feature['text'] : '';
													$feature_key  = dwaplusjeden_get_pricing_feature_key( $feature, $feature_index );

													if ( ! $feature_text ) {
														continue;
													}
													?>
													<div class="d-flex gap-8<?php echo in_array( $feature_key, $active_features, true ) ? '' : ' --disabled'; ?>">
														<div class="pakiety-content-item-points-icon">
															<svg class="i-sprite icon-16" aria-hidden="true" focusable="false">
																<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#check"></use>
															</svg>
														</div>
														<span class="p-s"><?php echo wp_kses_post( $feature_text ); ?></span>
													</div>
												<?php endforeach; ?>
											</div>
										<?php endif; ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</section>
