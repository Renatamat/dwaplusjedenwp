<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dwaplusjeden
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<section class="blank-header pt-32 pb-32 pt-sm-40 pb-sm-40 pt-lg-48 pb-lg-48 pt-xxxl-64 pb-xxxl-64">
		<div class="container">
			<div class="row">
				<div class="col-12 offset-xxxl-1 col-xxxl-10">
					<div class="d-flex flex-column gap-24 gap-lg-32">
						<?php the_title( '<h1 class="h6 c-body">', '</h1>' ); ?>
						<?php if ( has_excerpt() ) : ?>
							<p class="p-m c-body"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="blank-content pt-32 pb-56 pt-sm-40 pb-sm-64 pt-lg-48 pb-lg-96 pt-xxxl-56 pb-xxxl-132">
		<div class="container">
			<div class="row">
				<div class="offset-lg-2 col-lg-8">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="mb-32 mb-sm-40">
							<?php dwaplusjeden_post_thumbnail(); ?>
						</div>
					<?php endif; ?>

					<div class="blog-content">
						<?php
						the_content();

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Strony:', 'dwaplusjeden' ),
								'after'  => '</div>',
							)
						);
						?>
					</div>
				</div>
			</div>
		</div>
	</section>

</article><!-- #post-<?php the_ID(); ?> -->
