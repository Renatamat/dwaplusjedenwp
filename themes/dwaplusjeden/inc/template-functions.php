<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package dwaplusjeden
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function dwaplusjeden_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'dwaplusjeden_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function dwaplusjeden_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'dwaplusjeden_pingback_header' );

/**
 * Limit frontend search results to blog posts.
 *
 * @param WP_Query $query Query object.
 */
function dwaplusjeden_search_posts_only( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return;
	}

	$query->set( 'post_type', 'post' );
}
add_action( 'pre_get_posts', 'dwaplusjeden_search_posts_only' );

/**
 * Translate URL with WPML when available.
 *
 * @param string $url URL to translate.
 * @return string
 */
function dwaplusjeden_translate_url( $url ) {
	if ( ! $url ) {
		return '';
	}

	if ( has_filter( 'wpml_permalink' ) ) {
		$language_code = defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : '';

		return apply_filters( 'wpml_permalink', $url, $language_code );
	}

	return $url;
}

/**
 * Get ACF link with translated URL.
 *
 * @param string $field_name ACF field name.
 * @param string $post_id    ACF post id.
 * @return array
 */
function dwaplusjeden_get_acf_link( $field_name, $post_id = 'option' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return array();
	}

	$link = get_field( $field_name, $post_id );

	if ( empty( $link['url'] ) ) {
		return array();
	}

	$link['url'] = dwaplusjeden_translate_url( $link['url'] );

	return $link;
}

/**
 * Print link attributes for an ACF link field.
 *
 * @param array $link ACF link.
 */
function dwaplusjeden_link_attrs( $link ) {
	if ( empty( $link['url'] ) ) {
		return;
	}

	$target = ! empty( $link['target'] ) ? $link['target'] : '';
	$rel    = '_blank' === $target ? 'noopener noreferrer' : '';
	$rel    = ! empty( $link['nofollow'] ) ? trim( $rel . ' nofollow' ) : $rel;

	echo ' href="' . esc_url( $link['url'] ) . '"';
	echo $target ? ' target="' . esc_attr( $target ) . '"' : '';
	echo $rel ? ' rel="' . esc_attr( $rel ) . '"' : '';
}

/**
 * Get menu items for a theme location.
 *
 * @param string $location Theme location.
 * @return array
 */
function dwaplusjeden_get_menu_items_by_location( $location ) {
	$locations = get_nav_menu_locations();

	if ( empty( $locations[ $location ] ) ) {
		return array();
	}

	$menu_id = $locations[ $location ];

	if ( has_filter( 'wpml_object_id' ) ) {
		$menu_id = apply_filters( 'wpml_object_id', $menu_id, 'nav_menu', true );
	}

	$items = wp_get_nav_menu_items( $menu_id );

	return $items ? $items : array();
}

/**
 * Print footer menu links.
 *
 * @param string $location Theme location.
 * @param string $class    Menu wrapper classes.
 */
function dwaplusjeden_footer_menu( $location, $class = 'd-flex flex-column gap-16' ) {
	$items = dwaplusjeden_get_menu_items_by_location( $location );

	if ( ! $items ) {
		return;
	}

	echo '<div class="' . esc_attr( $class ) . '">';

	foreach ( $items as $item ) {
		$url    = dwaplusjeden_translate_url( $item->url );
		$target = ! empty( $item->target ) ? $item->target : '';
		$rel    = trim( ( ! empty( $item->xfn ) ? $item->xfn . ' ' : '' ) . ( '_blank' === $target ? 'noopener noreferrer' : '' ) );

		echo '<a href="' . esc_url( $url ) . '" class="p-s c-white link-underline-rtl"';
		echo $target ? ' target="' . esc_attr( $target ) . '"' : '';
		echo $rel ? ' rel="' . esc_attr( $rel ) . '"' : '';
		echo '>' . esc_html( $item->title ) . '</a>';
	}

	echo '</div>';
}

/**
 * Get theme sprite URL.
 *
 * @param string $sprite Sprite file name.
 * @return string
 */
function dwaplusjeden_get_sprite_url( $sprite ) {
	return get_template_directory_uri() . '/_dev/public/sprites/' . ltrim( $sprite, '/' );
}

/**
 * Get breadcrumb links from Yoast SEO.
 *
 * @return array
 */
function dwaplusjeden_get_yoast_breadcrumb_links() {
	if ( ! class_exists( 'WPSEO_Breadcrumbs' ) ) {
		return array();
	}

	$breadcrumbs = new WPSEO_Breadcrumbs();

	if ( ! is_callable( array( $breadcrumbs, 'get_links' ) ) ) {
		return array();
	}

	$links = $breadcrumbs->get_links();

	return is_array( $links ) ? $links : array();
}

