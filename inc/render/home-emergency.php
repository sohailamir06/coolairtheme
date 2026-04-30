<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_emergency_content_defaults() {
	return [
		'watermark' => '24/7',
		'badge'     => 'Open 24/7/365 â€” Emergency Dispatch',
		'title'     => "A/C Down? Water Heater Out?<br><span class=\"emg-h2-red\">We're On The Way.</span>",
		'subtitle'  => "HVAC and plumbing emergencies don't keep business hours. We're open around the clock â€” real people answer your call and dispatch the nearest certified technician right away.",
		'scenarios' => [
			[ 'icon' => 'ðŸ”¥', 'label' => 'No A/C or Heat' ],
			[ 'icon' => 'ðŸ’§', 'label' => 'Water Heater Failure' ],
			[ 'icon' => 'â„ï¸', 'label' => 'Frozen Coils / Lines' ],
			[ 'icon' => 'ðŸš¨', 'label' => 'Total System Failure' ],
			[ 'icon' => 'ðŸš¿', 'label' => 'Drain Backup' ],
			[ 'icon' => 'âš¡', 'label' => 'Electrical Failure' ],
		],
		'primary'   => [ 'label' => 'ðŸ“ž ' . ca_phone(), 'url' => 'tel:' . ca_phone_raw() ],
		'stats'     => [
			[ 'value' => '24/7', 'label' => 'Always Open' ],
			[ 'value' => 'â‰¤60 min', 'label' => 'Avg Response' ],
			[ 'value' => '1 Year', 'label' => 'Repair Warranty' ],
			[ 'value' => 'Real People', 'label' => 'Not Machines' ],
		],
	];
}

function ca_section_emergency( $content_key = 'home' ) {
	if ( $content_key === 'home' ) {
		$page_content = ca_home_content();
	} else {
		$page_content = ca_dynamic_content( $content_key, ca_dynamic_defaults_for_post( ca_dynamic_current_post_id() ) );
	}

	$section    = $page_content['emergency'] ?? ca_emergency_content_defaults();
	$scenarios  = $section['scenarios'];
	$mini_stats = $section['stats'];
	ob_start(); ?>
	<div class="emg-enhanced">
		<div class="emg-watermark"><?php echo esc_html( $section['watermark'] ); ?></div>
		<div class="emg-inner">
			<div class="emg-left">
				<div class="emg-live-badge">
					<span class="emg-live-dot"></span>
					<span class="emg-live-text"><?php echo wp_kses_post( $section['badge'] ); ?></span>
				</div>
				<h2 class="emg-h2"><?php echo wp_kses_post( $section['title'] ); ?></h2>
				<p class="emg-sub"><?php echo wp_kses_post( $section['subtitle'] ); ?></p>
				<div class="emg-scenarios">
					<?php foreach ( $scenarios as $sc ) : ?>
						<div class="emg-scenario"><span><?php echo wp_kses_post( $sc['icon'] ); ?></span><?php echo esc_html( $sc['label'] ); ?></div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="emg-right">
				<a class="btn-red emg-call" href="<?php echo esc_url( $section['primary']['url'] ); ?>"><?php echo esc_html( $section['primary']['label'] ); ?></a>
				<div class="emg-mini-grid">
					<?php foreach ( $mini_stats as $s ) : ?>
						<div class="emg-stat-mini">
							<div class="emg-stat-mini-val"><?php echo esc_html( $s['value'] ); ?></div>
							<div class="emg-stat-mini-lbl"><?php echo esc_html( $s['label'] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
