<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ca_render_site_header() {
	$base       = trailingslashit( home_url() );
	$menu_tree  = ca_get_menu_tree( 'primary' );
	$nav_items  = $menu_tree ?: ca_header_fallback_menu( $base );
	$mobile_nav = ca_get_menu_tree( 'mobile' ) ?: $nav_items;

	ob_start(); ?>
	<div class="nav-wrapper" data-site-header>
		<div class="ebar">
			<span class="ebar-item live"><span class="live-dot"></span><?php echo esc_html( ca_theme_setting( 'top_bar_status', '24/7/365 · Real People in our Office' ) ); ?></span>
			<span class="ebar-item rating"><?php echo ca_format_rating_stars( ca_theme_setting( 'top_bar_rating', "South Florida's Highest Rated ★★★★★ 4.9 · 4,600+ Reviews" ) ); ?></span>
			<a class="ebar-item ebar-call" href="tel:<?php echo esc_attr( ca_phone_raw() ); ?>">📞 Call or Text <?php echo esc_html( ca_phone() ); ?> <span class="ebar-pill">Open Now</span></a>
			<span class="ebar-item"><?php echo esc_html( ca_theme_setting( 'top_bar_trust', 'A+ BBB · Licensed & Insured · Family Owned & Operated' ) ); ?></span>
		</div>
		<nav class="nav" aria-label="<?php esc_attr_e( 'Main', 'cool-air-usa' ); ?>">
			<div class="nav-inner">
				<a class="nav-logo" href="<?php echo esc_url( $base ); ?>">
					<img src="<?php echo esc_url( ca_logo_url() ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				</a>
				<div class="nav-links">
					<?php echo ca_render_header_nav_items( $nav_items ); ?>
				</div>
				<div class="nav-actions">
					<a class="nav-phone" href="tel:<?php echo esc_attr( ca_phone_raw() ); ?>"><?php echo esc_html( ca_phone() ); ?></a>
					<a class="btn-portal" href="<?php echo esc_url( ca_portal_url() ); ?>" target="_blank" rel="noopener">Customer Portal</a>
				</div>
				<button class="nav-hamburger" aria-label="<?php esc_attr_e( 'Menu', 'cool-air-usa' ); ?>" data-mobile-toggle><span></span><span></span><span></span></button>
			</div>
			<?php echo ca_render_mobile_nav_items( $mobile_nav ); ?>
		</nav>
	</div>
	<?php
	return ob_get_clean();
}

function ca_get_menu_tree( $location ) {
	$locations = get_nav_menu_locations();
	if ( empty( $locations[ $location ] ) ) {
		return [];
	}

	$menu_items = wp_get_nav_menu_items( $locations[ $location ] );
	if ( empty( $menu_items ) || is_wp_error( $menu_items ) ) {
		return [];
	}

	$indexed_items     = [];
	$children_by_parent = [];
	$top_level_ids      = [];

	foreach ( $menu_items as $menu_item ) {
		$item_id   = (int) $menu_item->ID;
		$parent_id = (int) $menu_item->menu_item_parent;

		$indexed_items[ $item_id ] = [
			'id'        => (string) $item_id,
			'parent_id' => $parent_id,
			'title'     => $menu_item->title,
			'url'       => $menu_item->url,
			'target'    => $menu_item->target,
			'rel'       => $menu_item->xfn,
			'current'   => in_array( 'current-menu-item', $menu_item->classes, true ) || in_array( 'current-menu-ancestor', $menu_item->classes, true ),
			'children'  => [],
		];

		if ( $parent_id === 0 ) {
			$top_level_ids[] = $item_id;
			continue;
		}

		$children_by_parent[ $parent_id ][] = $item_id;
	}

	$tree = [];
	foreach ( $top_level_ids as $top_level_id ) {
		if ( isset( $indexed_items[ $top_level_id ] ) ) {
			$tree[] = ca_build_menu_branch( $indexed_items[ $top_level_id ], $indexed_items, $children_by_parent );
		}
	}

	return $tree;
}

function ca_build_menu_branch( $menu_item, $indexed_items, $children_by_parent ) {
	$item_id = (int) $menu_item['id'];
	if ( ! empty( $children_by_parent[ $item_id ] ) ) {
		foreach ( $children_by_parent[ $item_id ] as $child_id ) {
			if ( isset( $indexed_items[ $child_id ] ) ) {
				$menu_item['children'][] = ca_build_menu_branch( $indexed_items[ $child_id ], $indexed_items, $children_by_parent );
			}
		}
	}

	unset( $menu_item['parent_id'] );
	return $menu_item;
}

