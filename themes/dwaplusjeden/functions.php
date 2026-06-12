<?php
/**
 * dwaplusjeden functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package dwaplusjeden
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dwaplusjeden_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on dwaplusjeden, use a find and replace
		* to change 'dwaplusjeden' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'dwaplusjeden', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in multiple locations.
	register_nav_menus(
		array(
			'menu-1'                       => esc_html__( 'Menu główne', 'dwaplusjeden' ),
			'footer-accounting'            => esc_html__( 'Footer - Księgowość', 'dwaplusjeden' ),
			'footer-industries'            => esc_html__( 'Footer - Branże', 'dwaplusjeden' ),
			'footer-business-support'      => esc_html__( 'Footer - Wsparcie biznesu', 'dwaplusjeden' ),
			'footer-company-registration'  => esc_html__( 'Footer - Rejestracja firmy', 'dwaplusjeden' ),
			'footer-useful-links'          => esc_html__( 'Footer - Przydatne linki', 'dwaplusjeden' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'dwaplusjeden_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'dwaplusjeden_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function dwaplusjeden_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'dwaplusjeden_content_width', 640 );
}
add_action( 'after_setup_theme', 'dwaplusjeden_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dwaplusjeden_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'dwaplusjeden' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'dwaplusjeden' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'dwaplusjeden_widgets_init' );

/**
 * Preload local theme fonts before the main stylesheet is parsed.
 */
function dwaplusjeden_preload_fonts() {
	$font_files = array(
		'work-sans-v24-latin-ext-200.woff2',
		'work-sans-v24-latin-ext-regular.woff2',
		'work-sans-v24-latin-ext-600.woff2',
	);

	foreach ( $font_files as $font_file ) {
		$font_path = get_template_directory() . '/fonts/' . $font_file;

		if ( ! file_exists( $font_path ) ) {
			continue;
		}

		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( get_template_directory_uri() . '/fonts/' . $font_file )
		);
	}
}
add_action( 'wp_head', 'dwaplusjeden_preload_fonts', 1 );

/**
 * Enqueue scripts and styles.
 */
function dwaplusjeden_scripts() {
	$theme_style_path = get_template_directory() . '/assets/css/style.css';
	$theme_style_uri  = get_template_directory_uri() . '/assets/css/style.css';
	$theme_style_ver  = file_exists( $theme_style_path ) ? filemtime( $theme_style_path ) : _S_VERSION;
	$theme_script_path = get_template_directory() . '/assets/js/bundle.js';
	$theme_script_uri  = get_template_directory_uri() . '/assets/js/bundle.js';
	$theme_gsap_path   = get_template_directory() . '/assets/js/gsap.bundle.js';
	$theme_gsap_uri    = get_template_directory_uri() . '/assets/js/gsap.bundle.js';
	$blog_script_path  = get_template_directory() . '/assets/js/blog-load-more.js';
	$blog_script_uri   = get_template_directory_uri() . '/assets/js/blog-load-more.js';
	$contact_popup_script_path = get_template_directory() . '/assets/js/contact-popup.js';
	$contact_popup_script_uri  = get_template_directory_uri() . '/assets/js/contact-popup.js';

	if ( ! file_exists( $theme_script_path ) ) {
		$theme_script_path = get_template_directory() . '/_dev/source/js/bundle/bundle.js';
		$theme_script_uri  = get_template_directory_uri() . '/_dev/source/js/bundle/bundle.js';
	}

	if ( ! file_exists( $theme_gsap_path ) ) {
		$theme_gsap_path = get_template_directory() . '/_dev/source/js/bundle/gsap.bundle.js';
		$theme_gsap_uri  = get_template_directory_uri() . '/_dev/source/js/bundle/gsap.bundle.js';
	}

	wp_enqueue_style( 'dwaplusjeden-style', $theme_style_uri, array(), $theme_style_ver );
	wp_style_add_data( 'dwaplusjeden-style', 'rtl', 'replace' );

	if ( file_exists( $theme_script_path ) ) {
		wp_enqueue_script( 'dwaplusjeden-bundle', $theme_script_uri, array(), filemtime( $theme_script_path ), true );
	}

	if ( file_exists( $theme_gsap_path ) ) {
		wp_enqueue_script( 'dwaplusjeden-gsap', $theme_gsap_uri, array(), filemtime( $theme_gsap_path ), true );
	}

	if ( file_exists( $blog_script_path ) && ( is_home() || is_category() || is_tag() || is_date() || is_author() || is_search() ) ) {
		wp_enqueue_script( 'dwaplusjeden-blog-load-more', $blog_script_uri, array(), filemtime( $blog_script_path ), true );
	}

	if ( file_exists( $contact_popup_script_path ) && ( is_page_template( 'template-kontakt.php' ) || is_page_template( 'template-formularz-zgloszeniowy.php' ) ) ) {
		wp_enqueue_script( 'dwaplusjeden-contact-popup', $contact_popup_script_uri, array(), filemtime( $contact_popup_script_path ), true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dwaplusjeden_scripts' );

/**
 * Allow SVG uploads.
 *
 * @param array $mimes Allowed MIME types.
 * @return array
 */
function dwaplusjeden_allow_svg_uploads( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}
add_filter( 'upload_mimes', 'dwaplusjeden_allow_svg_uploads' );

/**
 * Fix SVG file type validation.
 *
 * @param array  $data     File type data.
 * @param string $file     Full path to the file.
 * @param string $filename Uploaded file name.
 * @param array  $mimes    Allowed MIME types.
 * @return array
 */
function dwaplusjeden_check_svg_filetype( $data, $file, $filename, $mimes ) {
	if ( 'svg' !== pathinfo( $filename, PATHINFO_EXTENSION ) ) {
		return $data;
	}

	$filetype = wp_check_filetype( $filename, $mimes );

	return array(
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename'],
	);
}
add_filter( 'wp_check_filetype_and_ext', 'dwaplusjeden_check_svg_filetype', 10, 4 );

/**
 * Disable Contact Form 7 automatic paragraph wrappers.
 *
 * @return bool
 */
function dwaplusjeden_disable_cf7_autop() {
	return false;
}
add_filter( 'wpcf7_autop_or_not', 'dwaplusjeden_disable_cf7_autop' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom post types.
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * ACF field helpers.
 */
require get_template_directory() . '/inc/acf-fields.php';

/**
 * Blog AJAX handlers.
 */
require get_template_directory() . '/inc/blog-ajax.php';

/**
 * Gutenberg ACF blocks.
 */
require get_template_directory() . '/inc/blocks.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
