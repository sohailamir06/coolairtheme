<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_membership_cta_content_defaults() {
	return [
		'label'    => 'Membership Plans',
		'title'    => 'Protect Your A/C Year-Round',
		'subtitle' => 'Scheduled tune-ups, priority scheduling, and 10% off all repairs â€” because prevention is always cheaper than emergency repairs.',
		'perks'    => [
			'Priority Emergency Scheduling',
			'10% Off All Repairs & Services',
			'Scheduled Maintenance Reminders',
			'Open 24/7 â€” Always Here',
			'30-Day Service Warranty',
		],
		'primary'  => [ 'label' => 'View Membership Plans â†’', 'url' => home_url( '/membership/' ) ],
	];
}

function ca_section_membership_cta( $content_key = 'home' ) {
	$page_content = $content_key === 'home' ? ca_home_content() : ca_dynamic_content( $content_key, ca_dynamic_defaults_for_post( ca_dynamic_current_post_id() ) );
	$section      = $page_content['membership_cta'] ?? ca_membership_cta_content_defaults();
	$perks        = $section['perks'];
	ob_start(); ?>
	<div class="memb-band">
		<div class="sec-in">
			<div class="reveal">
				<div class="sec-label memb-label"><?php echo wp_kses_post( $section['label'] ); ?></div>
				<h2 class="sec-title light center"><?php echo wp_kses_post( $section['title'] ); ?></h2>
				<p class="sec-sub light center"><?php echo wp_kses_post( $section['subtitle'] ); ?></p>
			</div>
			<div class="memb-perks reveal">
				<?php foreach ( $perks as $p ) : ?>
					<div class="memb-perk"><span class="memb-perk-chk">âœ“</span><?php echo esc_html( $p ); ?></div>
				<?php endforeach; ?>
			</div>
			<div class="memb-cta">
				<a class="btn-white" href="<?php echo esc_url( $section['primary']['url'] ); ?>"><?php echo esc_html( $section['primary']['label'] ); ?></a>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
