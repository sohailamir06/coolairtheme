<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_about_page_content_defaults() {
	return [
		'hero' => [
			'crumb' => 'About',
			'title' => 'About Cool Air USA',
			'subtitle' => "We're a family business that built South Florida's highest-rated HVAC and plumbing company on one promise: treat every customer the way we'd want our own family treated.",
			'badges' => [ 'Family Owned Â· 2009', 'Licensed CAC1816920', 'A+ BBB Accredited', '4.9â˜… on 4,600+ Reviews' ],
		],
		'story' => [
			'label' => 'Our Story',
			'title' => 'Built On Family Values',
			'text'  => "Cool Air USA started with a single van and a simple promise â€” to be the company our neighbors could actually trust. Seventeen years and a quarter-million customers later, we're still that same family business. The phones are still answered by real people in our Fort Lauderdale office. Every install still gets a city permit. Every repair still comes with a 1-year warranty. And every customer still gets the kind of service we'd give our own family.",
			'values' => [
				[ 'icon' => 'ðŸ ', 'title' => 'Family-Owned', 'description' => 'Founded in 2009 by a Fort Lauderdale family. Still owned and operated by the same family today.' ],
				[ 'icon' => 'ðŸ¤', 'title' => 'Community First', 'description' => 'South Florida born and raised. We sponsor local schools, sports, and food drives every year.' ],
				[ 'icon' => 'âš–ï¸', 'title' => 'Honest Pricing', 'description' => 'Flat-rate pricing means every customer pays the same fair price â€” no markups, no surprises.' ],
				[ 'icon' => 'ðŸ›¡ï¸', 'title' => 'Backed Work', 'description' => '1-year parts & labor warranty on every repair, every install, every service we provide.' ],
			],
		],
		'journey' => [
			'label' => 'Our Journey',
			'title' => '17+ Years &amp; Counting',
			'milestones' => [
				[ 'year' => '2009', 'text' => "Cool Air USA founded in Fort Lauderdale by the founders' family." ],
				[ 'year' => '2014', 'text' => 'Crossed 50,000 lifetime customers served across South Florida.' ],
				[ 'year' => '2018', 'text' => 'NADCA-certified duct cleaning division launched.' ],
				[ 'year' => '2021', 'text' => 'Licensed plumbing division added to expand home-services offering.' ],
				[ 'year' => '2024', 'text' => 'Crossed 250,000 lifetime customers and 4,600+ five-star Google reviews.' ],
			],
		],
		'brands' => [
			'label' => 'Brands We Service',
			'title' => 'Factory Certified On 24+ Brands',
			'subtitle' => 'From legacy systems to the latest variable-speed equipment, our team trains continuously on every major HVAC and plumbing brand in the market.',
			'items' => ca_brands(),
		],
		'emergency' => ca_emergency_content_defaults(),
	];
}

function ca_render_about_page() {
	$content    = ca_dynamic_content( 'about', ca_about_page_content_defaults() );
	$story      = $content['story'];
	$journey    = $content['journey'];
	$brand_data = $content['brands'];
	ob_start(); ?>
	<div class="ca-about">
		<?php echo ca_page_hero( $content['hero']['crumb'], $content['hero']['title'], $content['hero']['subtitle'], $content['hero']['badges'] ); ?>

		<section class="content-section">
			<div class="content-in two-col">
				<div class="reveal">
					<div class="sec-label"><?php echo wp_kses_post( $story['label'] ); ?></div>
					<h2 class="sec-title"><?php echo wp_kses_post( $story['title'] ); ?></h2>
					<p class="sec-sub"><?php echo wp_kses_post( $story['text'] ); ?></p>
				</div>
				<div class="reveal benefit-cards">
					<?php foreach ( $story['values'] as $i => $v ) : ?>
						<div class="benefit-card d<?php echo $i + 1; ?>">
							<div class="benefit-icon"><?php echo wp_kses_post( $v['icon'] ); ?></div>
							<div class="benefit-title"><?php echo esc_html( $v['title'] ); ?></div>
							<p class="benefit-desc"><?php echo esc_html( $v['description'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="content-section off">
			<div class="content-in">
				<div class="reveal center">
					<div class="sec-label center"><?php echo wp_kses_post( $journey['label'] ); ?></div>
					<h2 class="sec-title center"><?php echo wp_kses_post( $journey['title'] ); ?></h2>
				</div>
				<div class="milestones">
					<?php foreach ( $journey['milestones'] as $i => $m ) : ?>
						<div class="milestone reveal d<?php echo ( $i % 4 ) + 1; ?>">
							<div class="milestone-year"><?php echo esc_html( $m['year'] ); ?></div>
							<div class="milestone-text"><?php echo esc_html( $m['text'] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="content-section">
			<div class="content-in">
				<div class="reveal center">
					<div class="sec-label center"><?php echo wp_kses_post( $brand_data['label'] ); ?></div>
					<h2 class="sec-title center"><?php echo wp_kses_post( $brand_data['title'] ); ?></h2>
					<p class="sec-sub center mx-auto"><?php echo wp_kses_post( $brand_data['subtitle'] ); ?></p>
				</div>
				<div class="brands-page-grid">
					<?php foreach ( $brand_data['items'] as $b ) : ?>
						<div class="brand-card"><?php echo esc_html( $b ); ?></div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<?php echo ca_section_emergency( 'about' ); ?>
	</div>
	<?php
	return ob_get_clean();
}
