<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_contact_page_content_defaults() {
	return [
		'hero' => [
			'crumb' => 'Contact',
			'title' => 'Get In Touch',
			'subtitle' => 'Schedule service, request a free estimate, or just ask a question. A real person from our Fort Lauderdale office will respond within an hour during business hours.',
			'badges' => [ '24/7/365', 'Live Agents', 'Same-Day Service', 'Free Estimates' ],
		],
		'info' => [
			'label' => 'Reach Us',
			'title' => "We're Always Here",
			'rows' => [
				[ 'icon' => 'ðŸ“ž', 'title' => 'Phone', 'text' => '<a href="tel:' . esc_attr( ca_phone_raw() ) . '">' . esc_html( ca_phone() ) . '</a><br>24/7/365 â€” real people, never a machine.' ],
				[ 'icon' => 'âœ‰ï¸', 'title' => 'Email', 'text' => '<a href="mailto:' . esc_attr( ca_email() ) . '">' . esc_html( ca_email() ) . '</a><br>We reply within 1 business hour.' ],
				[ 'icon' => 'ðŸ“', 'title' => 'Office', 'text' => esc_html( ca_address() ) . '<br>Drop-ins welcome 8amâ€“6pm.' ],
				[ 'icon' => 'ðŸ•', 'title' => 'Hours', 'text' => 'Office: 7amâ€“9pm Monâ€“Sat<br>Emergency dispatch: 24/7/365' ],
			],
		],
		'form' => [
			'title' => 'Schedule Service',
			'name_label' => 'Full Name',
			'phone_label' => 'Phone Number',
			'email_label' => 'Email',
			'service_label' => 'Service Needed',
			'message_label' => 'Tell Us More',
			'button_label' => 'Submit Request â†’',
			'success_message' => "Thanks â€” we'll be in touch shortly.",
			'service_options' => [ 'AC Repair', 'AC Installation', 'AC Maintenance', 'Duct Services', 'Air Quality', 'Plumbing', 'Commercial', 'Emergency', 'Other' ],
		],
		'emergency' => ca_emergency_content_defaults(),
	];
}

function ca_render_contact_page() {
	$content = ca_dynamic_content( 'contact', ca_contact_page_content_defaults() );
	$info    = $content['info'];
	$form    = $content['form'];
	ob_start(); ?>
	<div class="ca-contact">
		<?php echo ca_page_hero( $content['hero']['crumb'], $content['hero']['title'], $content['hero']['subtitle'], $content['hero']['badges'] ); ?>

		<section class="content-section off">
			<div class="content-in">
				<div class="contact-grid">
					<div class="reveal">
						<div class="sec-label"><?php echo wp_kses_post( $info['label'] ); ?></div>
						<h2 class="sec-title"><?php echo wp_kses_post( $info['title'] ); ?></h2>
						<div class="contact-info-card">
							<?php foreach ( $info['rows'] as $r ) : ?>
								<div class="contact-row">
									<div class="contact-icon"><?php echo wp_kses_post( $r['icon'] ); ?></div>
									<div class="contact-detail">
										<h4><?php echo esc_html( $r['title'] ); ?></h4>
										<p><?php echo wp_kses_post( $r['text'] ); ?></p>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="reveal">
						<form class="form-card" data-contact-form>
							<div class="form-title"><?php echo esc_html( $form['title'] ); ?></div>
							<div class="form-row">
								<label for="cf-name"><?php echo esc_html( $form['name_label'] ); ?></label>
								<input id="cf-name" name="name" type="text" required>
							</div>
							<div class="form-row">
								<label for="cf-phone"><?php echo esc_html( $form['phone_label'] ); ?></label>
								<input id="cf-phone" name="phone" type="tel" required>
							</div>
							<div class="form-row">
								<label for="cf-email"><?php echo esc_html( $form['email_label'] ); ?></label>
								<input id="cf-email" name="email" type="email" required>
							</div>
							<div class="form-row">
								<label for="cf-service"><?php echo esc_html( $form['service_label'] ); ?></label>
								<select id="cf-service" name="service">
									<?php foreach ( $form['service_options'] as $opt ) : ?>
										<option><?php echo esc_html( $opt ); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-row">
								<label for="cf-message"><?php echo esc_html( $form['message_label'] ); ?></label>
								<textarea id="cf-message" name="message" rows="4"></textarea>
							</div>
							<button class="btn-green form-submit" type="submit"><?php echo esc_html( $form['button_label'] ); ?></button>
							<div class="form-submit-msg" hidden data-form-success><?php echo esc_html( $form['success_message'] ); ?></div>
						</form>
					</div>
				</div>
			</div>
		</section>

		<?php echo ca_section_emergency( 'contact' ); ?>
	</div>
	<?php
	return ob_get_clean();
}
