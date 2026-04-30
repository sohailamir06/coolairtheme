<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_section_services() {
	$content  = ca_home_content();
	$section  = $content['services'];
	$services = $section['items'];
	ob_start(); ?>
	<section class="section svcs-section">
		<div class="sec-in">
			<div class="reveal">
				<div class="sec-label"><?php echo wp_kses_post( $section['label'] ); ?></div>
				<h2 class="sec-title"><?php echo wp_kses_post( $section['title'] ); ?></h2>
				<p class="sec-sub"><?php echo wp_kses_post( $section['subtitle'] ); ?></p>
			</div>
			<div class="svcs-grid">
				<?php foreach ( $services as $i => $s ) : ?>
					<a class="svc-card-mod reveal d<?php echo ( $i % 4 ) + 1; ?>"
					   href="<?php echo esc_url( home_url( '/services/' . $s['slug'] . '/' ) ); ?>"
					   style="--svc-color: <?php echo esc_attr( $s['color'] ); ?>;">
						<div class="svc-cat"><?php echo esc_html( $s['category'] ); ?></div>
						<div class="svc-name"><?php echo esc_html( $s['name'] ); ?></div>
						<p class="svc-desc"><?php echo esc_html( $s['description'] ); ?></p>
						<div class="svc-link">Learn More â†’</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
