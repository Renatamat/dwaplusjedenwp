<?php
/**
 * Offer industry FAQ.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || ! get_field( 'ob_faq_enabled' ) ) {
	return;
}

$heading      = get_field( 'ob_faq_heading' );
$items        = get_field( 'ob_faq_items' );
$accordion_id = 'obFaqAccordion-' . get_the_ID();

if ( ! $items ) {
	return;
}
?>

<section class="od-faq pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="ob-faq-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php if ( $heading ) : ?>
					<h2 id="ob-faq-heading" class="h6 c-body text-center w-100"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
			</div>
		</div>
		<div class="row mt-32 mt-sm-40 mt-lg-48 mt-xxxl-64">
			<div class="offset-lg-1 col-lg-10">
				<div class="accordion od-faq-accordion" id="<?php echo esc_attr( $accordion_id ); ?>">
					<?php foreach ( $items as $index => $item ) : ?>
						<?php
						$heading_id  = $accordion_id . '-heading-' . $index;
						$collapse_id = $accordion_id . '-collapse-' . $index;
						?>
						<div class="accordion-item od-faq-accordion-item">
							<h3 class="accordion-header w-100" id="<?php echo esc_attr( $heading_id ); ?>">
								<button class="accordion-button od-faq-accordion-header collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( $collapse_id ); ?>" aria-expanded="false" aria-controls="<?php echo esc_attr( $collapse_id ); ?>">
									<span class="p-m fw-bolder c-body"><?php echo esc_html( $item['question'] ); ?></span>
									<svg class="i-sprite icon-20" aria-hidden="true" focusable="false">
										<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-20.svg' ) ); ?>#chevron_down"></use>
									</svg>
								</button>
							</h3>
							<div id="<?php echo esc_attr( $collapse_id ); ?>" class="accordion-collapse collapse" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>" data-bs-parent="#<?php echo esc_attr( $accordion_id ); ?>">
								<div class="accordion-body od-faq-accordion-content">
									<p class="p-m fw-body c-body"><?php echo esc_html( $item['answer'] ); ?></p>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