/**
 * Add WordPress page ancestors when Yoast returns a flattened page breadcrumb.
 *
 * @param array $links Yoast breadcrumb links.
 * @return array
 */
function dwaplusjeden_get_page_breadcrumb_links( $links ) {
	if ( ! is_page() ) {
		return $links;
	}

	$page_id = get_queried_object_id();

	if ( ! $page_id ) {
		return $links;
	}

	$ancestors = array_reverse( get_post_ancestors( $page_id ) );

	if ( empty( $ancestors ) ) {
		return $links;
	}

	$home = ! empty( $links[0] ) ? $links[0] : array(
		'text' => __( 'Strona główna', 'dwaplusjeden' ),
		'url'  => home_url( '/' ),
	);

	$current = ! empty( $links[ count( $links ) - 1 ] ) ? $links[ count( $links ) - 1 ] : array(
		'text' => get_the_title( $page_id ),
	);

	$page_links = array( $home );

	foreach ( $ancestors as $ancestor_id ) {
		$page_links[] = array(
			'text' => get_the_title( $ancestor_id ),
			'url'  => get_permalink( $ancestor_id ),
		);
	}

	$page_links[] = array(
		'text' => ! empty( $current['text'] ) ? $current['text'] : get_the_title( $page_id ),
		'url'  => '',
	);

	return $page_links;
}

/**
 * Print breadcrumb using Yoast data and Pattern Lab markup.
 */
function dwaplusjeden_breadcrumb() {
	if ( is_front_page() || is_search() ) {
		return;
	}

	$links = array_values(
		array_filter(
			dwaplusjeden_get_yoast_breadcrumb_links(),
			function ( $link ) {
				return ! empty( $link['text'] );
			}
		)
	);

	$links = dwaplusjeden_get_page_breadcrumb_links( $links );

	if ( empty( $links ) ) {
		return;
	}

	echo '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Okruszki', 'dwaplusjeden' ) . '">';

	foreach ( $links as $index => $link ) {
		$text    = ! empty( $link['text'] ) ? wp_strip_all_tags( $link['text'] ) : '';
		$url     = ! empty( $link['url'] ) ? dwaplusjeden_translate_url( $link['url'] ) : '';
		$is_last = count( $links ) - 1 === $index;

		if ( $index > 0 ) {
			echo '<span class="breadcrumb-separator" aria-hidden="true">';
			echo '<svg class="i-sprite icon-16"><use href="' . esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ) . '#chevron_right_2"></use></svg>';
			echo '</span>';
		}

		if ( $is_last ) {
			echo '<span class="breadcrumb_last" aria-current="page">' . esc_html( $text ) . '</span>';
			continue;
		}

		$class = 0 === $index ? ' class="breadcrumb-home"' : '';
		echo '<span' . $class . '>';

		if ( $url ) {
			echo '<a href="' . esc_url( $url ) . '">' . esc_html( $text ) . '</a>';
		} else {
			echo esc_html( $text );
		}

		echo '</span>';
	}

	echo '</nav>';
}

/**
 * Get Pattern Lab image fallback URL.
 *
 * @param string $image Image file name.
 * @return string
 */
function dwaplusjeden_get_theme_image_url( $image ) {
	return get_template_directory_uri() . '/_dev/source/images/' . ltrim( $image, '/' );
}

/**
 * Print image from attachment id with Pattern Lab fallback.
 *
 * @param int    $attachment_id Attachment id.
 * @param string $size          Image size.
 * @param string $fallback      Fallback image file name.
 * @param string $alt           Fallback alt.
 */
function dwaplusjeden_image( $attachment_id, $size = 'full', $fallback = '', $alt = '' ) {

	if ( is_array( $attachment_id ) && ! empty( $attachment_id['ID'] ) ) {
		$attachment_id = (int) $attachment_id['ID'];
	} elseif ( is_array( $attachment_id ) && ! empty( $attachment_id['id'] ) ) {
		$attachment_id = (int) $attachment_id['id'];
	} elseif ( is_object( $attachment_id ) && ! empty( $attachment_id->ID ) ) {
		$attachment_id = (int) $attachment_id->ID;
	} else {
		$attachment_id = (int) $attachment_id;
	}

	if ( $attachment_id ) {
		echo wp_get_attachment_image(
			$attachment_id,
			$size,
			false,
			array(
				'alt' => get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ?: $alt,
			)
		);
		return;
	}

	if ( $fallback ) {
		echo '<img src="' . esc_url( dwaplusjeden_get_theme_image_url( $fallback ) ) . '" alt="' . esc_attr( $alt ) . '">';
	}
}

