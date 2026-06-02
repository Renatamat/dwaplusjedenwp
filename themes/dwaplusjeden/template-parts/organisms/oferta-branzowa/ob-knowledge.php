<?php
/**
 * Offer industry knowledge.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || ! get_field( 'ob_knowledge_enabled' ) ) {
	return;
}

$heading = get_field( 'ob_knowledge_heading' );
$items   = get_field( 'ob_knowledge_items' );

if ( ! $items ) {
	return;
}
?>

<section class="od-knowledge pt-56 pb-56 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="ob-knowledge-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php if ( $heading ) : ?>
					<h2 id="ob-knowledge-heading" class="h5 fw-bolder c-body text-center w-100"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
			</div>
		</div>
		<div class="row mt-32 mt-sm-40 mt-lg-48 mt-xxxl-64">
			<div class="offset-lg-1 col-lg-10">
				<div class="d-flex flex-column gap-32 gap-sm-40 gap-lg-48">
					<?php foreach ( $items as $item ) : ?>
						<div class="d-flex flex-column">
							<?php if ( $item['title'] ) : ?>
								<h3 class="p-m fw-bolder c-body"><?php echo esc_html( $item['title'] ); ?></h3>
							<?php endif; ?>
							<?php if ( $item['text'] ) : ?>
								<p class="p-m c-body"><?php echo esc_html( $item['text'] ); ?></p>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
