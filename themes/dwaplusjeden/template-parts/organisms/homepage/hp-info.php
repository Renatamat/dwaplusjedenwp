<?php
/**
 * Homepage info.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) ) {
	return;
}

$prefix = ! empty( $args['field_prefix'] ) ? $args['field_prefix'] : 'homepage_info';

if ( ! get_field( $prefix . '_enabled' ) ) {
	return;
}

$heading = get_field( $prefix . '_heading' );
$text    = get_field( $prefix . '_text' );
$cards   = get_field( $prefix . '_cards' );
$link    = dwaplusjeden_get_acf_link( $prefix . '_link', get_the_ID() );
?>

<section class="hp-info pt-64 pb-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="' . esc_attr( $prefix ) . '-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="d-flex flex-column gap-8 align-items-center">
					<?php if ( $heading ) : ?>
							<h2 id="<?php echo esc_attr( $prefix ); ?>-heading" class="h5 fw-bolder c-body text-center"><?php echo  $heading ; ?></h2>
					<?php endif; ?>
					<?php if ( $text ) : ?>
						<p class="p-m c-black text-center"><?php echo $text ; ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<?php if ( $cards ) : ?>
			<div class="row pt-48 pb-48">
				<div class="col-12 offset-xxxl-1 col-xxxl-10">
					<div class="row r-gap-24 a-card-sequence" data-animate-start="top 90%">
						<?php foreach ( $cards as $card ) : ?>
							<div class="col-sm-6 col-lg-4 a-card-item">
								<div class="hp-info-card">
									<div class="hp-info-card-wrapper">
										<div class="d-flex flex-column gap-16 gap-lg-24">
											<div class="hp-info-card-icon">
												<?php dwaplusjeden_image( $card['icon'], 'full', 'iconinfo1.svg', $card['title'] ); ?>
											</div>
											<div class="d-flex flex-column gap-8">
												<?php if ( $card['title'] ) : ?>
													<h3 class="p-l fw-bolder c-white"><?php echo esc_html( $card['title'] ); ?></h3>
												<?php endif; ?>
												<?php if ( $card['text'] ) : ?>
													<p class="p-s c-white"><?php echo esc_html( $card['text'] ); ?></p>
												<?php endif; ?>
											</div>
										</div>
										<div class="hp-info-card-bottom"></div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $link['url'] ) ) : ?>
			<div class="row">
				<div class="col-12 d-flex justify-content-center w-100">
					<a<?php dwaplusjeden_link_attrs( $link ); ?> class="c-btn c-btn-s c-btn-fill">
						<span><?php echo esc_html( $link['title'] ?: $link['url'] ); ?></span>
					</a>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
