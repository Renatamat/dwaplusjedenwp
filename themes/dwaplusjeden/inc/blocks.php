<?php
/**
 * Gutenberg ACF blocks.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

add_action(
	'acf/init',
	function () {
		if ( ! function_exists( 'acf_register_block_type' ) ) {
			return;
		}

		acf_register_block_type(
			array(
				'name'            => 'text-wysiwyg',
				'title'           => __( 'Info sekcja', 'dwaplusjeden' ),
				'description'     => __( 'Wyróżniony boks informacyjny z nagłówkiem i treścią.', 'dwaplusjeden' ),
				'render_template' => 'template-parts/blocks/text-wysiwyg.php',
				'enqueue_assets'  => function () {
					$editor_blocks_style_path = get_template_directory() . '/assets/css/editor-blocks.css';

					wp_enqueue_style(
						'dwaplusjeden-editor-blocks',
						get_template_directory_uri() . '/assets/css/editor-blocks.css',
						array(),
						file_exists( $editor_blocks_style_path ) ? filemtime( $editor_blocks_style_path ) : '1.0.0'
					);
				},
				'category'        => 'formatting',
				'icon'            => 'info',
				'keywords'        => array( 'info', 'informacja', 'tekst', 'wysiwyg' ),
				'mode'            => 'preview',
				'supports'        => array(
					'align'  => false,
					'anchor' => true,
				),
			)
		);
	}
);

add_action(
	'enqueue_block_editor_assets',
	function () {
		$editor_blocks_style_path = get_template_directory() . '/assets/css/editor-blocks.css';

		wp_enqueue_style(
			'dwaplusjeden-editor-blocks',
			get_template_directory_uri() . '/assets/css/editor-blocks.css',
			array(),
			file_exists( $editor_blocks_style_path ) ? filemtime( $editor_blocks_style_path ) : '1.0.0'
		);
	}
);
