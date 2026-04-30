<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_service_areas_page_content_defaults() {
	return [
		'hero' => [
			'crumb' => 'Service Areas',
			'title' => 'Service Areas Across South Florida',
			'subtitle' => 'We serve over 80 cities across Miami-Dade, Broward, and Palm Beach counties. Same-day service throughout our entire coverage area, 24/7 emergency dispatch.',
			'badges' => [ '80+ Cities', '3 Counties', 'Same-Day Service', '24/7 Dispatch' ],
		],
		'counties' => ca_counties_content_defaults(),
		'cta' => [
			'primary' => [ 'label' => 'Schedule Service â†’', 'url' => home_url( '/contact/' ) ],
			'secondary' => [ 'label' => 'ðŸ“ž Call ' . ca_phone(), 'url' => 'tel:' . ca_phone_raw() ],
		],
		'emergency' => ca_emergency_content_defaults(),
	];
}

function ca_render_service_areas_page() {
	$content  = ca_dynamic_content( 'service-areas', ca_service_areas_page_content_defaults() );
	$counties = $content['counties'];
	ob_start(); ?>
	<div class="ca-service-areas">
		<?php echo ca_page_hero( $content['hero']['crumb'], $content['hero']['title'], $content['hero']['subtitle'], $content['hero']['badges'] ); ?>

		<section class="content-section">
			<div class="content-in">
				<div class="counties-grid">
					<?php foreach ( $counties as $c ) : ?>
						<div class="counties-block reveal">
							<div class="counties-block-name"><?php echo esc_html( $c['name'] ); ?> County</div>
							<div class="counties-block-count"><?php echo count( $c['cities'] ); ?>+ Cities Served</div>
							<div class="counties-cities">
								<?php foreach ( $c['cities'] as $city ) : ?>
									<a class="county-city" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( $city ); ?></a>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="cta-acts mt-32 center">
					<a class="btn-green" href="<?php echo esc_url( $content['cta']['primary']['url'] ); ?>"><?php echo esc_html( $content['cta']['primary']['label'] ); ?></a>
					<a class="btn-green-call" href="<?php echo esc_url( $content['cta']['secondary']['url'] ); ?>"><?php echo esc_html( $content['cta']['secondary']['label'] ); ?></a>
				</div>
			</div>
		</section>

		<?php echo ca_section_emergency( 'service-areas' ); ?>
	</div>
	<?php
	return ob_get_clean();
}
