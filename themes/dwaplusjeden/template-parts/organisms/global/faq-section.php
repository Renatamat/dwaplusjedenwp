<?php
/**
 * Reusable FAQ section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );
$prefix  = ! empty( $args['field_prefix'] ) ? $args['field_prefix'] : 'faq';

if ( $has_acf && false === get_field( $prefix . '_enabled' ) ) {
	return;
}

$heading      = $has_acf ? get_field( $prefix . '_heading' ) : '';
$items        = $has_acf ? get_field( $prefix . '_items' ) : array();
$accordion_id = $prefix . '-accordion-' . get_the_ID();
$schema_items = array();

if ( $items ) {
	foreach ( $items as $item ) {
		$question = ! empty( $item['question'] ) ? wp_strip_all_tags( $item['question'] ) : '';
		$answer   = ! empty( $item['answer'] ) ? wp_strip_all_tags( $item['answer'] ) : '';

		if ( $question && $answer ) {
			$schema_items[] = array(
				'@type'          => 'Question',
				'name'           => $question,
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => $answer,
				),
			);
		}
	}
}
?>

<section class="od-faq pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="' . esc_attr( $prefix ) . '-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php if ( $heading ) : ?>
					<h2 id="<?php echo esc_attr( $prefix ); ?>-heading" class="h6 c-body text-center w-100"><?php echo wp_kses_post( $heading ); ?></h2>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( $items ) : ?>
			<div class="row mt-32 mt-sm-40 mt-lg-48 mt-xxxl-64">
				<div class="offset-lg-1 col-lg-10">
					<div class="accordion od-faq-accordion" id="<?php echo esc_attr( $accordion_id ); ?>">
						<?php foreach ( $items as $index => $item ) : ?>
							<?php
							$question    = isset( $item['question'] ) ? $item['question'] : '';
							$answer      = isset( $item['answer'] ) ? $item['answer'] : '';
							$heading_id  = $accordion_id . '-heading-' . $index;
							$collapse_id = $accordion_id . '-collapse-' . $index;
							?>
							<?php if ( $question || $answer ) : ?>
								<div class="accordion-item od-faq-accordion-item">
									<h3 class="accordion-header w-100" id="<?php echo esc_attr( $heading_id ); ?>">
										<button class="accordion-button od-faq-accordion-header collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( $collapse_id ); ?>" aria-expanded="false" aria-controls="<?php echo esc_attr( $collapse_id ); ?>">
											<?php if ( $question ) : ?>
												<span class="p-m fw-bolder c-body"><?php echo wp_kses_post( $question ); ?></span>
											<?php endif; ?>
											<svg class="i-sprite icon-20" aria-hidden="true" focusable="false">
												<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-20.svg' ) ); ?>#chevron_down"></use>
											</svg>
										</button>
									</h3>
									<div id="<?php echo esc_attr( $collapse_id ); ?>" class="accordion-collapse collapse" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>" data-bs-parent="#<?php echo esc_attr( $accordion_id ); ?>">
										<div class="accordion-body od-faq-accordion-content">
											<?php if ( $answer ) : ?>
												<p class="p-m fw-body c-body"><?php echo wp_kses_post( $answer ); ?></p>
											<?php endif; ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php if ( $schema_items ) : ?>
	<script type="application/ld+json">
		<?php
		echo wp_json_encode(
			array(
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => $schema_items,
			),
			JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
		);
		?>
	</script>
<?php endif; ?>
