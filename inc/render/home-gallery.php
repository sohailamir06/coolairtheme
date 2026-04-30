<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_gallery_content_defaults() {
	return [
		[ 'category' => 'AC Install', 'title' => 'Trane 4-Ton High-Efficiency System', 'city' => 'Boca Raton', 'county' => 'Palm Beach', 'color' => '#22c55e' ],
		[ 'category' => 'Duct Cleaning', 'title' => 'Whole-Home NADCA Cleaning', 'city' => 'Coral Gables', 'county' => 'Miami-Dade', 'color' => '#f59e0b' ],
		[ 'category' => 'AC Repair', 'title' => 'Compressor Replacement Same Day', 'city' => 'Fort Lauderdale', 'county' => 'Broward', 'color' => '#0ea5e9' ],
		[ 'category' => 'Plumbing', 'title' => 'Tankless Water Heater Install', 'city' => 'Pembroke Pines', 'county' => 'Broward', 'color' => '#06b6d4' ],
		[ 'category' => 'Commercial', 'title' => 'Rooftop Unit Crane Service', 'city' => 'Miami', 'county' => 'Miami-Dade', 'color' => '#8b5cf6' ],
		[ 'category' => 'AC Maintenance', 'title' => 'Annual Tune-Up Membership', 'city' => 'Wellington', 'county' => 'Palm Beach', 'color' => '#3b82f6' ],
		[ 'category' => 'UV Lights', 'title' => 'Hospital-Grade UV-C Installation', 'city' => 'Aventura', 'county' => 'Miami-Dade', 'color' => '#06b6d4' ],
		[ 'category' => 'Duct Repair', 'title' => 'Mastic Sealing & Section Replacement', 'city' => 'Davie', 'county' => 'Broward', 'color' => '#f59e0b' ],
		[ 'category' => 'AC Install', 'title' => 'Daikin Variable-Speed System', 'city' => 'Delray Beach', 'county' => 'Palm Beach', 'color' => '#22c55e' ],
		[ 'category' => 'Air Purifier', 'title' => 'Whole-Home HEPA Filtration', 'city' => 'Hollywood', 'county' => 'Broward', 'color' => '#06b6d4' ],
		[ 'category' => 'Thermostat', 'title' => 'Smart Multi-Zone Setup', 'city' => 'Doral', 'county' => 'Miami-Dade', 'color' => '#3b82f6' ],
		[ 'category' => 'Emergency', 'title' => '11pm Burst Pipe Repair', 'city' => 'Coral Springs', 'county' => 'Broward', 'color' => '#ef4444' ],
	];
}

function ca_section_work_gallery() {
	$content  = ca_home_content();
	$section  = $content['gallery'];
	$projects = $section['projects'];
	ob_start(); ?>
	<section class="section gallery-section">
		<div class="sec-in">
			<div class="reveal gallery-head">
				<div class="sec-label"><?php echo wp_kses_post( $section['label'] ); ?></div>
				<h2 class="sec-title"><?php echo wp_kses_post( $section['title'] ); ?></h2>
				<p class="sec-sub"><?php echo wp_kses_post( $section['subtitle'] ); ?></p>
			</div>
			<div class="gallery-stage" data-gallery>
				<button class="gallery-arrow gallery-arrow-l" aria-label="Previous">â€¹</button>
				<div class="gallery-track" data-gallery-track>
					<?php foreach ( $projects as $i => $p ) : ?>
						<div class="gallery-card" data-gallery-card="<?php echo $i; ?>" style="--g-color: <?php echo esc_attr( $p['color'] ); ?>;">
							<div class="gallery-card-cat"><?php echo esc_html( $p['category'] ); ?></div>
							<h4 class="gallery-card-title"><?php echo esc_html( $p['title'] ); ?></h4>
							<div class="gallery-card-loc"><?php echo esc_html( $p['city'] ); ?> Â· <?php echo esc_html( $p['county'] ); ?> County</div>
							<div class="gallery-card-foot">Project <?php echo str_pad( $i + 1, 2, '0', STR_PAD_LEFT ); ?> / <?php echo count( $projects ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
				<button class="gallery-arrow gallery-arrow-r" aria-label="Next">â€º</button>
				<div class="gallery-dots" data-gallery-dots>
					<?php for ( $i = 0; $i < count( $projects ); $i++ ) : ?>
						<button class="gallery-dot<?php echo $i === 0 ? ' active' : ''; ?>" aria-label="Project <?php echo $i + 1; ?>"></button>
					<?php endfor; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
