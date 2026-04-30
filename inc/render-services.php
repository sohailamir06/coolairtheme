<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_render_service_page_block() {
	$slug = ca_current_service_slug();
	return ca_render_service_page( $slug );
}

function ca_render_service_page( $slug ) {
	$data = ca_service_data();
	if ( ! isset( $data[ $slug ] ) ) {
		$slug = 'ac-repair';
	}

	$d = ca_dynamic_content( $slug, ca_service_content_defaults( $slug ) );

	ob_start(); ?>
	<div class="ca-service">
		<?php echo ca_service_hero( $d, $slug ); ?>
		<?php echo ca_service_overview( $d ); ?>
		<?php echo ca_service_benefits( $d ); ?>
		<?php echo ca_service_process( $d ); ?>
		<?php echo ca_service_cta( $d ); ?>
	</div>
	<?php
	return ob_get_clean();
}

function ca_service_content_defaults( $slug ) {
	$data = ca_service_data();
	if ( ! isset( $data[ $slug ] ) ) {
		$slug = 'ac-repair';
	}

	$d = $data[ $slug ];

	return [
		'title'    => $d['title'],
		'subtitle' => $d['subtitle'],
		'intro'    => $d['intro'],
		'badges'   => $d['badges'],
		'issues'   => array_map( function ( $issue ) {
			return [ 'title' => $issue[0], 'description' => $issue[1] ];
		}, $d['issues'] ),
		'benefits' => array_map( function ( $benefit ) {
			return [ 'icon' => $benefit[0], 'title' => $benefit[1], 'description' => $benefit[2] ];
		}, $d['benefits'] ),
		'process'  => array_map( function ( $step ) {
			return [ 'title' => $step[0], 'description' => $step[1] ];
		}, $d['process'] ),
		'overview' => [
			'label'     => 'Overview',
			'primary'   => [ 'label' => 'Schedule Service â†’', 'url' => home_url( '/contact/' ) ],
			'secondary' => [ 'label' => 'ðŸ“ž Call or Text ' . ca_phone(), 'url' => 'tel:' . ca_phone_raw() ],
		],
		'benefits_section' => [
			'label' => 'The Cool Air Advantage',
			'title' => 'Why Customers Choose Us',
		],
		'process_section' => [
			'label' => 'Our Process',
			'title' => 'What to Expect',
		],
		'warranty' => [
			'label'     => 'The Cool Air Warranty',
			'title'     => 'Your Service Is Fully Protected',
			'items'     => [ '1-year full parts & labor warranty', '30-day maintenance warranty', 'Same issue recurs = free fix', 'All parts new & unboxed onsite' ],
			'primary'   => [ 'label' => 'Schedule Now â†’', 'url' => home_url( '/contact/' ) ],
			'secondary' => [ 'label' => 'ðŸ“ž Call or Text', 'url' => 'tel:' . ca_phone_raw() ],
		],
		'cta' => [
			'title'     => 'Schedule Your Service Today',
			'subtitle'  => "Available 24/7, 365 days a year. You'll always speak to a live agent â€” never an answering machine.",
			'primary'   => [ 'label' => 'Book Online â†’', 'url' => home_url( '/contact/' ) ],
			'secondary' => [ 'label' => 'ðŸ“ž Call or Text ' . ca_phone(), 'url' => 'tel:' . ca_phone_raw() ],
		],
	];
}

