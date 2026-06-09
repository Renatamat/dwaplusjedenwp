<?php
/**
 * Contact page header.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || false === get_field( 'contact_header_enabled' ) ) {
	return;
}

$heading = get_field( 'contact_header_heading' );
$text    = get_field( 'contact_header_text' );

if ( ! $heading && ! $text ) {
	return;
}
?>

<section class="pp-title pt-56 pt-sm-64 pt-lg-96 pt-xxxl-132"<?php echo $heading ? ' aria-labelledby="contact-header-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="d-flex flex-column gap-8">
					<?php if ( $heading ) : ?>
						<h1 id="contact-header-heading" class="h5 fw-bolder c-body w-100 text-center"><?php echo wp_kses_post( $heading ); ?></h1>
					<?php endif; ?>
					<?php if ( $text ) : ?>
						<p class="p-m text-center w-100"><?php echo wp_kses_post( $text ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
