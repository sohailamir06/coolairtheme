<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_render_site_footer() {
	$base          = trailingslashit( home_url() );
	$hvac_links    = ca_footer_menu_items( 'footer_hvac', ca_footer_hvac_fallback( $base ) );
	$more_links    = ca_footer_menu_items( 'footer_more', ca_footer_more_fallback( $base ) );
	$company_links = ca_footer_menu_items( 'footer_company', ca_footer_company_fallback( $base ) );
	$legal_links   = ca_footer_menu_items( 'footer_legal', ca_footer_legal_fallback( $base ) );

	ob_start(); ?>
	<footer class="footer">
		<div class="footer-main">
			<div class="footer-col-brand">
				<div class="footer-logo"><img src="<?php echo esc_url( ca_logo_url() ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"></div>
				<div class="footer-tagline"><?php echo esc_html( ca_theme_setting( 'footer_tagline', 'We Care About Your Air' ) ); ?></div>
				<p class="footer-about"><?php echo esc_html( ca_theme_setting( 'footer_about', "Family-owned and operated since 2009. South Florida's most trusted HVAC contractor serving over 250,000 lifetime customers across Miami-Dade, Broward, and Palm Beach counties." ) ); ?></p>
				<div class="footer-crow">📞 <a href="tel:<?php echo esc_attr( ca_phone_raw() ); ?>"><?php echo esc_html( ca_phone() ); ?></a></div>
				<div class="footer-crow">✉️ <a href="mailto:<?php echo esc_attr( ca_email() ); ?>"><?php echo esc_html( ca_email() ); ?></a></div>
				<div class="footer-crow">📍 <?php echo esc_html( ca_address() ); ?></div>
				<div class="footer-crow">🕐 Office: 7am–9pm · Emergency: 24/7/365</div>
			</div>
			<?php echo ca_render_footer_column( 'HVAC Services', $hvac_links ); ?>
			<?php echo ca_render_footer_column( 'More Services', $more_links ); ?>
			<?php echo ca_render_footer_column( 'Company', $company_links ); ?>
		</div>
		<div class="footer-bot">
			<div class="footer-bot-copy">© <?php echo esc_html( ca_year() ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. All rights reserved. | <?php echo esc_html( ca_license_number() ); ?></div>
			<div class="footer-legal-links">
				<?php foreach ( $legal_links as $legal_index => $legal_link ) : ?>
					<?php if ( $legal_index > 0 ) : ?><span class="footer-legal-sep">·</span><?php endif; ?>
					<?php echo ca_render_nav_link( $legal_link, '' ); ?>
				<?php endforeach; ?>
			</div>
			<div class="fbadges">
				<span class="fbadge">⭐ 4.9 Google</span>
				<span class="fbadge">A+ BBB</span>
				<span class="fbadge">Licensed &amp; Insured</span>
				<span class="fbadge">Family Owned &amp; Operated</span>
			</div>
		</div>
	</footer>
	<?php
	return ob_get_clean();
}

function ca_footer_menu_items( $location, $fallback ) {
	$tree = ca_get_menu_tree( $location );
	if ( ! $tree ) {
		return $fallback;
	}

	return ca_flatten_menu_items( $tree );
}

function ca_flatten_menu_items( $items ) {
	$flat_items = [];
	foreach ( $items as $nav_item ) {
		$flat_items[] = $nav_item;
		if ( ! empty( $nav_item['children'] ) ) {
			$flat_items = array_merge( $flat_items, ca_flatten_menu_items( $nav_item['children'] ) );
		}
	}

	return $flat_items;
}

function ca_render_footer_column( $title, $links ) {
	ob_start(); ?>
	<div>
		<div class="fcol-title"><?php echo esc_html( $title ); ?></div>
		<?php foreach ( $links as $footer_link ) : ?>
			<?php echo ca_render_nav_link( $footer_link, 'flink' ); ?>
		<?php endforeach; ?>
	</div>
	<?php
	return ob_get_clean();
}

function ca_footer_hvac_fallback( $base ) {
	return [
		[ 'title' => 'AC Repair', 'url' => $base . 'services/ac-repair/' ],
		[ 'title' => 'AC Installation', 'url' => $base . 'services/ac-install/' ],
		[ 'title' => 'AC Maintenance', 'url' => $base . 'services/ac-maintenance/' ],
		[ 'title' => 'Commercial HVAC', 'url' => $base . 'services/commercial/' ],
		[ 'title' => 'Emergency Service', 'url' => $base . 'services/emergency/' ],
	];
}

function ca_footer_more_fallback( $base ) {
	return [
		[ 'title' => 'Duct Cleaning', 'url' => $base . 'services/duct-cleaning/' ],
		[ 'title' => 'Duct Repair', 'url' => $base . 'services/duct-repair/' ],
		[ 'title' => 'UV Lights', 'url' => $base . 'services/uv-lights/' ],
		[ 'title' => 'Air Purifiers', 'url' => $base . 'services/air-purifiers/' ],
		[ 'title' => 'Thermostats', 'url' => $base . 'services/thermostats/' ],
		[ 'title' => 'Plumbing', 'url' => $base . 'services/plumbing/' ],
	];
}

function ca_footer_company_fallback( $base ) {
	return [
		[ 'title' => 'About Us', 'url' => $base . 'about/' ],
		[ 'title' => 'Membership Plans', 'url' => $base . 'membership/' ],
		[ 'title' => 'Service Areas', 'url' => $base . 'service-areas/' ],
		[ 'title' => 'Financing', 'url' => $base . 'financing/' ],
		[ 'title' => 'Careers', 'url' => $base . 'careers/' ],
		[ 'title' => 'Specials & Deals', 'url' => $base . 'specials/' ],
		[ 'title' => 'Contact Us', 'url' => $base . 'contact/' ],
		[ 'title' => 'Brands We Service', 'url' => $base . 'brands/' ],
	];
}

function ca_footer_legal_fallback( $base ) {
	return [
		[ 'title' => 'Privacy Policy', 'url' => $base . 'privacy-policy/' ],
		[ 'title' => 'Terms of Service', 'url' => $base . 'terms-of-service/' ],
		[ 'title' => 'Contact', 'url' => $base . 'contact/' ],
	];
}
