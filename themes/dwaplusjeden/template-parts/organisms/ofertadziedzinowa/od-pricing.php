<?php
/**
 * Single pricing package for a field offer.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) ) {
	return;
}

if ( ! get_field( 'od_pricing_enabled' ) ) {
	return;
}

$packages = get_field( 'od_pricing_packages' );

if ( ! is_array( $packages ) || ! $packages ) {
	return;
}

$package    = reset( $packages );
$package_id = $package instanceof WP_Post ? $package->ID : (int) $package;

if ( 'pricing_package' !== get_post_type( $package_id ) || 'publish' !== get_post_status( $package_id ) ) {
	return;
}

get_template_part(
	'template-parts/organisms/global/pakiety-section',
	null,
	array(
		'field_prefix'  => 'od_pricing',
		'packages'      => array( $package_id ),
		'show_tabs'     => false,
		'section_class' => 'od-pricing',
		'disclaimer'    => get_field( 'od_pricing_disclaimer' ),
		'link'          => dwaplusjeden_get_acf_link( 'od_pricing_link', get_the_ID() ),
	)
);
