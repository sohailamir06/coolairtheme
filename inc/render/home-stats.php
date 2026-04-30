<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_section_stats_bar() {
	$content = ca_home_content();
	$sets    = $content['stats']['sets'];
	ob_start(); ?>
	<div class="stats-bar" data-stats-rotator>
		<div class="stats-slider-wrap">
			<div class="stats-slider-track">
				<?php foreach ( $sets as $set ) : ?>
					<div class="stats-slide">
						<?php foreach ( $set as $st ) : ?>
							<div class="stat">
								<div class="stat-val"><?php echo esc_html( $st['value'] ); ?></div>
								<div class="stat-lbl"><?php echo esc_html( $st['label'] ); ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>
			<button class="stats-arrow stats-arrow-l" aria-label="Previous">â€¹</button>
			<button class="stats-arrow stats-arrow-r" aria-label="Next">â€º</button>
			<div class="stats-dots">
				<?php for ( $i = 0; $i < count( $sets ); $i++ ) : ?>
					<button class="stats-dot<?php echo $i === 0 ? ' active' : ''; ?>" aria-label="Stats <?php echo $i + 1; ?>"></button>
				<?php endfor; ?>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

function ca_section_family_band() {
	$content = ca_home_content();
	$family  = $content['family'];
	$pills   = $family['pills'];
	$stats   = $family['stats'];
	ob_start(); ?>
	<div class="family-band">
		<div class="family-band-inner">
			<div>
				<div class="family-eyebrow"><?php echo wp_kses_post( $family['eyebrow'] ); ?></div>
				<h3 class="family-title"><?php echo wp_kses_post( $family['title'] ); ?></h3>
				<p class="family-quote"><?php echo wp_kses_post( $family['quote'] ); ?></p>
				<div class="family-pills">
					<?php foreach ( $pills as $p ) : ?>
						<div class="family-pill"><span class="family-pill-chk">âœ“</span><?php echo esc_html( $p ); ?></div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php foreach ( $stats as $s ) : ?>
				<div class="family-stat-box reveal">
					<div class="family-stat-val"><?php echo esc_html( $s['value'] ); ?></div>
					<div class="family-stat-lbl"><?php echo esc_html( $s['label'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
