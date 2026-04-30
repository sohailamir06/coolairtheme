<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_brands_page_content_defaults() {
	return [
		'hero' => [
			'crumb' => 'Brands',
			'title' => 'Brands We Service',
			'subtitle' => 'Cool Air USA is factory certified on every major HVAC and plumbing brand in South Florida. We service equipment from 24+ manufacturers â€” both legacy and the latest variable-speed systems.',
			'badges' => [ 'Factory Certified', 'OEM Parts', 'All Major Brands', '24+ Manufacturers' ],
		],
		'section' => [
			'label' => 'All Brands',
			'title' => 'Every Brand In One Trusted Team',
			'items' => ca_brands(),
			'primary' => [ 'label' => 'Schedule Service â†’', 'url' => home_url( '/contact/' ) ],
			'secondary' => [ 'label' => 'ðŸ“ž Call ' . ca_phone(), 'url' => 'tel:' . ca_phone_raw() ],
		],
		'emergency' => ca_emergency_content_defaults(),
	];
}

function ca_render_brands_page() {
	$content = ca_dynamic_content( 'brands', ca_brands_page_content_defaults() );
	$section = $content['section'];
	ob_start(); ?>
	<div class="ca-brands">
		<?php echo ca_page_hero( $content['hero']['crumb'], $content['hero']['title'], $content['hero']['subtitle'], $content['hero']['badges'] ); ?>

		<section class="content-section">
			<div class="content-in">
				<div class="reveal center">
					<div class="sec-label center"><?php echo wp_kses_post( $section['label'] ); ?></div>
					<h2 class="sec-title center"><?php echo wp_kses_post( $section['title'] ); ?></h2>
				</div>
				<div class="brands-page-grid">
					<?php foreach ( $section['items'] as $b ) : ?>
						<div class="brand-card"><?php echo esc_html( $b ); ?></div>
					<?php endforeach; ?>
				</div>
				<div class="cta-acts mt-32">
					<a class="btn-green" href="<?php echo esc_url( $section['primary']['url'] ); ?>"><?php echo esc_html( $section['primary']['label'] ); ?></a>
					<a class="btn-green-call" href="<?php echo esc_url( $section['secondary']['url'] ); ?>"><?php echo esc_html( $section['secondary']['label'] ); ?></a>
				</div>
			</div>
		</section>

		<?php echo ca_section_emergency( 'brands' ); ?>
	</div>
	<?php
	return ob_get_clean();
}
