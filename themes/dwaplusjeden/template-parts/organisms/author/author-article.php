<?php
/**
 * Author articles section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$author_post = get_post();

if ( ! $author_post ) {
	return;
}

$related_user = function_exists( 'get_field' ) ? get_field( 'powiazany_uzytkownik', $author_post->ID ) : null;
$user_id      = 0;

if ( is_array( $related_user ) && ! empty( $related_user['ID'] ) ) {
	$user_id = (int) $related_user['ID'];
} elseif ( $related_user instanceof WP_User ) {
	$user_id = (int) $related_user->ID;
} elseif ( is_numeric( $related_user ) ) {
	$user_id = (int) $related_user;
}

$user = $user_id ? get_user_by( 'id', $user_id ) : false;

if ( ! $user ) {
	$user = get_user_by( 'slug', $author_post->post_name );

	if ( ! $user ) {
		$users = get_users(
			array(
				'fields' => array( 'ID', 'display_name' ),
			)
		);

		foreach ( $users as $candidate ) {
			if ( sanitize_title( $candidate->display_name ) === $author_post->post_name ) {
				$user = $candidate;
				break;
			}
		}
	}
}

if ( ! $user ) {
	return;
}

$author_posts = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 6,
		'author'              => (int) $user->ID,
		'ignore_sticky_posts' => true,
	)
);

if ( ! $author_posts->have_posts() ) {
	wp_reset_postdata();
	return;
}

$blog_page_id  = (int) get_option( 'page_for_posts' );
$blog_page_url = $blog_page_id ? get_permalink( $blog_page_id ) : home_url( '/' );
?>

<section class="author-article pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132">
	<div class="container">
		<div class="row">
			<div class="col-12 d-flex align-items-center flex-column">
				<h2 class="h6 fw-bolder c-body w-100 text-center"><?php esc_html_e( 'Artykuły', 'dwaplusjeden' ); ?></h2>
			</div>
		</div>
		<div class="row mt-52 mt-sm-64 mt-xl-96">
			<div class="offset-xxxl-1 col-12 col-xxxl-10">
				<div class="row r-gap-24 a-card-sequence" data-animate-start="top 90%" data-animate-batch-max="3">
					<?php while ( $author_posts->have_posts() ) : ?>
						<?php $author_posts->the_post(); ?>
						<div class="col-sm-6 col-lg-4 a-card-item">
							<?php get_template_part( 'template-parts/organisms/blog/blog-card', null, array( 'post_id' => get_the_ID() ) ); ?>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>

		<?php if ( $author_posts->found_posts > 6 ) : ?>
			<div class="row mt-32 mt-sm-40 mt-lg-48">
				<div class="col-md-6 col-lg-4 col-xxxl-3 mx-auto">
					<a href="<?php echo esc_url( $blog_page_url ); ?>" class="c-btn c-btn-s c-btn-outline w-100">
						<span><?php esc_html_e( 'Więcej artykułów', 'dwaplusjeden' ); ?></span>
					</a>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
wp_reset_postdata();
