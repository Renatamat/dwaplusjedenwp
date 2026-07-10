<?php
/**
 * Global trust section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );

if ( $has_acf && false === get_field( 'trust_section_enabled', 'option' ) ) {
	return;
}

$heading = $has_acf ? get_field( 'trust_section_heading', 'option' ) : '';
$text    = $has_acf ? get_field( 'trust_section_text', 'option' ) : '';
?>

<section class="od-trust pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="trust-section-heading"' : ''; ?>>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-column gap-8 align-items-center">
                    <?php if ( $heading ) : ?>
                        <h2 id="trust-section-heading" class="h5 fw-bolder c-body"><?php echo wp_kses_post( $heading ); ?></h2>
                    <?php endif; ?>
                    <?php if ( $text ) : ?>
                        <p class="p-m"><?php echo wp_kses_post( $text ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row mt-48">
            <div class="col-12">
                <?php echo do_shortcode('[trustindex no-registration=google]'); ?>
                
            </div>
        </div>
    </div>
</section>
