<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_legal_page_content_defaults( $slug = 'privacy-policy' ) {
	if ( strpos( $slug, 'terms' ) !== false ) {
		return [
			'hero' => [ 'crumb' => 'Terms of Service', 'title' => 'Terms of Service', 'subtitle' => 'Last updated: January 2026', 'badges' => [] ],
			'sections' => [
				[ 'title' => 'Service Agreement', 'text' => 'By scheduling service with Cool Air USA you agree to these terms. All work is performed by licensed and insured technicians under license CAC1816920.' ],
				[ 'title' => 'Pricing &amp; Payment', 'text' => 'All pricing is flat-rate and provided in writing before any work begins. Payment is due upon completion. We accept cash, all major credit cards, and approved financing.' ],
				[ 'title' => 'Warranty', 'text' => "Repairs include a 1-year parts &amp; labor warranty. Installations include a 1-year labor warranty plus the manufacturer's parts warranty (typically 5â€“10 years)." ],
				[ 'title' => 'Cancellations', 'text' => 'Same-day cancellations may incur a dispatch fee. Rescheduling 24+ hours in advance is always free.' ],
				[ 'title' => 'Limitation of Liability', 'text' => "Cool Air USA's liability is limited to the amount paid for the specific service. We are not liable for indirect or consequential damages." ],
				[ 'title' => 'Dispute Resolution', 'text' => 'Any disputes will be resolved by binding arbitration in Broward County, Florida.' ],
				[ 'title' => 'Modifications', 'text' => 'We may update these terms periodically. Continued use of our services after changes constitutes acceptance of the updated terms.' ],
			],
		];
	}

	return [
		'hero' => [ 'crumb' => 'Privacy Policy', 'title' => 'Privacy Policy', 'subtitle' => 'Last updated: January 2026', 'badges' => [] ],
		'sections' => [
			[ 'title' => 'Information We Collect', 'text' => 'We collect information you provide directly: name, address, phone, email, and details about your home or business HVAC and plumbing systems. We also collect technical data such as IP address and browser type when you visit our website.' ],
			[ 'title' => 'How We Use Information', 'text' => 'We use your information to schedule and provide service, follow up on appointments, send maintenance reminders, process payments, and respond to inquiries. We never sell your personal information to third parties.' ],
			[ 'title' => 'Information Sharing', 'text' => 'We share information only with service partners necessary to deliver our services (payment processors, scheduling software, parts suppliers). All partners are bound by data protection requirements.' ],
			[ 'title' => 'Data Security', 'text' => 'We protect your data using industry-standard security measures including encryption in transit, secure storage, and access controls. No method of transmission is 100% secure but we follow best practices.' ],
			[ 'title' => 'Your Rights', 'text' => 'You may request a copy of your data, request corrections, or request deletion at any time by contacting us at ' . ca_email() . '.' ],
			[ 'title' => 'Cookies', 'text' => 'Our website uses cookies to remember preferences and analyze site usage. You can disable cookies in your browser settings.' ],
			[ 'title' => 'Contact', 'text' => 'Privacy questions? Email ' . ca_email() . ' or call ' . ca_phone() . '.' ],
		],
	];
}

function ca_render_legal_page( $attrs ) {
	$kind = ! empty( $attrs['kind'] ) ? $attrs['kind'] : 'privacy';
	$slug = get_post_field( 'post_name', get_queried_object_id() );
	if ( strpos( $slug, 'terms' ) !== false ) {
		$kind = 'terms';
	}
	if ( strpos( $slug, 'privacy' ) !== false ) {
		$kind = 'privacy';
	}

	$key = $kind === 'terms' ? 'terms-of-service' : 'privacy-policy';
	return ca_render_legal_doc( ca_dynamic_content( $key, ca_legal_page_content_defaults( $key ) ) );
}

function ca_render_legal_doc( $content ) {
	ob_start(); ?>
	<div class="ca-legal">
		<?php echo ca_page_hero( $content['hero']['crumb'], $content['hero']['title'], $content['hero']['subtitle'], $content['hero']['badges'] ); ?>
		<section class="content-section">
			<div class="content-in legal-doc">
				<?php foreach ( $content['sections'] as $s ) : ?>
					<div class="legal-section reveal">
						<h3 class="legal-h3"><?php echo wp_kses_post( $s['title'] ); ?></h3>
						<p><?php echo wp_kses_post( $s['text'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	</div>
	<?php
	return ob_get_clean();
}
