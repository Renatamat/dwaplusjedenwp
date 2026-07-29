<?php
/**
 * Reusable industry cards section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );
$prefix  = ! empty( $args['field_prefix'] ) ? $args['field_prefix'] : 'global_brand';

if ( $has_acf && false === get_field( $prefix . '_enabled' ) ) {
	return;
}

$heading        = $has_acf ? get_field( $prefix . '_heading' ) : '';
$text           = $has_acf ? get_field( $prefix . '_text' ) : '';
$parent_page_id = 2259;

if ( has_filter( 'wpml_object_id' ) ) {
	$parent_page_id = apply_filters( 'wpml_object_id', $parent_page_id, 'page', true );
}

$pages = get_pages(
	array(
		'child_of'    => $parent_page_id,
		'parent'      => $parent_page_id,
		'post_type'   => 'page',
		'post_status' => 'publish',
		'sort_column' => 'menu_order,post_title',
		'sort_order'  => 'ASC',
	)
);

if ( ! $heading && ! $text && ! $pages ) {
	return;
}

$heading_id = $prefix . '-heading';
?>

<section class="global-brand pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96"<?php echo $heading ? ' aria-labelledby="' . esc_attr( $heading_id ) . '"' : ''; ?>>
	<div class="container">
		<?php if ( $heading || $text ) : ?>
			<div class="row">
				<div class="col-12 col-lg-10 col-xl-8 mx-auto">
					<div class="d-flex flex-column gap-8">
						<?php if ( $heading ) : ?>
							<h2 id="<?php echo esc_attr( $heading_id ); ?>" class="h6 fw-bolder c-body text-center"><?php echo wp_kses_post( $heading ); ?></h2>
						<?php endif; ?>
						<?php if ( $text ) : ?>
							<p class="p-m text-center"><?php echo wp_kses_post( $text ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $pages ) : ?>
			<div class="row mt-64 r-gap-24 a-card-sequence" data-animate-start="top 90%">
				<?php foreach ( $pages as $page ) : ?>
					<?php
					$page_id    = $page instanceof WP_Post ? $page->ID : (int) $page;
					$card_title = $has_acf ? get_field( 'page_card_title', $page_id ) : '';
					$card_title = $card_title ? $card_title : get_the_title( $page_id );
					$link       = array(
						'url'      => get_permalink( $page_id ),
						'title'    => $card_title,
						'target'   => '',
					);
					$arrow_link = $link;

					$arrow_link['nofollow'] = '1';

					if ( ! $card_title || empty( $link['url'] ) ) {
						continue;
					}
					?>
					<div class="col-sm-6 col-lg-4 col-xxxl-3 a-card-item">
						<div class="service-card service-card-wrapper">
							<div class="service-card-content">
								<h3 class="p-m fw-bolder c-body">
									<a<?php dwaplusjeden_link_attrs( $link ); ?>><?php echo esc_html( $card_title ); ?></a>
								</h3>
							</div>
							<a<?php dwaplusjeden_link_attrs( $arrow_link ); ?> class="c-btn c-btn-fill c-btn-icon c-btn-icon-m rounded-pill overflow-hidden align-self-end mt-auto" aria-label="<?php echo esc_attr( $card_title ); ?>">
								<svg class="i-sprite icon-16 c-white" aria-hidden="true" focusable="false">
									<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#arrow_right"></use>
								</svg>
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
