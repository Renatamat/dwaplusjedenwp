<?php
/**
 * Latest blog posts section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$latest_args = array(
	'post_type'           => 'post',
	'posts_per_page'      => 5,
	'ignore_sticky_posts' => true,
);

if ( is_category() ) {
	$latest_args['cat'] = (int) get_queried_object_id();
}

$latest_query = new WP_Query( $latest_args );

if ( ! $latest_query->have_posts() ) {
	return;
}

$latest_posts = $latest_query->posts;
$featured     = array_shift( $latest_posts );
?>

<section class="blog-new pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132">
	<div class="container">
		<div class="row">
			<div class="offset-xxxl-1 col-lg-6 col-xxxl-5">
				<article class="blog-new-first a-slide-left" data-animate-delay="0.12" data-animate-start="top 80%">
					<div class="blog-new-first-image">
						<?php if ( has_post_thumbnail( $featured ) ) : ?>
							<?php echo get_the_post_thumbnail( $featured, 'large' ); ?>
						<?php else : ?>
							<?php dwaplusjeden_image( 0, 'large', 'hpblog.jpg' ); ?>
						<?php endif; ?>
					</div>
					<div class="d-flex flex-column gap-24 mt-32">
						<div class="d-flex flex-column gap-8">
							<h2 class="p-l fw-bolder c-body blog-new-first-title">
								<a href="<?php echo esc_url( get_permalink( $featured ) ); ?>"><?php echo esc_html( get_the_title( $featured ) ); ?></a>
							</h2>
							<?php if ( get_the_excerpt( $featured ) ) : ?>
								<p class="p-m c-body blog-new-first-desc"><?php echo esc_html( get_the_excerpt( $featured ) ); ?></p>
							<?php endif; ?>
						</div>
						<a href="<?php echo esc_url( get_permalink( $featured ) ); ?>" class="c-btn c-btn-s c-btn-link"><?php esc_html_e( 'Dowiedz się więcej', 'dwaplusjeden' ); ?></a>
					</div>
				</article>
			</div>

			<?php if ( $latest_posts ) : ?>
				<div class="col-lg-6 col-xxxl-5">
					<div
						class="hp-blog-slider swiper a-slide-up"
						data-animate-delay="0.32"
						data-animate-duraton="1.12"
						data-swiper
						data-swiper-options='{"slidesPerView": 2, "spaceBetween": 36, "breakpoints": {"576": {"spaceBetween": 40}, "992": {"spaceBetween": 48}}}'
					>
						<div class="d-flex w-100 justify-content-between">
							<span class="p-l fw-bolder c-body"><?php esc_html_e( 'Najnowsze artykuły', 'dwaplusjeden' ); ?></span>
							<div class="d-flex gap-16">
								<button class="c-btn c-btn-text c-btn-icon c-btn-icon-l swiper-button-prev" type="button" aria-label="<?php esc_attr_e( 'Poprzedni artykuł', 'dwaplusjeden' ); ?>">
									<svg class="i-sprite icon-20" aria-hidden="true" focusable="false">
										<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-20.svg' ) ); ?>#chevron_left"></use>
									</svg>
								</button>
								<button class="c-btn c-btn-text c-btn-icon c-btn-icon-l swiper-button-next" type="button" aria-label="<?php esc_attr_e( 'Następny artykuł', 'dwaplusjeden' ); ?>">
									<svg class="i-sprite icon-20" aria-hidden="true" focusable="false">
										<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-20.svg' ) ); ?>#chevron_right"></use>
									</svg>
								</button>
							</div>
						</div>
						<div class="hp-blog-slider-wrapper swiper-wrapper">
							<?php foreach ( $latest_posts as $post_item ) : ?>
								<article class="hp-blog-card swiper-slide">
									<div class="hp-blog-card-image">
										<?php if ( has_post_thumbnail( $post_item ) ) : ?>
											<?php echo get_the_post_thumbnail( $post_item, 'medium_large' ); ?>
										<?php else : ?>
											<?php dwaplusjeden_image( 0, 'medium_large', 'hpblog.jpg' ); ?>
										<?php endif; ?>
									</div>
									<div class="hp-blog-card-content">
										<h3 class="p-m fw-bolder hp-blog-card-title" title="<?php echo esc_attr( get_the_title( $post_item ) ); ?>">
											<a href="<?php echo esc_url( get_permalink( $post_item ) ); ?>"><?php echo esc_html( get_the_title( $post_item ) ); ?></a>
										</h3>
										<a href="<?php echo esc_url( get_permalink( $post_item ) ); ?>" class="c-btn c-btn-s c-btn-link">
											<?php esc_html_e( 'Dowiedz się więcej', 'dwaplusjeden' ); ?>
										</a>
									</div>
								</article>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php wp_reset_postdata(); ?>
