<?php
/**
 * ACF field helpers.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Get stable pricing feature key.
 *
 * @param array $feature Feature row.
 * @param int   $index   Feature index.
 * @return string
 */
function dwaplusjeden_get_pricing_feature_key( $feature, $index = 0 ) {
	$key = ! empty( $feature['key'] ) ? $feature['key'] : '';

	if ( ! $key && ! empty( $feature['text'] ) ) {
		$key = $feature['text'];
	}

	if ( ! $key ) {
		$key = 'feature-' . ( (int) $index + 1 );
	}

	return sanitize_title( $key );
}

/**
 * Populate pricing option active feature choices from the current pricing package.
 *
 * @param array $field ACF field config.
 * @return array
 */
function dwaplusjeden_acf_load_pricing_active_features( $field ) {
	$post_id = 0;

	if ( isset( $_GET['post'] ) ) {
		$post_id = absint( $_GET['post'] );
	} elseif ( isset( $_POST['post_id'] ) ) {
		$post_id = absint( str_replace( 'post_', '', sanitize_text_field( wp_unslash( $_POST['post_id'] ) ) ) );
	}

	$field['choices'] = array();

	if ( ! $post_id || 'pricing_package' !== get_post_type( $post_id ) ) {
		return $field;
	}

	$features = get_field( 'pricing_package_features', $post_id );

	if ( ! $features ) {
		return $field;
	}

	foreach ( $features as $index => $feature ) {
		if ( empty( $feature['text'] ) ) {
			continue;
		}

		$field['choices'][ dwaplusjeden_get_pricing_feature_key( $feature, $index ) ] = $feature['text'];
	}

	return $field;
}
add_filter( 'acf/load_field/key=field_pricing_option_active_features', 'dwaplusjeden_acf_load_pricing_active_features' );
