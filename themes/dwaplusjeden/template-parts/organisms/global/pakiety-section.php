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
$packages = isset( $args['packages'] ) ? $args['packages'] : ( $has_acf ? get_field( $prefix . '_packages' ) : array() );
$show_tabs = ! isset( $args['show_tabs'] ) || $args['show_tabs'];
$section_class = ! empty( $args['section_class'] ) ? sanitize_html_class( $args['section_class'] ) : '';
$link = ! empty( $args['link'] ) ? $args['link'] : array();
$is_service_pricing = 'od-pricing' === $section_class;
$disclaimer = $is_service_pricing && isset( $args['disclaimer'] ) ? trim( (string) $args['disclaimer'] ) : '';

if ( ! $heading && ! $packages ) {
	return;
}

$active_index = 0;
?>

<section class="pakiety<?php echo $section_class ? ' ' . esc_attr( $section_class ) : ''; ?> pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="' . esc_attr( $prefix ) . '-heading"' : ''; ?>>
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
		<?php if ( $show_tabs ) : ?>
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
		<?php endif; ?>

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
								$display_price  = $price;
								$has_select_prices = false;

								if ( $select_label && $select_options ) {
									$default_select_option = null;

									foreach ( $select_options as $select_option ) {
										if ( ! empty( $select_option['price'] ) ) {
											$has_select_prices = true;
										}

										if ( ! empty( $select_option['selected'] ) && ! $default_select_option ) {
											$default_select_option = $select_option;
										}
									}

									if ( ! $default_select_option ) {
										$default_select_option = reset( $select_options );
									}

									if ( ! empty( $default_select_option['price'] ) ) {
										$display_price = $default_select_option['price'];
									}
								}

								if ( ! $title && ! $display_price && ! $has_select_prices && ! $description && ! $features ) {
									continue;
								}
								?>
								<div class="pakiety-content-item<?php echo $is_highlighted ? ' --popular' : ''; ?>" data-pricing-card data-pricing-base-price="<?php echo esc_attr( $price ); ?>">
									<?php if ( $is_highlighted && $highlight_text ) : ?>
										<div class="pakiet-content-item-popular-text">
											<span class="p-s fw-bolder c-white"><?php echo esc_html( $highlight_text ); ?></span>
										</div>
									<?php endif; ?>

									<div class="pakiety-content-item-wrapper">
										<div class="pakiety-content-item-content">
											<div class="d-flex flex-column pakiety-content-item-summary">
												<?php if ( $title ) : ?>
													<span class="p-l fw-bolder pakiety-content-item-title<?php echo $is_service_pricing ? '' : ' c-body'; ?>"><?php echo esc_html( $title ); ?></span>
												<?php endif; ?>
												<?php if ( $display_price || $price_suffix || $has_select_prices ) : ?>
													<div class="d-flex gap-8 align-items-end pakiety-content-item-price">
														<span class="<?php echo $is_service_pricing ? 'p-xl' : 'p-l'; ?> fw-bolder" data-pricing-price><?php echo esc_html( $display_price ); ?></span>
														<?php if ( $price_suffix ) : ?>
															<span class="p-s"><?php echo esc_html( $price_suffix ); ?></span>
														<?php endif; ?>
													</div>
												<?php endif; ?>
												<?php if ( $note || $description ) : ?>
													<div class="d-flex flex-column gap-8 pakiety-content-item-description">
														<?php if ( $note ) : ?>
															<span class="<?php echo $is_service_pricing ? 'p-s' : 'p-xs'; ?> fw-bolder"><?php echo esc_html( $note ); ?></span>
														<?php endif; ?>
														<?php if ( $description ) : ?>
															<p class="<?php echo $is_service_pricing ? 'p-s' : 'p-xs'; ?>"><?php echo wp_kses_post( $description ); ?></p>
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
																<select name="<?php echo esc_attr( $prefix . '_' . $package_slug . '_' . $option_index . '_count' ); ?>" data-pricing-price-select>
																	<?php foreach ( $select_options as $select_option ) : ?>
																		<?php
																		$select_value = ! empty( $select_option['value'] ) ? $select_option['value'] : '';
																		$select_text  = ! empty( $select_option['label'] ) ? $select_option['label'] : $select_value;
																		$select_price = ! empty( $select_option['price'] ) ? $select_option['price'] : '';

																		if ( '' === $select_value && '' === $select_text ) {
																			continue;
																		}
																		?>
																		<option value="<?php echo esc_attr( $select_value ); ?>" data-price="<?php echo esc_attr( $select_price ); ?>"<?php selected( ! empty( $select_option['selected'] ) ); ?>><?php echo esc_html( $select_text ); ?></option>
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
	<?php if ( '' !== $disclaimer ) : ?>
		<div class="container">
			<div class="row mt-24">
				<div class="col-12">
					<div class="od-pricing-disclaimer d-flex align-items-center justify-content-center gap-8">
						<svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
							<path d="M12 13.8808V7.31832M11.9916 15.7558C11.961 15.7563 11.9307 15.7629 11.9026 15.7753C11.8746 15.7876 11.8493 15.8054 11.8282 15.8277C11.8072 15.85 11.7908 15.8763 11.78 15.905C11.7693 15.9337 11.7644 15.9643 11.7657 15.9949C11.7678 16.0564 11.7938 16.1147 11.838 16.1575C11.8822 16.2003 11.9413 16.2244 12.0029 16.2246C12.0335 16.224 12.0637 16.2173 12.0917 16.2049C12.1197 16.1925 12.1449 16.1747 12.1659 16.1524C12.187 16.1301 12.2034 16.1039 12.2141 16.0753C12.2249 16.0466 12.2299 16.0161 12.2288 15.9855C12.2269 15.9253 12.2023 15.8681 12.1598 15.8255C12.1173 15.7828 12.0602 15.7579 12 15.7558H11.9954M22.3125 11.8239C22.3195 14.5775 21.2408 17.2229 19.3104 19.1865C17.38 21.1501 14.7533 22.2737 12 22.3136C10.6553 22.3339 9.31999 22.0869 8.07145 21.5871C6.82291 21.0873 5.68603 20.3446 4.72674 19.402C3.76744 18.4595 3.00482 17.3359 2.48312 16.0963C1.96141 14.8568 1.69099 13.526 1.68754 12.1811C1.67985 9.42706 2.75819 6.78098 4.68871 4.81677C6.61922 2.85256 9.24624 1.7286 12 1.68864C13.345 1.66853 14.6805 1.91565 15.9291 2.41567C17.1778 2.9157 18.3148 3.65867 19.2741 4.60149C20.2334 5.54432 20.9959 6.66823 21.5175 7.90804C22.0391 9.14786 22.3093 10.4789 22.3125 11.8239Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="#E62E2E"/>
						</svg>
						<p class="p-s c-black mb-0"><?php echo nl2br( esc_html( $disclaimer ) ); ?></p>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php if ( ! empty( $link['url'] ) ) : ?>
		<div class="container">
			<div class="row mt-48">
				<div class="col-12 text-center d-flex justify-content-center">
					<a<?php dwaplusjeden_link_attrs( $link ); ?> class="c-btn c-btn-s c-btn-fill">
						<span><?php echo esc_html( $link['title'] ); ?></span>
					</a>
				</div>
			</div>
		</div>
	<?php endif; ?>
</section>
