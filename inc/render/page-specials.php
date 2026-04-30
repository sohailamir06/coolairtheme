<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_specials_page_content_defaults() {
	return [
		'hero' => [
			'crumb' => 'Specials',
			'title' => 'Current Specials &amp; Deals',
			'subtitle' => 'Real savings, no fine print. These promotions are available right now to South Florida homeowners â€” call us to confirm and lock in your discount.',
			'badges' => [ 'Limited Time', 'New Customers', 'No Hidden Fees', 'Stack with Membership' ],
		],
		'specials' => [
			[ 'tag' => 'TUNE-UP', 'name' => '$89 Spring/Fall A/C Tune-Up', 'description' => 'Comprehensive 21-point tune-up â€” coil clean, refrigerant check, full diagnostic. Reg. $129.', 'button' => [ 'label' => 'Claim This Offer â†’', 'url' => home_url( '/contact/' ) ] ],
			[ 'tag' => 'INSTALL', 'name' => '$500 Off Complete System', 'description' => 'Save $500 on a full A/C replacement install with this current promotion. Includes city permit.', 'button' => [ 'label' => 'Claim This Offer â†’', 'url' => home_url( '/contact/' ) ] ],
			[ 'tag' => 'SERVICE', 'name' => '$50 Off Any Repair', 'description' => 'New customers save $50 on the first repair we complete in your home. Cannot combine with other offers.', 'button' => [ 'label' => 'Claim This Offer â†’', 'url' => home_url( '/contact/' ) ] ],
			[ 'tag' => 'MEMBERSHIP', 'name' => 'Free First Tune-Up', 'description' => 'Sign up for any membership plan and your first tune-up is on us â€” a $89 value.', 'button' => [ 'label' => 'Claim This Offer â†’', 'url' => home_url( '/contact/' ) ] ],
			[ 'tag' => 'PLUMBING', 'name' => '$75 Off Water Heater Service', 'description' => 'Water heater repair or replacement â€” save $75 with this current promotion.', 'button' => [ 'label' => 'Claim This Offer â†’', 'url' => home_url( '/contact/' ) ] ],
			[ 'tag' => 'AIR QUALITY', 'name' => 'Free UV Light w/ Duct Cleaning', 'description' => 'Get a UV-C purifier installed free when you book a full-home duct cleaning.', 'button' => [ 'label' => 'Claim This Offer â†’', 'url' => home_url( '/contact/' ) ] ],
		],
		'emergency' => ca_emergency_content_defaults(),
	];
}

function ca_render_specials_page() {
	$content  = ca_dynamic_content( 'specials', ca_specials_page_content_defaults() );
	$specials = $content['specials'];
	ob_start(); ?>
	<div class="ca-specials">
		<?php echo ca_page_hero( $content['hero']['crumb'], $content['hero']['title'], $content['hero']['subtitle'], $content['hero']['badges'] ); ?>

		<section class="content-section">
			<div class="content-in">
				<div class="specials-grid">
					<?php foreach ( $specials as $i => $s ) : ?>
						<div class="special-card reveal d<?php echo ( $i % 3 ) + 1; ?>">
							<div class="special-tag"><?php echo esc_html( $s['tag'] ); ?></div>
							<div class="special-name"><?php echo esc_html( $s['name'] ); ?></div>
							<p class="special-desc"><?php echo esc_html( $s['description'] ); ?></p>
							<a class="btn-green special-cta" href="<?php echo esc_url( $s['button']['url'] ); ?>"><?php echo esc_html( $s['button']['label'] ); ?></a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<?php echo ca_section_emergency( 'specials' ); ?>
	</div>
	<?php
	return ob_get_clean();
}