function ca_header_fallback_menu( $base ) {
	return [
		[
			'id'       => 'hvac',
			'title'    => 'HVAC',
			'url'      => '#',
			'children' => [
				[ 'title' => 'AC Repair', 'url' => $base . 'services/ac-repair/' ],
				[ 'title' => 'AC Installation', 'url' => $base . 'services/ac-install/' ],
				[ 'title' => 'AC Maintenance', 'url' => $base . 'services/ac-maintenance/' ],
				[ 'title' => 'Commercial HVAC', 'url' => $base . 'services/commercial/' ],
				[ 'title' => 'Emergency Service', 'url' => $base . 'services/emergency/' ],
			],
		],
		[
			'id'       => 'ducts',
			'title'    => 'Duct Services',
			'url'      => '#',
			'children' => [
				[ 'title' => 'Duct Cleaning', 'url' => $base . 'services/duct-cleaning/' ],
				[ 'title' => 'Duct Repair', 'url' => $base . 'services/duct-repair/' ],
				[ 'title' => 'Duct Installation', 'url' => $base . 'services/duct-install/' ],
			],
		],
		[
			'id'       => 'air',
			'title'    => 'Air Quality',
			'url'      => '#',
			'children' => [
				[ 'title' => 'UV Lights', 'url' => $base . 'services/uv-lights/' ],
				[ 'title' => 'Air Purifiers', 'url' => $base . 'services/air-purifiers/' ],
				[ 'title' => 'Air Filters', 'url' => $base . 'services/air-filters/' ],
				[ 'title' => 'Thermostats', 'url' => $base . 'services/thermostats/' ],
			],
		],
		[ 'id' => 'plumbing', 'title' => 'Plumbing', 'url' => $base . 'services/plumbing/', 'children' => [] ],
		[ 'id' => 'membership', 'title' => 'Membership', 'url' => $base . 'membership/', 'children' => [] ],
		[
			'id'       => 'areas',
			'title'    => 'Service Areas',
			'url'      => '#',
			'children' => [
				[ 'title' => 'Miami-Dade County', 'url' => $base . 'service-areas/' ],
				[ 'title' => 'Broward County', 'url' => $base . 'service-areas/' ],
				[ 'title' => 'Palm Beach County', 'url' => $base . 'service-areas/' ],
				[ 'title' => '→ All Service Areas', 'url' => $base . 'service-areas/' ],
			],
		],
		[
			'id'       => 'about',
			'title'    => 'About',
			'url'      => '#',
			'children' => [
				[ 'title' => 'About Us', 'url' => $base . 'about/' ],
				[ 'title' => 'Financing', 'url' => $base . 'financing/' ],
				[ 'title' => 'Careers', 'url' => $base . 'careers/' ],
				[ 'title' => 'Specials & Deals', 'url' => $base . 'specials/' ],
				[ 'title' => 'Brands We Service', 'url' => $base . 'brands/' ],
			],
		],
		[ 'id' => 'contact', 'title' => 'Contact', 'url' => $base . 'contact/', 'children' => [] ],
	];
}

function ca_render_header_nav_items( $items ) {
	ob_start();
	foreach ( $items as $nav_item ) :
		$children = $nav_item['children'] ?? [];
		$current  = ! empty( $nav_item['current'] ) ? ' act' : '';
		if ( $children ) : ?>
			<div class="nav-item" data-dropdown="<?php echo esc_attr( $nav_item['id'] ?? sanitize_title( $nav_item['title'] ) ); ?>">
				<button class="nav-btn<?php echo esc_attr( $current ); ?>" type="button"><?php echo esc_html( $nav_item['title'] ); ?> <span class="nav-chevron">▾</span></button>
				<div class="nav-dropdown">
					<?php foreach ( $children as $child_item ) : ?>
						<?php echo ca_render_nav_link( $child_item, 'nav-dd-item' ); ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php else : ?>
			<?php echo ca_render_nav_link( $nav_item, 'nav-btn' . $current ); ?>
		<?php endif;
	endforeach;
	return ob_get_clean();
}

function ca_render_mobile_nav_items( $items ) {
	ob_start(); ?>
	<div class="mobile-menu" data-mobile-menu>
		<?php foreach ( $items as $nav_item ) : ?>
			<?php if ( ! empty( $nav_item['children'] ) ) : ?>
				<span class="mob-label"><?php echo esc_html( $nav_item['title'] ); ?></span>
				<?php foreach ( $nav_item['children'] as $child_item ) : ?>
					<?php echo ca_render_nav_link( $child_item, 'mob-btn' ); ?>
				<?php endforeach; ?>
			<?php else : ?>
				<?php echo ca_render_nav_link( $nav_item, 'mob-btn' ); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<?php
	return ob_get_clean();
}

function ca_render_nav_link( $nav_item, $class_name ) {
	$target = ! empty( $nav_item['target'] ) ? ' target="' . esc_attr( $nav_item['target'] ) . '"' : '';
	$rel    = ! empty( $nav_item['rel'] ) ? ' rel="' . esc_attr( $nav_item['rel'] ) . '"' : '';

	return '<a class="' . esc_attr( $class_name ) . '" href="' . esc_url( $nav_item['url'] ?? '#' ) . '"' . $target . $rel . '>' . esc_html( $nav_item['title'] ?? '' ) . '</a>';
}

function ca_format_rating_stars( $rating_text ) {
	$escaped_text = esc_html( $rating_text );
	return str_replace( '★★★★★', '<span class="rating-stars">★★★★★</span>', $escaped_text );
}
