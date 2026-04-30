<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_section_why() {
	$content  = ca_home_content();
	$section  = $content['why'];
	$features = $section['items'];
	ob_start(); ?>
	<section class="section why-section">
		<div class="sec-in">
			<div class="reveal why-header">
				<div class="sec-label"><?php echo wp_kses_post( $section['label'] ); ?></div>
				<h2 class="sec-title"><?php echo wp_kses_post( $section['title'] ); ?></h2>
				<p class="sec-sub"><?php echo wp_kses_post( $section['subtitle'] ); ?></p>
			</div>
			<div class="why-grid">
				<?php foreach ( $features as $i => $f ) : ?>
					<div class="why-card reveal d<?php echo ( $i % 3 ) + 1; ?>" data-tilt style="--why-color: <?php echo esc_attr( $f['color'] ); ?>;">
						<div class="why-bar"></div>
						<div class="why-icon-wrap"><?php echo wp_kses_post( $f['icon'] ); ?></div>
						<div class="why-title"><?php echo esc_html( $f['title'] ); ?></div>
						<p class="why-desc"><?php echo esc_html( $f['description'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="why-cta">
				<a class="btn-green" href="<?php echo esc_url( $section['primary']['url'] ); ?>"><?php echo esc_html( $section['primary']['label'] ); ?></a>
				<a class="btn-green-call" href="<?php echo esc_url( $section['secondary']['url'] ); ?>"><?php echo esc_html( $section['secondary']['label'] ); ?></a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
