<?php
/**
 * Blank page header.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$show_modified_date = isset( $args['show_modified_date'] ) ? (bool) $args['show_modified_date'] : true;
?>

<section class="blank-header pt-32 pb-32 pt-sm-40 pb-sm-40 pt-lg-48 pb-lg-48 pt-xxxl-64 pb-xxxl-64">
	<div class="container">
		<div class="row">
			<div class="col-12 offset-xxxl-1 col-xxxl-10">
				<div class="d-flex flex-column gap-48">
					<h1 class="h6 c-body"><?php the_title(); ?></h1>
					<?php if ( $show_modified_date ) : ?>
						<div class="blog-single-title-meta">
							<div class="d-flex gap-8 align-items-center c-body">
								<svg class="i-sprite icon-16" aria-hidden="true" focusable="false">
									<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#calendar"></use>
								</svg>
								<span class="p-xs"><?php echo esc_html( sprintf( __( 'Ostatnia aktualizacja: %s', 'dwaplusjeden' ), get_the_modified_date() ) ); ?></span>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
