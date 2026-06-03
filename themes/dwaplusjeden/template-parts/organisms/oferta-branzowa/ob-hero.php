<?php
/**
 * Offer industry hero.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || ! get_field( 'ob_hero_enabled' ) ) {
	return;
}

$heading = get_field( 'ob_hero_heading' );
$text    = get_field( 'ob_hero_text' );
$link    = dwaplusjeden_get_acf_link( 'ob_hero_link', get_the_ID() );
?>

<section class="od-hero pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="ob-hero-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="d-flex flex-column gap-8">
					<?php if ( $heading ) : ?>
						<h1 id="ob-hero-heading" class="h5 fw-bolder c-body text-center"><?php echo esc_html( $heading ); ?></h1>
					<?php endif; ?>
					<?php if ( $text ) : ?>
						<p class="p-m c-black text-center"><?php echo wp_kses_post( nl2br( esc_html( $text ) ) ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<?php if ( ! empty( $link['url'] ) ) : ?>
			<div class="row mt-32 mt-sm-40 mt-lg-48 mt-xxxl-64">
				<div class="col-md-6 col-lg-4 col-xxxl-3 mx-auto">
					<a<?php dwaplusjeden_link_attrs( $link ); ?> class="c-btn c-btn-s c-btn-fill w-100">
						<span><?php echo esc_html( $link['title'] ?: $link['url'] ); ?></span>
					</a>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