/**
 * Get URL from optional related post first, then ACF link.
 *
 * @param mixed $related Related post value.
 * @param array $link    ACF link.
 * @return array
 */
function dwaplusjeden_get_relation_or_link( $related, $link ) {
	$post_id = 0;

	if ( $related instanceof WP_Post ) {
		$post_id = $related->ID;
	} elseif ( is_numeric( $related ) ) {
		$post_id = (int) $related;
	} elseif ( is_array( $related ) && ! empty( $related[0] ) ) {
		$post_id = $related[0] instanceof WP_Post ? $related[0]->ID : (int) $related[0];
	}

	if ( $post_id ) {
		if ( has_filter( 'wpml_object_id' ) ) {
			$post_id = apply_filters( 'wpml_object_id', $post_id, get_post_type( $post_id ), true );
		}

		return array(
			'url'    => get_permalink( $post_id ),
			'title'  => get_the_title( $post_id ),
			'target' => '',
		);
	}

	if ( ! empty( $link['url'] ) ) {
		$link['url'] = dwaplusjeden_translate_url( $link['url'] );
		return $link;
	}

	return array();
}

/**
 * Get header logo data.
 *
 * @return array
 */
function dwaplusjeden_get_header_logo() {
	$custom_logo_id = get_theme_mod( 'custom_logo' );

	if ( $custom_logo_id ) {
		$logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );

		if ( $logo ) {
			return array(
				'url' => $logo[0],
				'alt' => get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true ) ?: get_bloginfo( 'name' ),
			);
		}
	}

	return array(
		'url' => get_template_directory_uri() . '/_dev/source/images/Logo.svg',
		'alt' => get_bloginfo( 'name' ),
	);
}

/**
 * Return the restricted HTML allowlist used for basic editable content.
 *
 * @param bool $inline_only Whether to return only elements safe inside a heading.
 * @return array<string, array<string, bool>>
 */
function dwaplusjeden_get_basic_allowed_html( $inline_only = false ) {
	$with_class = [
		'class' => true,
	];

	$inline_html = [
		'strong' => $with_class,
		'b'      => $with_class,
		'em'     => $with_class,
		'i'      => $with_class,
		'br'     => $with_class,
		'span'   => $with_class,
		'sup'    => $with_class,
		'sub'    => $with_class,
		'a'      => [
			'href'       => true,
			'title'      => true,
			'target'     => true,
			'rel'        => true,
			'class'      => true,
			'aria-label' => true,
		],
	];

	if ( $inline_only ) {
		return $inline_html;
	}

	return array_merge(
		$inline_html,
		[
			'p'          => $with_class,
			'blockquote' => [
				'class' => true,
				'cite'  => true,
			],
			'del'        => [
				'class'    => true,
				'cite'     => true,
				'datetime' => true,
			],
			'ins'        => [
				'class'    => true,
				'cite'     => true,
				'datetime' => true,
			],
			'code'       => $with_class,
			'img'        => [
				'src'     => true,
				'alt'     => true,
				'title'   => true,
				'width'   => true,
				'height'  => true,
				'class'   => true,
				'loading' => true,
				'srcset'  => true,
				'sizes'        => true,
				'data-wp-more' => true,
			],
			'ul'       => $with_class,
			'ol'       => $with_class,
			'li'       => $with_class,
			'table'    => $with_class,
			'caption'  => $with_class,
			'colgroup' => $with_class,
			'col'      => [
				'class' => true,
				'span'  => true,
			],
			'thead'    => $with_class,
			'tbody'    => $with_class,
			'tfoot'    => $with_class,
			'tr'       => $with_class,
			'th'       => [
				'class'   => true,
				'colspan' => true,
				'rowspan' => true,
				'headers' => true,
				'scope'   => true,
				'abbr'    => true,
			],
			'td'       => [
				'class'   => true,
				'colspan' => true,
				'rowspan' => true,
				'headers' => true,
			],
		]
	);
}

/**
 * Remove editor leftovers that Word/TinyMCE can leave after attribute cleanup.
 *
 * @param string $html Sanitized HTML.
 * @return string
 */
function dwaplusjeden_cleanup_editor_spans( $html ) {
	$html = (string) $html;

	do {
		$previous = $html;
		$html     = preg_replace( '/<span(?:\s+class=(["\'])[^"\']*\1)?\s*>(?:\s|&nbsp;|&#160;|<br\s*\/?>)*<\/span>/i', '', $html );
		$html     = preg_replace( '/<span\s*>(.*?)<\/span>/is', '$1', $html );
	} while ( $html !== $previous );

	return $html;
}

