<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_membership_page_content_defaults() {
	return [
		'hero' => [
			'crumb' => 'Membership',
			'title' => 'Membership Plans',
			'subtitle' => 'Year-round protection that pays for itself. Scheduled tune-ups, priority service, and member-only discounts on every job.',
			'badges' => [ '10â€“15% Repair Discount', 'Priority Scheduling', '30+ Day Warranty', 'No After-Hours Fees' ],
		],
		'plans' => [
			[
				'name' => 'Bi-Annual Plan',
				'price' => '$199',
				'period' => '/year',
				'tagline' => 'Two professional tune-ups per year â€” spring &amp; fall.',
				'flag' => '',
				'features' => [ '2 full A/C tune-ups (spring + fall)', '10% off all repairs &amp; services', 'Priority emergency scheduling', '30-day service warranty', 'No after-hours fees', 'Maintenance reminders' ],
				'button' => [ 'label' => 'Choose This Plan â†’', 'url' => home_url( '/contact/' ) ],
			],
			[
				'name' => 'Quarterly Plan',
				'price' => '$349',
				'period' => '/year',
				'tagline' => 'Four maintenance visits a year for ultimate protection.',
				'flag' => 'Most Popular',
				'features' => [ '4 full A/C tune-ups (one per quarter)', '15% off all repairs &amp; services', 'Top priority emergency scheduling', '90-day service warranty', 'No after-hours fees ever', 'Free annual coil cleaning', 'Free filter replacement' ],
				'button' => [ 'label' => 'Choose This Plan â†’', 'url' => home_url( '/contact/' ) ],
			],
		],
		'membership_cta' => ca_membership_cta_content_defaults(),
		'emergency' => ca_emergency_content_defaults(),
	];
}

function ca_render_membership_page() {
	$content = ca_dynamic_content( 'membership', ca_membership_page_content_defaults() );
	$plans   = $content['plans'];
	ob_start(); ?>
	<div class="ca-membership">
		<?php echo ca_page_hero( $content['hero']['crumb'], $content['hero']['title'], $content['hero']['subtitle'], $content['hero']['badges'] ); ?>

		<section class="content-section">
			<div class="content-in">
				<div class="membership-plans">
					<?php foreach ( $plans as $plan ) : ?>
						<div class="memb-plan-card<?php echo ! empty( $plan['flag'] ) ? ' is-featured' : ''; ?> reveal">
							<?php if ( ! empty( $plan['flag'] ) ) : ?>
								<div class="memb-plan-flag"><?php echo esc_html( $plan['flag'] ); ?></div>
							<?php endif; ?>
							<div class="memb-plan-name"><?php echo esc_html( $plan['name'] ); ?></div>
							<div class="memb-plan-price">
								<span class="memb-plan-price-val"><?php echo esc_html( $plan['price'] ); ?></span>
								<span class="memb-plan-period"><?php echo esc_html( $plan['period'] ); ?></span>
							</div>
							<p class="memb-plan-tag"><?php echo wp_kses_post( $plan['tagline'] ); ?></p>
							<ul class="bullets-list">
								<?php foreach ( $plan['features'] as $f ) : ?>
									<li><?php echo wp_kses_post( $f ); ?></li>
								<?php endforeach; ?>
							</ul>
							<a class="btn-green memb-plan-cta" href="<?php echo esc_url( $plan['button']['url'] ); ?>"><?php echo esc_html( $plan['button']['label'] ); ?></a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<?php echo ca_section_membership_cta( 'membership' ); ?>
		<?php echo ca_section_emergency( 'membership' ); ?>
	</div>
	<?php
	return ob_get_clean();
}