function ca_service_hero( $d, $slug ) {
	$title    = $d['title'];
	$subtitle = $d['subtitle'];

	ob_start(); ?>
	<section class="page-hero">
		<div class="page-hero-in">
			<div class="page-hero-split">
				<div class="page-hero-left">
					<div class="page-crumb">Home <span>â€º</span> Services <span>â€º</span> <?php echo esc_html( $title ); ?></div>
					<h1 class="page-title"><?php echo esc_html( $title ); ?></h1>
					<p class="page-sub"><?php echo esc_html( $subtitle ); ?></p>
					<div class="page-badges">
						<?php foreach ( $d['badges'] as $b ) : ?>
							<span class="page-badge"><?php echo esc_html( $b ); ?></span>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="page-hero-right">
					<div class="page-hero-card-label">What We Handle</div>
					<div class="issue-grid">
						<?php foreach ( array_slice( $d['issues'], 0, 4 ) as $i ) : ?>
							<div class="issue-card" data-tilt-soft>
								<div class="issue-title"><?php echo esc_html( $i['title'] ); ?></div>
								<div class="issue-desc"><?php echo esc_html( $i['description'] ); ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function ca_service_overview( $d ) {
	$overview = $d['overview'];
	ob_start(); ?>
	<section class="content-section dark">
		<div class="content-in center">
			<div class="reveal">
				<div class="sec-label center"><?php echo wp_kses_post( $overview['label'] ); ?></div>
				<h2 class="sec-title light center"><?php echo esc_html( $d['subtitle'] ); ?></h2>
				<p class="sec-sub light center mx-auto"><?php echo esc_html( $d['intro'] ); ?></p>
			</div>
			<div class="cta-acts reveal">
				<a class="btn-green" href="<?php echo esc_url( $overview['primary']['url'] ); ?>"><?php echo esc_html( $overview['primary']['label'] ); ?></a>
				<a class="btn-green-call" href="<?php echo esc_url( $overview['secondary']['url'] ); ?>"><?php echo esc_html( $overview['secondary']['label'] ); ?></a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function ca_service_benefits( $d ) {
	$section = $d['benefits_section'];
	ob_start(); ?>
	<section class="content-section off">
		<div class="content-in">
			<div class="reveal center">
				<div class="sec-label center"><?php echo wp_kses_post( $section['label'] ); ?></div>
				<h2 class="sec-title center"><?php echo wp_kses_post( $section['title'] ); ?></h2>
			</div>
			<div class="benefit-cards">
				<?php foreach ( $d['benefits'] as $i => $b ) : ?>
					<div class="benefit-card reveal d<?php echo $i + 1; ?>">
						<div class="benefit-icon"><?php echo wp_kses_post( $b['icon'] ); ?></div>
						<div class="benefit-title"><?php echo esc_html( $b['title'] ); ?></div>
						<p class="benefit-desc"><?php echo esc_html( $b['description'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function ca_service_process( $d ) {
	$section  = $d['process_section'];
	$warranty = $d['warranty'];
	ob_start(); ?>
	<section class="content-section">
		<div class="content-in two-col">
			<div class="reveal">
				<div class="sec-label"><?php echo wp_kses_post( $section['label'] ); ?></div>
				<h2 class="sec-title"><?php echo wp_kses_post( $section['title'] ); ?></h2>
				<div class="num-steps">
					<?php foreach ( $d['process'] as $i => $p ) : ?>
						<div class="num-step">
							<div class="num-n"><?php echo $i + 1; ?></div>
							<div class="num-step-body">
								<h4><?php echo esc_html( $p['title'] ); ?></h4>
								<p><?php echo esc_html( $p['description'] ); ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="reveal warranty-card">
				<div class="sec-label warranty-label"><?php echo wp_kses_post( $warranty['label'] ); ?></div>
				<h3 class="warranty-title"><?php echo wp_kses_post( $warranty['title'] ); ?></h3>
				<ul class="bullets-list light">
					<?php foreach ( $warranty['items'] as $item ) : ?>
						<li><?php echo wp_kses_post( $item ); ?></li>
					<?php endforeach; ?>
				</ul>
				<div class="warranty-acts">
					<a class="btn-green" href="<?php echo esc_url( $warranty['primary']['url'] ); ?>"><?php echo esc_html( $warranty['primary']['label'] ); ?></a>
					<a class="btn-green-call" href="<?php echo esc_url( $warranty['secondary']['url'] ); ?>"><?php echo esc_html( $warranty['secondary']['label'] ); ?></a>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function ca_service_cta( $d = [] ) {
	$cta = $d['cta'] ?? ca_service_content_defaults( 'ac-repair' )['cta'];
	ob_start(); ?>
	<section class="cta-section">
		<div class="content-in">
			<h2 class="sec-title light center"><?php echo wp_kses_post( $cta['title'] ); ?></h2>
			<p class="sec-sub light center mx-auto"><?php echo wp_kses_post( $cta['subtitle'] ); ?></p>
			<div class="cta-acts">
				<a class="btn-green" href="<?php echo esc_url( $cta['primary']['url'] ); ?>"><?php echo esc_html( $cta['primary']['label'] ); ?></a>
				<a class="btn-green-call" href="<?php echo esc_url( $cta['secondary']['url'] ); ?>"><?php echo esc_html( $cta['secondary']['label'] ); ?></a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
