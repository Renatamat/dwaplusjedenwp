<?php
/**
 * Blog single content section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}
?>

<section class="blog-single-content pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132">
	<div class="container">
		<div class="row">
			<div class="col-12 offset-xxxl-1 col-xxxl-10">
				<div class="row r-gap-40 wrapper" data-float-sidebar-wrapper data-float-sidebar-top-spacing="120" data-float-sidebar-min-width="992">
					<div class="col-lg-4 sidebar" data-float-sidebar>
						<div class="sidebar__inner">
							<div class="d-flex flex-column gap-24 blog-single-contents" data-scroll-offset="120">
								<span class="p-m fw-bolder c-body"><?php esc_html_e( 'Spis treści', 'dwaplusjeden' ); ?></span>
								<ol></ol>
							</div>
						</div>
					</div>
					<div class="col-lg-8 content" data-float-sidebar-relative>
						<div class="blog-content">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
