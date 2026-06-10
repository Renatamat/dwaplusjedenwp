<?php
/**
 * Blog taxonomy archive listing section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

global $wp_query;

$displayed_posts = 0;
$total_posts     = isset( $wp_query ) ? (int) $wp_query->found_posts : 0;
$archive_data    = array(
	'category' => is_category() ? (int) get_queried_object_id() : 0,
	'tag'      => is_tag() ? (int) get_queried_object_id() : 0,
	'author'   => is_author() ? (int) get_queried_object_id() : 0,
	'year'     => is_date() ? (int) get_query_var( 'year' ) : 0,
	'monthnum' => is_date() ? (int) get_query_var( 'monthnum' ) : 0,
	'day'      => is_date() ? (int) get_query_var( 'day' ) : 0,
);
?>

<section class="blog-allnews pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132">
	<div class="container">
		<div class="row">
			<div class="col-12 offset-xxxl-1 col-xxxl-10">
				<?php if ( have_posts() ) : ?>
					<div class="row r-gap-24 a-card-sequence" data-blog-posts-grid data-animate-start="top 90%" data-animate-batch-max="3">
						<?php while ( have_posts() ) : ?>
							<?php the_post(); ?>
							<?php ++$displayed_posts; ?>
							<div class="col-sm-6 col-lg-4 a-card-item">
								<?php get_template_part( 'template-parts/organisms/blog/blog-card', null, array( 'post_id' => get_the_ID() ) ); ?>
							</div>
						<?php endwhile; ?>
					</div>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( $displayed_posts < $total_posts ) : ?>
			<div class="row mt-56 mt-sm-64 mt-lg-96">
				<div class="col-md-6 col-lg-4 col-xxxl-3 mx-auto">
					<button
						type="button"
						class="c-btn c-btn-s c-btn-outline w-100"
						data-blog-load-more
						data-target=".blog-allnews [data-blog-posts-grid]"
						data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'dwaplusjeden_blog_load_more' ) ); ?>"
						data-offset="<?php echo esc_attr( $displayed_posts ); ?>"
						data-loading-label="<?php esc_attr_e( 'Ładowanie...', 'dwaplusjeden' ); ?>"
						data-category="<?php echo esc_attr( $archive_data['category'] ); ?>"
						data-tag="<?php echo esc_attr( $archive_data['tag'] ); ?>"
						data-author="<?php echo esc_attr( $archive_data['author'] ); ?>"
						data-year="<?php echo esc_attr( $archive_data['year'] ); ?>"
						data-monthnum="<?php echo esc_attr( $archive_data['monthnum'] ); ?>"
						data-day="<?php echo esc_attr( $archive_data['day'] ); ?>"
					>
						<span><?php esc_html_e( 'Więcej artykułów', 'dwaplusjeden' ); ?></span>
					</button>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
