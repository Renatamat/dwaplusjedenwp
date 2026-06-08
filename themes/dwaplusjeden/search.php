<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package dwaplusjeden
 */

get_header();

global $wp_query;

$search_query    = get_search_query();
$displayed_posts = 0;
$total_posts     = isset( $wp_query ) ? (int) $wp_query->found_posts : 0;
?>

<main id="primary" class="site-main">
	<section class="search-article pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132" aria-labelledby="search-results-heading">
		<div class="container">
			<div class="row">
				<div class="col-12 d-flex align-items-center flex-column">
					<h1 id="search-results-heading" class="h6 fw-bolder c-body w-100 text-center">
						<?php
						printf(
							/* translators: %s: search query. */
							esc_html__( 'Wyniki wyszukiwania: %s', 'dwaplusjeden' ),
							esc_html( $search_query )
						);
						?>
					</h1>
				</div>
			</div>

			<div class="row mt-52 mt-sm-64 mt-xl-96">
				<div class="offset-xxxl-1 col-12 col-xxxl-10">
					<?php if ( have_posts() ) : ?>
						<div class="row r-gap-24 a-card-sequence" data-search-posts-grid data-animate-start="top 90%" data-animate-batch-max="3">
							<?php while ( have_posts() ) : ?>
								<?php the_post(); ?>
								<?php ++$displayed_posts; ?>
								<div class="col-sm-6 col-lg-4 a-card-item">
									<?php get_template_part( 'template-parts/organisms/blog/blog-card', null, array( 'post_id' => get_the_ID() ) ); ?>
								</div>
							<?php endwhile; ?>
						</div>
					<?php else : ?>
						<div class="text-center">
							<p class="p-m c-body"><?php esc_html_e( 'Nie znaleziono artykułów dla tej frazy.', 'dwaplusjeden' ); ?></p>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $displayed_posts < $total_posts ) : ?>
				<div class="row mt-32 mt-sm-40 mt-lg-48">
					<div class="col-md-6 col-lg-4 col-xxxl-3 mx-auto">
						<button
							type="button"
							class="c-btn c-btn-s c-btn-outline w-100"
							data-blog-load-more
							data-target=".search-article [data-search-posts-grid]"
							data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
							data-nonce="<?php echo esc_attr( wp_create_nonce( 'dwaplusjeden_blog_load_more' ) ); ?>"
							data-offset="<?php echo esc_attr( $displayed_posts ); ?>"
							data-loading-label="<?php esc_attr_e( 'Ładowanie...', 'dwaplusjeden' ); ?>"
							data-search="<?php echo esc_attr( $search_query ); ?>"
						>
							<span><?php esc_html_e( 'Więcej artykułów', 'dwaplusjeden' ); ?></span>
						</button>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
