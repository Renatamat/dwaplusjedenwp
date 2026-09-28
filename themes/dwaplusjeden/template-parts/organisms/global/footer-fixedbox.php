<?php
/**
 * Smart accounting banner configured in theme options.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) ) {
    return;
}

$image = get_field( 'smart_accounting_image', 'option' );
$rows  = get_field( 'smart_accounting_texts', 'option' );
$texts = array();

foreach ( is_array( $rows ) ? $rows : array() as $row ) {
    $text = isset( $row['text'] ) ? trim( (string) $row['text'] ) : '';

    if ( '' !== $text ) {
        $texts[] = $text;
    }
}

if ( empty( $texts ) ) {
    return;
}

$button = dwaplusjeden_get_acf_link( 'smart_accounting_button', 'option' );
?>
<div class="footer-fixedbox">
    <button type="button" class="footer-fixedbox-close" aria-label="Zamknij baner" title="Zamknij baner">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="footer-fixedbox-content">
        <?php if ( $image ) : ?>
            <div class="footer-fixedbox-image">
                <?php dwaplusjeden_image( $image, 'full' ); ?>
            </div>
        <?php endif; ?>
        <div class="footer-fixedbox-text">
            <div class="footer-fixedbox-text-track">
                <?php for ( $copy = 0; $copy < 4; $copy++ ) : ?>
                <div class="footer-fixedbox-text-group"<?php echo $copy ? ' aria-hidden="true"' : ''; ?>>
                    <?php foreach ( $texts as $text ) : ?>
                    <span class="p-l"><?php echo esc_html( $text ); ?></span>
                    <div class="footer-fixedbox-text-separator" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <circle cx="6" cy="6" r="6" fill="#E92B4D"/>
                        </svg>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endfor; ?>
            </div>
        </div>
        <?php if ( ! empty( $button['url'] ) && ! empty( $button['title'] ) ) : ?>
            <div class="footer-fixedbox-btn">
                <a<?php dwaplusjeden_link_attrs( $button ); ?> class="c-btn c-btn-s c-btn-fill w-100">
                    <span><?php echo esc_html( $button['title'] ); ?></span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
