<?php
/**
 * Offer industry breadcrumb.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}
?>

<div class="container">
	<div class="row">
		<div class="col-12">
			<?php if ( function_exists( 'yoast_breadcrumb' ) ) : ?>
				<?php yoast_breadcrumb( '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Okruszki', 'dwaplusjeden' ) . '">', '</nav>' ); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
