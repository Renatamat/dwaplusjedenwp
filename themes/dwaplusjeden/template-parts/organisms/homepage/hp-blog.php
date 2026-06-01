<?php
/**
 * Homepage blog.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || ! get_field( 'homepage_blog_enabled' ) ) {
	return;
}

$heading    = get_field( 'homepage_blog_heading' );
$text       = get_field( 'homepage_blog_text' );
$image      = get_field( 'homepage_blog_image' );
$label      = get_field( 'homepage_blog_latest_label' );
$count      = get_field( 'homepage_blog_posts_count' ) ?: 4;
$archive    = dwaplusjeden_get_acf_link( 'homepage_blog_archive_link', get_the_ID() );
$read_more  = get_field( 'homepage_blog_read_more_label' ) ?: __( 'Dowiedz się więcej', 'dwaplusjeden' );
$blog_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => (int) $count,
		'ignore_sticky_posts' => true,
	)
);

if ( ! $blog_query->have_posts() ) {
	return;
}
?>

<section class="hp-blog pt-64 pb-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="homepage-blog-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="d-flex flex-column gap-24">
					<?php if ( $heading ) : ?>
						<h2 id="homepage-blog-heading" class="h5 fw-bolder c-body"><?php echo esc_html( $heading ); ?></h2>
					<?php endif; ?>
					<?php if ( $text ) : ?>
						<p class="p-m"><?php echo esc_html( $text ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="row mt-32 mt-lg-48">
			<div class="col-lg-6">
				<div class="hp-blog-image a-slide-left" data-animate-delay="0.12" data-animate-start="top 70%">
					<?php dwaplusjeden_image( $image, 'full', 'hpblog.jpg' ); ?>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="hp-blog-slider swiper" data-swiper data-swiper-options='{"slidesPerView": 2, "spaceBetween": 36, "breakpoints": {"576": {"spaceBetween": 40}, "992": {"spaceBetween": 48}}}'>
					<div class="d-flex w-100 justify-content-between">
						<?php if ( $label ) : ?>
							<span class="p-l fw-bolder c-body"><?php echo esc_html( $label ); ?></span>
						<?php endif; ?>
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
					<div class="hp-blog-slider-wrapper swiper-wrapper a-slide-up" data-animate-delay="0.32" data-animate-duraton="1.12">
						<?php while ( $blog_query->have_posts() ) : ?>
							<?php $blog_query->the_post(); ?>
							<article class="hp-blog-card swiper-slide">
								<div class="hp-blog-card-image">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'medium_large' ); ?>
									<?php else : ?>
										<?php dwaplusjeden_image( 0, 'medium_large', 'hpblog.jpg' ); ?>
									<?php endif; ?>
								</div>
								<div class="hp-blog-card-content">
									<h3 class="p-m fw-bolder hp-blog-card-title" title="<?php the_title_attribute(); ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<a href="<?php the_permalink(); ?>" class="c-btn c-btn-s c-btn-link">
										<?php echo esc_html( $read_more ); ?>
									</a>
								</div>
							</article>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		</div>

		<?php if ( ! empty( $archive['url'] ) ) : ?>
			<div class="row mt-32 mt-lg-48">
				<div class="col-sm-6 col-lg-4 col-xxxl-3 mx-auto">
					<a<?php dwaplusjeden_link_attrs( $archive ); ?> class="c-btn c-btn-s c-btn-outline w-100">
						<span><?php echo esc_html( $archive['title'] ?: $archive['url'] ); ?></span>
					</a>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
