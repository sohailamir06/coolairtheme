<?php
if ( ! defined( 'ABSPATH' ) ) exit;

require_once CA_THEME_DIR . '/inc/render/home-hero.php';
require_once CA_THEME_DIR . '/inc/render/home-stats.php';
require_once CA_THEME_DIR . '/inc/render/home-services.php';
require_once CA_THEME_DIR . '/inc/render/home-why.php';
require_once CA_THEME_DIR . '/inc/render/home-reviews.php';
require_once CA_THEME_DIR . '/inc/render/home-process.php';
require_once CA_THEME_DIR . '/inc/render/home-brands.php';
require_once CA_THEME_DIR . '/inc/render/home-map.php';
require_once CA_THEME_DIR . '/inc/render/home-membership.php';
require_once CA_THEME_DIR . '/inc/render/home-gallery.php';
require_once CA_THEME_DIR . '/inc/render/home-emergency.php';
require_once CA_THEME_DIR . '/inc/render/site-header.php';
require_once CA_THEME_DIR . '/inc/render/site-footer.php';

function ca_home_content_defaults() {
	return [
		'hero' => [
			'eyebrow'     => 'Your Neighbors. Not a Franchise. Since 2009.',
			'title_html'  => '<em>HVAC &amp;</em><br><em>Plumbing</em><br>Experts<br>You Can<br>Trust',
			'subtitle'    => "Honest pricing, same-day service, and a team that treats your home like their own. South Florida's most trusted HVAC and plumbing company â€” Open 24/7, 365 days a year.",
			'primary'     => [ 'label' => 'Schedule Service â†’', 'url' => home_url( '/contact/' ) ],
			'secondary'   => [ 'label' => 'ðŸ“ž ' . ca_phone(), 'url' => 'tel:' . ca_phone_raw() ],
			'checks'      => [ 'Licensed & Insured', '4.9â˜… Â· 4,600+ Reviews', 'Same-Day Service', '1-Year Warranty' ],
			'badges'      => [
				[ 'value' => '250K+', 'label' => 'Customers Served' ],
				[ 'value' => '4.9â˜…', 'label' => 'Google Rating' ],
				[ 'value' => '17+', 'label' => 'Years Family-Owned & Operated' ],
				[ 'value' => '24/7', 'label' => 'Always Open For You' ],
			],
			'rating'      => [ 'score' => '4.9', 'stars' => 'â˜…â˜…â˜…â˜…â˜…', 'text' => 'Based on 4,600+ Google reviews', 'link_label' => 'Read All â†’', 'link_url' => '#reviews' ],
			'scroll_text' => 'Scroll',
		],
		'stats' => [
			'sets' => [
				[ [ 'value' => '250,000+', 'label' => 'Lifetime Customers' ], [ 'value' => '4,600+', 'label' => '5-Star Google Reviews' ], [ 'value' => '17+', 'label' => 'Years Family Owned & Operated' ], [ 'value' => '100+', 'label' => 'Cities Served' ] ],
				[ [ 'value' => '38,000+', 'label' => 'Service Calls / Year' ], [ 'value' => '23,000+', 'label' => 'Installs Completed' ], [ 'value' => '24/7', 'label' => 'Real People Answering' ], [ 'value' => '365', 'label' => 'Days Open Each Year' ] ],
				[ [ 'value' => '99%', 'label' => 'Same-Day Service Rate' ], [ 'value' => '1-Yr', 'label' => 'Warranty on All Work' ], [ 'value' => '0', 'label' => 'Hidden Fees Â· Ever' ], [ 'value' => '100%', 'label' => 'Licensed & Insured' ] ],
			],
		],
		'family' => [
			'eyebrow' => 'Family Owned &amp; Operated',
			'title'   => 'Your Neighbors.<br>Not a Franchise.',
			'quote'   => '"From our Fort Lauderdale home, we\'ve built this company on honesty and family values â€” treating every customer the way we\'d want our own family treated."',
			'pills'   => [ 'Local Team', 'South Florida Born & Raised', 'Community First' ],
			'stats'   => [
				[ 'value' => '2009', 'label' => 'Founded in Fort Lauderdale, FL' ],
				[ 'value' => 'Local', 'label' => 'In-House Team, Not Outsourced' ],
				[ 'value' => 'Family', 'label' => 'Values Behind Every Service Call' ],
			],
		],
		'services' => [
			'label'    => 'HVAC &amp; Plumbing Services',
			'title'    => 'Everything Your Home Needs',
			'subtitle' => 'From emergency A/C repairs to full system installs, duct work, air quality, and licensed plumbing â€” all under one trusted, family-owned and operated roof.',
			'items'    => [
				[ 'category' => 'HVAC', 'name' => 'AC Repair', 'description' => 'Same-day repairs on all A/C systems. Flat-rate pricing, manufacturer parts, 1-year warranty.', 'slug' => 'ac-repair', 'color' => '#0ea5e9' ],
				[ 'category' => 'HVAC', 'name' => 'AC Installation', 'description' => 'Free estimates, city permits, all top brands. 1-year labor + up to 10-year parts warranty.', 'slug' => 'ac-install', 'color' => '#22c55e' ],
				[ 'category' => 'HVAC', 'name' => 'AC Maintenance', 'description' => "Spring & fall tune-ups to prevent breakdowns and extend your system's life significantly.", 'slug' => 'ac-maintenance', 'color' => '#3b82f6' ],
				[ 'category' => 'COMMERCIAL', 'name' => 'Commercial HVAC', 'description' => 'Crane-capable commercial service for offices, retail, and restaurants â€” fast and stocked.', 'slug' => 'commercial', 'color' => '#8b5cf6' ],
				[ 'category' => 'DUCTS', 'name' => 'Duct Services', 'description' => 'NADCA-certified cleaning, repair & full replacement. City permitted and guaranteed.', 'slug' => 'duct-cleaning', 'color' => '#f59e0b' ],
				[ 'category' => 'AIR QUALITY', 'name' => 'Air Quality', 'description' => 'UV lights, air purifiers, HEPA filters, and smart thermostats for healthier home air.', 'slug' => 'uv-lights', 'color' => '#06b6d4' ],
				[ 'category' => 'PLUMBING', 'name' => 'Plumbing', 'description' => 'Water heaters, drain cleaning, pipe repair, leak detection & fixture work. Licensed.', 'slug' => 'plumbing', 'color' => '#0891b2' ],
				[ 'category' => 'EMERGENCY', 'name' => 'Emergency 24/7', 'description' => 'Open around the clock â€” real people answer your call. We dispatch immediately.', 'slug' => 'emergency', 'color' => '#ef4444' ],
			],
		],
		'why' => [
			'label'    => 'Why Your Neighbors Choose Us',
			'title'    => "South Florida's Trusted Choice Since 2009",
			'subtitle' => "We've served over 250,000 South Florida families through honest pricing, expert work, and a team that genuinely cares about your comfort and your home.",
			'primary'  => [ 'label' => 'Schedule Service Today â†’', 'url' => home_url( '/contact/' ) ],
			'secondary'=> [ 'label' => 'ðŸ“ž Call or Text ' . ca_phone(), 'url' => 'tel:' . ca_phone_raw() ],
			'items'    => [
				[ 'icon' => 'âš¡', 'title' => 'Same-Day Service', 'description' => 'Emergency calls dispatched fast. Fully stocked vans mean most problems solved in one visit.', 'color' => '#0ea5e9' ],
				[ 'icon' => 'ðŸ†', 'title' => 'Factory Certified', 'description' => 'Trained on every major HVAC brand in South Florida â€” residential and commercial.', 'color' => '#22c55e' ],
				[ 'icon' => 'ðŸ’°', 'title' => 'Flat-Rate Pricing', 'description' => 'No hourly billing or hidden charges. Every customer pays the same honest, transparent price.', 'color' => '#f59e0b' ],
				[ 'icon' => 'ðŸ›¡ï¸', 'title' => '1-Year Warranty', 'description' => 'Every repair backed by a full 1-year parts & labor warranty. No exceptions, no questions.', 'color' => '#8b5cf6' ],
				[ 'icon' => 'ðŸ™ï¸', 'title' => 'City Permitted', 'description' => "Every installation comes with a city permit â€” protecting your home's value and your peace of mind.", 'color' => '#ef4444' ],
				[ 'icon' => 'ðŸ“ž', 'title' => 'Open 24/7', 'description' => 'Real people answer your call around the clock. Never a machine. Never a voicemail.', 'color' => '#06b6d4' ],
			],
		],
		'reviews' => ca_reviews_content_defaults(),
		'process' => [
			'label'    => 'Simple &amp; Transparent',
			'title'    => 'From Call to Cool in 4 Steps',
			'subtitle' => "We make it easy. Here's exactly what happens the moment you reach out.",
			'steps'    => [
				[ 'title' => 'Call or Book Online', 'description' => "Reach us at " . ca_phone() . " or book online. We're open 24/7/365 â€” a real person in our office answers, never a machine." ],
				[ 'title' => 'Tech Arrives Fast', 'description' => 'A certified, factory-trained technician arrives in a fully stocked van â€” typically within hours, ready to diagnose and fix.' ],
				[ 'title' => 'Clear Flat-Rate Quote', 'description' => "We explain what's wrong in plain English and give a flat-rate price before any work begins. No surprises." ],
				[ 'title' => 'Problem Solved', 'description' => 'Repair done, system tested, invoice emailed with before & after photos. Comfort restored â€” guaranteed.' ],
			],
		],
		'brands' => [ 'title' => 'Factory Certified On All Major HVAC &amp; Plumbing Brands', 'items' => ca_brands() ],
		'map' => [
			'label'    => 'Service Coverage',
			'title'    => 'Serving 80+ Cities Across South Florida',
			'subtitle' => 'Hover any city below to see how many of your neighbors trust Cool Air USA for HVAC and plumbing service.',
			'primary'  => [ 'label' => 'View All Service Areas â†’', 'url' => home_url( '/service-areas/' ) ],
			'counties' => ca_counties_content_defaults(),
		],
		'membership_cta' => ca_membership_cta_content_defaults(),
		'gallery' => [
			'label'    => 'Recent Work',
			'title'    => 'Projects Across South Florida',
			'subtitle' => "A look at what we've recently completed for your neighbors. From quick repairs to full installations, every job gets the same care.",
			'projects' => ca_gallery_content_defaults(),
		],
		'emergency' => ca_emergency_content_defaults(),
	];
}

function ca_home_content() {
	static $content = null;
	if ( $content === null ) {
		$content = ca_dynamic_content( 'home', ca_home_content_defaults() );
	}
	return $content;
}

function ca_render_homepage() {
	ob_start(); ?>
	<div class="ca-home">
		<?php echo ca_section_hero(); ?>
		<?php echo ca_section_stats_bar(); ?>
		<?php echo ca_section_family_band(); ?>
		<?php echo ca_section_services(); ?>
		<?php echo ca_section_why(); ?>
		<?php echo ca_section_reviews(); ?>
		<?php echo ca_section_process(); ?>
		<?php echo ca_section_brands(); ?>
		<?php echo ca_section_service_areas_map(); ?>
		<?php echo ca_section_membership_cta(); ?>
		<?php echo ca_section_work_gallery(); ?>
		<?php echo ca_section_emergency(); ?>
	</div>
	<?php
	return ob_get_clean();
}
