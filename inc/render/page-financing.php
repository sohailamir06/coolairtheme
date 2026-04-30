<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_financing_page_content_defaults() {
	return [
		'hero' => [
			'crumb' => 'Financing',
			'title' => 'Financing Options',
			'subtitle' => "Cool comfort shouldn't wait. Our financing partners offer 0% APR promotions, low monthly payments, and instant online approval â€” so you can install today.",
			'badges' => [ '0% APR Available', 'No Down Payment', 'Quick Approval', 'All Credit Levels' ],
		],
		'section' => [
			'label' => 'Financing',
			'title' => 'Multiple Ways to Pay',
			'subtitle' => 'We work with multiple lending partners to find the right plan for your budget. Most installations qualify for 0% APR promotional financing.',
			'options' => [
				[ 'title' => '0% APR for 12 Months', 'description' => 'Zero interest if paid in full within 12 months on qualifying installs.' ],
				[ 'title' => '0% APR for 18 Months', 'description' => 'Zero interest if paid in full within 18 months on premium systems.' ],
				[ 'title' => 'Low Monthly Payments', 'description' => 'Spread the cost over 60â€“120 months with predictable monthly payments.' ],
				[ 'title' => 'No Down Payment', 'description' => 'Approved customers can install today with $0 down â€” financing handles the rest.' ],
				[ 'title' => 'Quick Online Approval', 'description' => 'Apply in minutes with no impact to your credit. Decisions in seconds.' ],
				[ 'title' => 'All Credit Levels', 'description' => 'Multiple lender partners means we can find an option that fits.' ],
			],
			'primary' => [ 'label' => 'Get Pre-Approved â†’', 'url' => home_url( '/contact/' ) ],
			'secondary' => [ 'label' => 'ðŸ“ž Call ' . ca_phone(), 'url' => 'tel:' . ca_phone_raw() ],
		],
		'emergency' => ca_emergency_content_defaults(),
	];
}

function ca_render_financing_page() {
	$content = ca_dynamic_content( 'financing', ca_financing_page_content_defaults() );
	$section = $content['section'];
	ob_start(); ?>
	<div class="ca-financing">
		<?php echo ca_page_hero( $content['hero']['crumb'], $content['hero']['title'], $content['hero']['subtitle'], $content['hero']['badges'] ); ?>

		<section class="content-section">
			<div class="content-in">
				<div class="reveal center">
					<div class="sec-label center"><?php echo wp_kses_post( $section['label'] ); ?></div>
					<h2 class="sec-title center"><?php echo wp_kses_post( $section['title'] ); ?></h2>
					<p class="sec-sub center mx-auto"><?php echo wp_kses_post( $section['subtitle'] ); ?></p>
				</div>
				<div class="benefit-cards reveal">
					<?php foreach ( $section['options'] as $i => $o ) : ?>
						<div class="benefit-card d<?php echo ( $i % 3 ) + 1; ?>">
							<div class="benefit-title"><?php echo esc_html( $o['title'] ); ?></div>
							<p class="benefit-desc"><?php echo esc_html( $o['description'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="cta-acts reveal mt-32">
					<a class="btn-green" href="<?php echo esc_url( $section['primary']['url'] ); ?>"><?php echo esc_html( $section['primary']['label'] ); ?></a>
					<a class="btn-green-call" href="<?php echo esc_url( $section['secondary']['url'] ); ?>"><?php echo esc_html( $section['secondary']['label'] ); ?></a>
				</div>
			</div>
		</section>

		<?php echo ca_section_emergency( 'financing' ); ?>
	</div>
	<?php
	return ob_get_clean();
}
