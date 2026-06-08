<?php
/**
 * Blog AJAX handlers.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Render next blog cards for archive load more.
 */
function dwaplusjeden_ajax_load_blog_posts() {
	check_ajax_referer( 'dwaplusjeden_blog_load_more', 'nonce' );

	$offset = isset( $_POST['offset'] ) ? absint( $_POST['offset'] ) : 0;
	$args   = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'offset'              => $offset,
		'ignore_sticky_posts' => true,
	);

	if ( ! empty( $_POST['category'] ) ) {
		$args['cat'] = absint( $_POST['category'] );
	}

	if ( ! empty( $_POST['tag'] ) ) {
		$args['tag_id'] = absint( $_POST['tag'] );
	}

	if ( ! empty( $_POST['author'] ) ) {
		$args['author'] = absint( $_POST['author'] );
	}

	if ( ! empty( $_POST['year'] ) ) {
		$args['year'] = absint( $_POST['year'] );
	}

	if ( ! empty( $_POST['monthnum'] ) ) {
		$args['monthnum'] = absint( $_POST['monthnum'] );
	}

	if ( ! empty( $_POST['day'] ) ) {
		$args['day'] = absint( $_POST['day'] );
	}

	if ( ! empty( $_POST['search'] ) ) {
		$args['s'] = sanitize_text_field( wp_unslash( $_POST['search'] ) );
	}

	$query = new WP_Query( $args );

	ob_start();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			?>
			<div class="col-sm-6 col-lg-4 a-card-item">
				<?php get_template_part( 'template-parts/organisms/blog/blog-card', null, array( 'post_id' => get_the_ID() ) ); ?>
			</div>
			<?php
		}
	}

	wp_reset_postdata();

	$html        = ob_get_clean();
	$next_offset = $offset + (int) $query->post_count;

	wp_send_json_success(
		array(
			'html'        => $html,
			'nextOffset'  => $next_offset,
			'hasMore'     => $next_offset < (int) $query->found_posts,
			'foundPosts'  => (int) $query->found_posts,
			'loadedPosts' => (int) $query->post_count,
		)
	);
}
add_action( 'wp_ajax_dwaplusjeden_load_blog_posts', 'dwaplusjeden_ajax_load_blog_posts' );
add_action( 'wp_ajax_nopriv_dwaplusjeden_load_blog_posts', 'dwaplusjeden_ajax_load_blog_posts' );
