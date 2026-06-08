<?php
/**
 * Blog single latest posts section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$latest_posts = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 6,
		'post__not_in'        => array( get_the_ID() ),
		'ignore_sticky_posts' => true,
	)
);

if ( ! $latest_posts->have_posts() ) {
	return;
}
?>

<section class="blog-single-more pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132">
	<div class="container">
		<div class="row">
			<h2 class="h6 fw-bolder c-body text-center w-100"><?php esc_html_e( 'Podobne artykuły', 'dwaplusjeden' ); ?></h2>
		</div>
		<div class="row mt-96">
			<div class="col-12 offset-xxxl-1 col-xxxl-10">
				<div
					class="blog-single-more-slider swiper"
					data-swiper
					data-swiper-options='{"slidesPerView":"auto","centeredSlides":true,"spaceBetween":16,"breakpoints":{"576":{"spaceBetween":24},"1200":{"slidesPerView":3,"centeredSlides":false,"freeMode":false,"spaceBetween":24}}}'
				>
					<div class="swiper-wrapper a-card-sequence" data-animate-start="top 90%" data-animate-batch-max="3">
						<?php while ( $latest_posts->have_posts() ) : ?>
							<?php $latest_posts->the_post(); ?>
							<?php get_template_part( 'template-parts/organisms/blog/blog-card', null, array( 'post_id' => get_the_ID(), 'class' => 'swiper-slide a-card-item' ) ); ?>
						<?php endwhile; ?>
					</div>
					<div class="swiper-pagination"></div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
wp_reset_postdata();
