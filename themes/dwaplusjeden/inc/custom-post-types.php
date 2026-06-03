<?php
/**
 * Custom post types.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Register theme custom post types.
 */
function dwaplusjeden_register_custom_post_types() {
	register_post_type(
		'pricing_package',
		array(
			'labels'       => array(
				'name'               => __( 'Pakiety cennika', 'dwaplusjeden' ),
				'singular_name'      => __( 'Pakiet cennika', 'dwaplusjeden' ),
				'add_new_item'       => __( 'Dodaj pakiet cennika', 'dwaplusjeden' ),
				'edit_item'          => __( 'Edytuj pakiet cennika', 'dwaplusjeden' ),
				'new_item'           => __( 'Nowy pakiet cennika', 'dwaplusjeden' ),
				'view_item'          => __( 'Zobacz pakiet cennika', 'dwaplusjeden' ),
				'search_items'       => __( 'Szukaj pakietów cennika', 'dwaplusjeden' ),
				'not_found'          => __( 'Nie znaleziono pakietów cennika', 'dwaplusjeden' ),
				'not_found_in_trash' => __( 'Nie znaleziono pakietów cennika w koszu', 'dwaplusjeden' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'menu_icon'    => 'dashicons-money-alt',
			'supports'     => array( 'title' ),
			'has_archive'  => false,
			'rewrite'      => false,
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'dwaplusjeden_register_custom_post_types' );
