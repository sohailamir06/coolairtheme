<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_counties_content_defaults() {
	$counties = [];
	foreach ( ca_counties() as $slug => $county ) {
		$counties[ $slug ] = [
			'name'   => $county['name'],
			'icon'   => $slug === 'palm-beach' ? 'ðŸŒ´' : ( $slug === 'broward' ? 'ðŸ–ï¸' : 'ðŸŒ†' ),
			'cities' => $county['cities'],
		];
	}
	return $counties;
}

function ca_section_service_areas_map() {
	$content = ca_home_content();
	$section = $content['map'];
	$counties = $section['counties'];
	ob_start(); ?>
	<section class="section map-section">
		<div class="sec-in">
			<div class="reveal map-head">
				<div class="sec-label"><?php echo wp_kses_post( $section['label'] ); ?></div>
				<h2 class="sec-title light"><?php echo wp_kses_post( $section['title'] ); ?></h2>
				<p class="sec-sub light"><?php echo wp_kses_post( $section['subtitle'] ); ?></p>
			</div>
			<div class="reveal county-cards">
				<?php foreach ( $counties as $slug => $county ) : ?>
					<div class="county-card" data-county="<?php echo esc_attr( $slug ); ?>">
						<div class="county-card-icon"><?php echo wp_kses_post( $county['icon'] ); ?></div>
						<div class="county-card-name"><?php echo esc_html( $county['name'] ); ?> County</div>
						<div class="county-card-cities">
							<?php echo esc_html( implode( ' Â· ', array_slice( $county['cities'], 0, 4 ) ) ); ?>
							<?php if ( count( $county['cities'] ) > 4 ) : ?>
								<span class="county-card-more">+ <?php echo count( $county['cities'] ) - 4; ?> more</span>
							<?php endif; ?>
						</div>
						<a class="county-card-link" href="<?php echo esc_url( home_url( '/service-areas/' ) ); ?>">View All <?php echo esc_html( $county['name'] ); ?> Cities â†’</a>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="reveal map-cta-wrap">
				<a class="btn-green" href="<?php echo esc_url( $section['primary']['url'] ); ?>"><?php echo esc_html( $section['primary']['label'] ); ?></a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
