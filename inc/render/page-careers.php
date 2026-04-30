<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_careers_page_content_defaults() {
	return [
		'hero' => [
			'crumb' => 'Careers',
			'title' => 'Join the Cool Air Family',
			'subtitle' => 'We hire people, not just resumes. If you take pride in your work and treat every customer right, we want you on the team.',
			'badges' => [ 'Full Benefits', 'Paid Training', 'Take-Home Truck', 'Family-Owned' ],
		],
		'jobs_section' => [
			'label' => 'Open Positions',
			'title' => "We're Hiring",
			'jobs' => [
				[ 'title' => 'HVAC Service Technician', 'meta' => 'Full-time Â· Fort Lauderdale', 'description' => 'NATE-certified or equivalent. 3+ years residential service experience.', 'button' => [ 'label' => 'Apply â†’', 'url' => home_url( '/contact/' ) ] ],
				[ 'title' => 'Installation Technician', 'meta' => 'Full-time Â· Broward County', 'description' => 'EPA 608 required. New install &amp; replacement experience preferred.', 'button' => [ 'label' => 'Apply â†’', 'url' => home_url( '/contact/' ) ] ],
				[ 'title' => 'Plumber (Journeyman)', 'meta' => 'Full-time Â· South Florida', 'description' => 'FL Journeyman license. Residential and light commercial experience.', 'button' => [ 'label' => 'Apply â†’', 'url' => home_url( '/contact/' ) ] ],
				[ 'title' => 'Customer Care Agent', 'meta' => 'Full-time Â· Fort Lauderdale', 'description' => 'Real-people answering. Friendly voice, fast typing, problem-solver mindset.', 'button' => [ 'label' => 'Apply â†’', 'url' => home_url( '/contact/' ) ] ],
				[ 'title' => 'Comfort Specialist (Sales)', 'meta' => 'Full-time Â· Field-based', 'description' => 'Help homeowners pick the right system. Salary plus performance bonuses.', 'button' => [ 'label' => 'Apply â†’', 'url' => home_url( '/contact/' ) ] ],
			],
		],
		'perks_section' => [
			'label' => 'Why Cool Air',
			'title' => 'Benefits &amp; Culture',
			'perks' => [
				[ 'icon' => 'ðŸ¥', 'title' => 'Health Coverage', 'description' => 'Medical, dental, and vision benefits for full-time employees.' ],
				[ 'icon' => 'ðŸ’°', 'title' => 'Paid Training', 'description' => 'Continuous training on every major brand. We invest in our team.' ],
				[ 'icon' => 'ðŸ“ˆ', 'title' => '401(k) Match', 'description' => 'Company matches contributions up to 4% of your salary.' ],
				[ 'icon' => 'ðŸŒ´', 'title' => 'Paid Time Off', 'description' => 'Vacation, sick days, and major holidays â€” paid.' ],
				[ 'icon' => 'ðŸš', 'title' => 'Take-Home Truck', 'description' => 'Service techs get a fully stocked van â€” no more starting at the shop.' ],
				[ 'icon' => 'ðŸ‘¨â€ðŸ‘©â€ðŸ‘§', 'title' => 'Family Culture', 'description' => 'We treat our team like family. Real growth, real respect, real opportunity.' ],
			],
		],
	];
}

function ca_render_careers_page() {
	$content = ca_dynamic_content( 'careers', ca_careers_page_content_defaults() );
	$jobs    = $content['jobs_section'];
	$perks   = $content['perks_section'];
	ob_start(); ?>
	<div class="ca-careers">
		<?php echo ca_page_hero( $content['hero']['crumb'], $content['hero']['title'], $content['hero']['subtitle'], $content['hero']['badges'] ); ?>

		<section class="content-section">
			<div class="content-in">
				<div class="reveal center">
					<div class="sec-label center"><?php echo wp_kses_post( $jobs['label'] ); ?></div>
					<h2 class="sec-title center"><?php echo wp_kses_post( $jobs['title'] ); ?></h2>
				</div>
				<div class="jobs-list reveal">
					<?php foreach ( $jobs['jobs'] as $j ) : ?>
						<div class="job-card">
							<div>
								<div class="job-title"><?php echo esc_html( $j['title'] ); ?></div>
								<div class="job-meta"><?php echo esc_html( $j['meta'] ); ?></div>
								<p class="job-desc"><?php echo wp_kses_post( $j['description'] ); ?></p>
							</div>
							<a class="btn-green" href="<?php echo esc_url( $j['button']['url'] ); ?>"><?php echo esc_html( $j['button']['label'] ); ?></a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="content-section off">
			<div class="content-in">
				<div class="reveal center">
					<div class="sec-label center"><?php echo wp_kses_post( $perks['label'] ); ?></div>
					<h2 class="sec-title center"><?php echo wp_kses_post( $perks['title'] ); ?></h2>
				</div>
				<div class="benefit-cards">
					<?php foreach ( $perks['perks'] as $i => $p ) : ?>
						<div class="benefit-card reveal d<?php echo ( $i % 3 ) + 1; ?>">
							<div class="benefit-icon"><?php echo wp_kses_post( $p['icon'] ); ?></div>
							<div class="benefit-title"><?php echo esc_html( $p['title'] ); ?></div>
							<p class="benefit-desc"><?php echo esc_html( $p['description'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	</div>
	<?php
	return ob_get_clean();
}
