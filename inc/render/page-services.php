<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_services_page_content_defaults() {
	return [
		'hero' => [
			'crumb' => 'Services',
			'title' => 'HVAC & Plumbing Services',
			'subtitle' => 'Complete home comfort services from one trusted South Florida team.',
			'badges' => [ 'Same-Day Service', '24/7 Emergency', 'Licensed & Insured', 'Flat-Rate Pricing' ],
		],
		'services' => ca_home_content_defaults()['services'],
	];
}

function ca_render_services_page() {
	$content = ca_dynamic_content( 'services', ca_services_page_content_defaults() );
	$section = $content['services'];
	ob_start(); ?>
	<div class="ca-services-page">
		<?php echo ca_page_hero( $content['hero']['crumb'], $content['hero']['title'], $content['hero']['subtitle'], $content['hero']['badges'] ); ?>
		<section class="section svcs-section">
			<div class="sec-in">
				<div class="reveal">
					<div class="sec-label"><?php echo wp_kses_post( $section['label'] ); ?></div>
					<h2 class="sec-title"><?php echo wp_kses_post( $section['title'] ); ?></h2>
					<p class="sec-sub"><?php echo wp_kses_post( $section['subtitle'] ); ?></p>
				</div>
				<div class="svcs-grid">
					<?php foreach ( $section['items'] as $i => $s ) : ?>
						<a class="svc-card-mod reveal d<?php echo ( $i % 4 ) + 1; ?>" href="<?php echo esc_url( home_url( '/services/' . $s['slug'] . '/' ) ); ?>" style="--svc-color: <?php echo esc_attr( $s['color'] ); ?>;">
							<div class="svc-cat"><?php echo esc_html( $s['category'] ); ?></div>
							<div class="svc-name"><?php echo esc_html( $s['name'] ); ?></div>
							<p class="svc-desc"><?php echo esc_html( $s['description'] ); ?></p>
							<div class="svc-link">Learn More â†’</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	</div>
	<?php
	return ob_get_clean();
}