/**
 * Normalize and sanitize basic editable content.
 *
 * Heading tags pasted into body content become paragraphs. Inside an existing
 * template heading they become spans, preventing invalid nested headings.
 *
 * @param string $html        Content to sanitize.
 * @param bool   $inline_only Whether the content is placed inside a heading.
 * @return string
 */
function dwaplusjeden_kses_basic_content( $html, $inline_only = false ) {
	$replacement_tag = $inline_only ? 'span' : 'p';
	$html            = (string) $html;
	$html            = preg_replace( '/<h[1-6]\b([^>]*)>/i', '<' . $replacement_tag . '$1>', $html );
	$html            = preg_replace( '/<\/h[1-6]\s*>/i', '</' . $replacement_tag . '>', $html );

	$html = wp_kses( $html, dwaplusjeden_get_basic_allowed_html( $inline_only ) );

	return dwaplusjeden_cleanup_editor_spans( $html );
}
/**
 * Print main navigation using Pattern Lab markup.
 */
function dwaplusjeden_main_navigation() {
	$items = dwaplusjeden_get_menu_items_by_location( 'menu-1' );

	if ( ! $items ) {
		return;
	}

	$items_by_parent = array();

	foreach ( $items as $item ) {
		$items_by_parent[ (int) $item->menu_item_parent ][] = $item;
	}

	if ( empty( $items_by_parent[0] ) ) {
		return;
	}

	echo '<ul class="main-menu">';

	foreach ( $items_by_parent[0] as $item ) {
		$children    = ! empty( $items_by_parent[ (int) $item->ID ] ) ? $items_by_parent[ (int) $item->ID ] : array();
		$item_classes = array_filter(
			array(
				'menu-item',
				$children ? 'menu-item-has-children' : '',
				in_array( 'current-menu-item', $item->classes, true ) ? 'current-menu-item' : '',
				in_array( 'current-menu-ancestor', $item->classes, true ) ? 'current-menu-ancestor' : '',
			)
		);
		$url          = dwaplusjeden_translate_url( $item->url );
		$target       = ! empty( $item->target ) ? $item->target : '';
		$rel          = trim( ( ! empty( $item->xfn ) ? $item->xfn . ' ' : '' ) . ( '_blank' === $target ? 'noopener noreferrer' : '' ) );
		$current_attr = in_array( 'current-menu-item', $item->classes, true ) ? ' aria-current="page"' : '';

		echo '<li class="' . esc_attr( implode( ' ', $item_classes ) ) . '">';
		echo '<a href="' . esc_url( $url ) . '" class="c-btn c-btn-s c-btn-link"' . $current_attr;
		echo $target ? ' target="' . esc_attr( $target ) . '"' : '';
		echo $rel ? ' rel="' . esc_attr( $rel ) . '"' : '';
		echo '><span>' . esc_html( $item->title ) . '</span></a>';

		if ( $children ) {
			echo '<div class="mobile-button-submenu d-xl-none">';
			echo '<svg class="i-sprite icon-16"><use href="' . esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ) . '#chevron_right"></use></svg>';
			echo '</div>';
			echo '<div class="sub-menu">';
			echo '<div class="mobile-back d-flex align-items-center gap-8">';
			echo '<svg class="i-sprite icon-16"><use href="' . esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ) . '#chevron_left"></use></svg>';
			echo '<span class="p-s fw-bolder">' . esc_html( $item->title ) . '</span>';
			echo '</div>';
			echo '<ul class="mt-16" aria-label="' . esc_attr( sprintf( /* translators: %s: menu item title */ __( 'Podmenu: %s', 'dwaplusjeden' ), $item->title ) ) . '">';

			foreach ( $children as $child ) {
				$child_url    = dwaplusjeden_translate_url( $child->url );
				$child_target = ! empty( $child->target ) ? $child->target : '';
				$child_rel    = trim( ( ! empty( $child->xfn ) ? $child->xfn . ' ' : '' ) . ( '_blank' === $child_target ? 'noopener noreferrer' : '' ) );

				echo '<li>';
				echo '<a href="' . esc_url( $child_url ) . '"';
				echo $child_target ? ' target="' . esc_attr( $child_target ) . '"' : '';
				echo $child_rel ? ' rel="' . esc_attr( $child_rel ) . '"' : '';
				echo '><span class="p-s">' . esc_html( $child->title ) . '</span></a>';
				echo '</li>';
			}

			echo '</ul>';
			echo '</div>';
		}

		echo '</li>';
	}

	echo '</ul>';
}
