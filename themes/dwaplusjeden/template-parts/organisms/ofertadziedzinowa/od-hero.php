<?php
/**
 * Field offer hero.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );

if ( $has_acf && false === get_field( 'od_hero_enabled' ) ) {
	return;
}

$heading = $has_acf ? get_field( 'od_hero_heading' ) : '';
$text    = $has_acf ? get_field( 'od_hero_text' ) : '';
$link    = $has_acf ? dwaplusjeden_get_acf_link( 'od_hero_link', get_the_ID() ) : array();

$heading = $heading ?: 'Kadry i p&#322;ace bez komplikacji';
$text    = $text ?: 'Przejmujemy obowi&#261;zki dzia&#322;u kadr i p&#322;ac, dostosowuj&#261;c zakres wsp&#243;&#322;pracy do potrzeb klienta.';

$stats = array(
	array(
		'value'  => $has_acf ? get_field( 'od_hero_card_1_value' ) : '',
		'suffix' => $has_acf ? get_field( 'od_hero_card_1_suffix' ) : '',
		'label'  => $has_acf ? get_field( 'od_hero_card_1_label' ) : '',
	),
	array(
		'value'  => $has_acf ? get_field( 'od_hero_card_2_value' ) : '',
		'suffix' => $has_acf ? get_field( 'od_hero_card_2_suffix' ) : '',
		'label'  => $has_acf ? get_field( 'od_hero_card_2_label' ) : '',
	),
	array(
		'value'  => $has_acf ? get_field( 'od_hero_card_3_value' ) : '',
		'suffix' => $has_acf ? get_field( 'od_hero_card_3_suffix' ) : '',
		'label'  => $has_acf ? get_field( 'od_hero_card_3_label' ) : '',
	),
);

$stats[0]['value']  = '' !== (string) $stats[0]['value'] ? $stats[0]['value'] : 200;
$stats[0]['suffix'] = '' !== (string) $stats[0]['suffix'] ? $stats[0]['suffix'] : '+';
$stats[0]['label']  = $stats[0]['label'] ?: 'Projekt&#243;w kadrowo-p&#322;acowych';
$stats[1]['value']  = '' !== (string) $stats[1]['value'] ? $stats[1]['value'] : 100;
$stats[1]['suffix'] = '' !== (string) $stats[1]['suffix'] ? $stats[1]['suffix'] : '%';
$stats[1]['label']  = $stats[1]['label'] ?: 'Gwarancja bezpiecze&#324;stwa i poufno&#347;ci';
$stats[2]['value']  = '' !== (string) $stats[2]['value'] ? $stats[2]['value'] : 24;
$stats[2]['suffix'] = '' !== (string) $stats[2]['suffix'] ? $stats[2]['suffix'] : '/7';
$stats[2]['label']  = $stats[2]['label'] ?: 'Dost&#281;pno&#347;&#263; online';
?>

<section class="od-hero pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="od-hero-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="d-flex flex-column gap-8">
					<?php if ( $heading ) : ?>
						<h1 id="od-hero-heading" class="h5 fw-bolder c-body text-center"><?php echo wp_kses_post( $heading ); ?></h1>
					<?php endif; ?>
					<?php if ( $text ) : ?>
						<p class="p-m c-black text-center"><?php echo wp_kses_post( $text ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<?php if ( $stats ) : ?>
			<div class="row mt-32 mt-sm-40 mt-lg-48 mt-xxxl-64 r-gap-24 a-od-hero-sequence" data-animate-start="top 82%">
				<?php foreach ( $stats as $stat ) : ?>
					<?php
					$value  = isset( $stat['value'] ) ? (int) $stat['value'] : 0;
					$suffix = isset( $stat['suffix'] ) ? $stat['suffix'] : '';
					$label  = isset( $stat['label'] ) ? $stat['label'] : '';
					?>
					<div class="col-md-4 a-od-hero-card" style="opacity: 0;">
						<div class="od-hero-card">
							<div class="od-hero-card-wrapper">
								<span class="h2 fw-lighter c-body d-flex"><span data-sequence-counter data-target="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $value ); ?></span><?php echo esc_html( $suffix ); ?></span>
								<?php if ( $label ) : ?>
									<p class="p-m fw-bolder text-center"><?php echo wp_kses_post( $label ); ?></p>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $link['url'] ) ) : ?>
			<div class="row mt-56 mt-sm-64 mt-lg-96 mt-xxxl-132">
				<div class="col-md-6 col-lg-4 col-xxxl-3 mx-auto">
					<a<?php dwaplusjeden_link_attrs( $link ); ?> class="c-btn c-btn-s c-btn-fill w-100">
						<span><?php echo esc_html( $link['title'] ?: $link['url'] ); ?></span>
					</a>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
