<?php
/**
 * Reusable services cards section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) ) {
	return;
}

$prefix = ! empty( $args['field_prefix'] ) ? $args['field_prefix'] : 'global_services';

if ( false === get_field( $prefix . '_enabled' ) ) {
	return;
}

$heading    = get_field( $prefix . '_heading' );
$text       = get_field( $prefix . '_text' );
$parent_page_id = ! empty( $args['parent_page_id'] ) ? (int) $args['parent_page_id'] : 0;
$services   = array();
$heading_id = $prefix . '-heading';

if ( $parent_page_id ) {
	if ( has_filter( 'wpml_object_id' ) ) {
		$parent_page_id = apply_filters( 'wpml_object_id', $parent_page_id, 'page', true );
	}

	$service_pages = get_pages(
		array(
			'child_of'    => $parent_page_id,
			'parent'      => $parent_page_id,
			'post_type'   => 'page',
			'post_status' => 'publish',
			'sort_column' => 'menu_order,post_title',
			'sort_order'  => 'ASC',
		)
	);

	foreach ( $service_pages as $service_page ) {
		$page_id       = $service_page instanceof WP_Post ? $service_page->ID : (int) $service_page;
		$service_title = get_field( 'page_card_title', $page_id );
		$service_text  = get_field( 'page_card_text', $page_id );

		$services[] = array(
			'icon'         => get_field( 'page_card_icon', $page_id ),
			'title'        => $service_title ? $service_title : get_the_title( $page_id ),
			'text'         => $service_text,
			'related_page' => $page_id,
			'link'         => array(),
			'button_label' => __( 'Sprawdź', 'dwaplusjeden' ),
		);
	}
} else {
	$services = get_field( $prefix . '_items' );
}
?>

<section class="hp-services pt-56 pb-56 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="' . esc_attr( $heading_id ) . '"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-10 col-xl-8 mx-auto">
				<div class="d-flex flex-column align-items-center gap-20">
					<div class="d-flex flex-column gap-8 align-items-center">
						<?php if ( $heading ) : ?>
							<h2 id="<?php echo esc_attr( $heading_id ); ?>" class="h6 fw-bolder c-body text-center"><?php echo esc_html( $heading ); ?></h2>
						<?php endif; ?>
						<?php if ( $text ) : ?>
							<p class="p-m c-black text-center"><?php echo $text; ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<?php if ( $services ) : ?>
			<div class="row pt-48 pt-lg-64">
				<div class="col-12 offset-xxxl-1 col-xxxl-10">
					<div class="row r-gap-24 a-card-sequence" data-animate-start="top 90%">
						<?php foreach ( $services as $service ) : ?>
							<?php
							$related       = ! empty( $service['related_page'] ) ? $service['related_page'] : null;
							$manual_link   = ! empty( $service['link'] ) ? $service['link'] : array();
							$link          = dwaplusjeden_get_relation_or_link( $related, $manual_link );
							$service_title = ! empty( $service['title'] ) ? $service['title'] : '';
							$service_text  = ! empty( $service['text'] ) ? $service['text'] : '';
							$button_label  = ! empty( $service['button_label'] ) ? $service['button_label'] : __( 'Sprawdź', 'dwaplusjeden' );
							$nofollow_link = $link;

							if ( $nofollow_link ) {
								$nofollow_link['nofollow'] = '1';
							}
							?>
							<div class="col-sm-6 col-lg-4 a-card-item">
								<div class="service-card">
									<div class="service-card-wrapper">
										<?php echo $link ? '<a' : '<div'; ?><?php $link ? dwaplusjeden_link_attrs( $nofollow_link ) : null; ?> class="service-card-img"<?php echo $link && $service_title ? ' aria-label="' . esc_attr( $service_title ) . '"' : ''; ?>>
											<?php dwaplusjeden_image( ! empty( $service['icon'] ) ? $service['icon'] : 0, 'thumbnail', 'service1.svg', $service_title ); ?>
										<?php echo $link ? '</a>' : '</div>'; ?>
										<div class="d-flex flex-column gap-20">
											<div class="d-flex flex-column gap-8 service-card-content">
												<?php if ( $service_title ) : ?>
													<h3 class="p-m fw-bolder c-body">
														<?php if ( $link ) : ?>
															<a<?php dwaplusjeden_link_attrs( $link ); ?>><?php echo esc_html( $service_title ); ?></a>
														<?php else : ?>
															<?php echo esc_html( $service_title ); ?>
														<?php endif; ?>
													</h3>
												<?php endif; ?>
												<?php if ( $service_text ) : ?>
													<p class="p-s"><?php echo wp_kses_post( $service_text ); ?></p>
												<?php endif; ?>
											</div>
											<?php echo $link ? '<a' : '<div'; ?><?php $link ? dwaplusjeden_link_attrs( $nofollow_link ) : null; ?> class="c-btn c-btn-s c-btn-text w-100 justify-content-between service-card-button">
												<span class="p-0"><?php echo esc_html( $button_label ); ?></span>
												<svg class="i-sprite icon-16" aria-hidden="true" focusable="false">
													<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#arrow_right_2"></use>
												</svg>
											<?php echo $link ? '</a>' : '</div>'; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
