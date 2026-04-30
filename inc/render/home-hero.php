<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_section_hero() {
	$content = ca_home_content();
	$hero    = $content['hero'];
	$badges  = $hero['badges'];
	$checks  = $hero['checks'];

	ob_start(); ?>
	<section class="hero" data-parallax>
		<div class="hero-bg"></div>
		<div class="hero-float hero-float-a">â„ï¸</div>
		<div class="hero-float hero-float-b">ðŸ’§</div>
		<div class="hero-split">
			<div>
				<div class="hero-eyebrow"><?php echo wp_kses_post( $hero['eyebrow'] ); ?></div>
				<h1 class="hero-h1"><?php echo wp_kses_post( $hero['title_html'] ); ?></h1>
				<p class="hero-sub"><?php echo wp_kses_post( $hero['subtitle'] ); ?></p>
				<div class="hero-acts">
					<a class="btn-green" href="<?php echo esc_url( $hero['primary']['url'] ); ?>"><?php echo esc_html( $hero['primary']['label'] ); ?></a>
					<a class="btn-outline-w" href="<?php echo esc_url( $hero['secondary']['url'] ); ?>"><?php echo esc_html( $hero['secondary']['label'] ); ?></a>
				</div>
				<div class="hero-checks">
					<?php foreach ( $checks as $c ) : ?>
						<div class="hero-check"><span class="hero-check-icon">âœ“</span><?php echo esc_html( $c ); ?></div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="hero-right">
				<div class="hero-logo-card">
					<img src="<?php echo esc_url( ca_logo_url() ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" height="210">
				</div>
				<div class="hero-badges">
					<?php foreach ( $badges as $b ) : ?>
						<div class="hero-badge">
							<div class="hero-badge-val"><?php echo esc_html( $b['value'] ); ?></div>
							<div class="hero-badge-lbl"><?php echo esc_html( $b['label'] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
				<?php echo ca_google_rating_card( $hero['rating'] ); ?>
			</div>
		</div>
		<div class="scroll-indicator">
			<span class="scroll-label"><?php echo esc_html( $hero['scroll_text'] ); ?></span>
			<div class="scroll-line"></div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function ca_google_rating_card( $rating = null ) {
	$rating = $rating ?: ca_home_content()['hero']['rating'];
	ob_start(); ?>
	<div class="grating-card">
		<div class="grating-g-pill">
			<span class="grating-g">G</span>
		</div>
		<div class="grating-meta">
			<div class="grating-row">
				<span class="grating-num"><?php echo esc_html( $rating['score'] ); ?></span>
				<span class="grating-stars"><?php echo esc_html( $rating['stars'] ); ?></span>
			</div>
			<div class="grating-sub"><?php echo esc_html( $rating['text'] ); ?></div>
		</div>
		<a class="grating-link" href="<?php echo esc_url( $rating['link_url'] ); ?>"><?php echo esc_html( $rating['link_label'] ); ?></a>
	</div>
	<?php
	return ob_get_clean();
}
