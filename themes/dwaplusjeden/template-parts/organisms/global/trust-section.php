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
                <div
                    class="od-trust-slider swiper"
                    data-swiper
                    data-swiper-options='{"slidesPerView": "auto",  "centeredSlides": true,  "spaceBetween": 16, "breakpoints": {"576": {"spaceBetween": 24}, "1200": {"slidesPerView": 3,  "centeredSlides": false, "freeMode": false, "spaceBetween": 24}}}'
                >
                    <div class="swiper-wrapper a-card-sequence" data-animate-start="top 90%" data-animate-batch-max="4">
                        <div class="od-trust-card swiper-slide a-card-item">
                            <div class="od-trust-card-wrapper">
                                <div class="od-trust-card-stars">
                                    <div class="od-trust-card-star">
                                        <svg class="i-sprite icon-24">
                                            <use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#star_fill"></use>
                                        </svg>
                                    </div>
                                    <div class="od-trust-card-star">
                                        <svg class="i-sprite icon-24">
                                            <use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#star_fill"></use>
                                        </svg>
                                    </div>
                                    <div class="od-trust-card-star">
                                        <svg class="i-sprite icon-24">
                                            <use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#star_fill"></use>
                                        </svg>
                                    </div>
                                    <div class="od-trust-card-star">
                                        <svg class="i-sprite icon-24">
                                            <use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#star_fill"></use>
                                        </svg>
                                    </div>
                                    <div class="od-trust-card-star">
                                        <svg class="i-sprite icon-24">
                                            <use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#star_fill"></use>
                                        </svg>
                                    </div>
                                </div>
                                <p class="p-s fw-bolder">
                                    "Profesjonalna obs&#322;uga, zawsze terminowe rozliczenia. Polecam ka&#380;demu przedsi&#281;biorcy."
                                </p>
                                <div class="d-flex gap-16 align-items-center">
                                    <div class="avatar">
                                        <div class="avatar-wrapper">
                                            <img src="{{person}}" alt="">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="p-s">Jan Kowalski</span>
                                        <span class="p-overline">W&#322;a&#347;ciciel firmy IT</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="od-trust-card swiper-slide a-card-item">
                            <div class="od-trust-card-wrapper">
                                <div class="od-trust-card-stars">
                                    <div class="od-trust-card-star">
                                        <svg class="i-sprite icon-24">
                                            <use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#star_fill"></use>
                                        </svg>
                                    </div>
                                    <div class="od-trust-card-star">
                                        <svg class="i-sprite icon-24">
                                            <use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#star_fill"></use>
                                        </svg>
                                    </div>
                                    <div class="od-trust-card-star">
                                        <svg class="i-sprite icon-24">
                                            <use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#star_fill"></use>
                                        </svg>
                                    </div>
                                    <div class="od-trust-card-star">
                                        <svg class="i-sprite icon-24">
                                            <use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#star_fill"></use>
                                        </svg>
                                    </div>
                                    <div class="od-trust-card-star">
                                        <svg class="i-sprite icon-24">
                                            <use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#star_fill"></use>
                                        </svg>
                                    </div>
                                </div>
                                <p class="p-s fw-bolder">
                                    "Profesjonalna obs&#322;uga, zawsze terminowe rozliczenia. Polecam ka&#380;demu przedsi&#281;biorcy."
                                </p>
                                <div class="d-flex gap-16 align-items-center">
                                    <div class="avatar">
                                        <div class="avatar-wrapper">
                                            <img src="{{person}}" alt="">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="p-s">Jan Kowalski</span>
                                        <span class="p-overline">W&#322;a&#347;ciciel firmy IT</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="od-trust-card swiper-slide a-card-item">
                            <div class="od-trust-card-wrapper">
                                <div class="od-trust-card-stars">
                                    <div class="od-trust-card-star">
                                        <svg class="i-sprite icon-24">
                                            <use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#star_fill"></use>
                                        </svg>
                                    </div>
                                    <div class="od-trust-card-star">
                                        <svg class="i-sprite icon-24">
                                            <use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#star_fill"></use>
                                        </svg>
                                    </div>
                                    <div class="od-trust-card-star">
                                        <svg class="i-sprite icon-24">
                                            <use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#star_fill"></use>
                                        </svg>
                                    </div>
                                    <div class="od-trust-card-star">
                                        <svg class="i-sprite icon-24">
                                            <use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#star_fill"></use>
                                        </svg>
                                    </div>
                                    <div class="od-trust-card-star">
                                        <svg class="i-sprite icon-24">
                                            <use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#star_fill"></use>
                                        </svg>
                                    </div>
                                </div>
                                <p class="p-s fw-bolder">
                                    "Profesjonalna obs&#322;uga, zawsze terminowe rozliczenia. Polecam ka&#380;demu przedsi&#281;biorcy."
                                </p>
                                <div class="d-flex gap-16 align-items-center">
                                    <div class="avatar">
                                        <div class="avatar-wrapper">
                                            <img src="{{person}}" alt="">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="p-s">Jan Kowalski</span>
                                        <span class="p-overline">W&#322;a&#347;ciciel firmy IT</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</section>
