<?php
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'CA_ADMIN_SYNC_VERSION', '1.0.1' );

add_action( 'after_switch_theme', 'ca_sync_admin_structure' );
add_action( 'admin_init', 'ca_maybe_sync_admin_structure' );

function ca_maybe_sync_admin_structure() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( get_option( 'ca_admin_sync_version' ) === CA_ADMIN_SYNC_VERSION ) {
		return;
	}

	ca_sync_admin_structure();
}

function ca_sync_admin_structure() {
	$page_ids = ca_sync_pages();
	ca_sync_menus( $page_ids );
	ca_sync_front_page( $page_ids );
	update_option( 'ca_admin_sync_version', CA_ADMIN_SYNC_VERSION, false );
}

function ca_admin_page_definitions() {
	return [
		'home' => [
			'title'   => 'Home',
			'slug'    => 'home',
			'content' => '<!-- wp:cool-air-usa/homepage /-->',
		],
		'about' => [
			'title'   => 'About',
			'slug'    => 'about',
			'content' => '',
		],
		'contact' => [
			'title'   => 'Contact',
			'slug'    => 'contact',
			'content' => '',
		],
		'membership' => [
			'title'   => 'Membership',
			'slug'    => 'membership',
			'content' => '',
		],
		'financing' => [
			'title'   => 'Financing',
			'slug'    => 'financing',
			'content' => '',
		],
		'careers' => [
			'title'   => 'Careers',
			'slug'    => 'careers',
			'content' => '',
		],
		'specials' => [
			'title'   => 'Specials & Deals',
			'slug'    => 'specials',
			'content' => '',
		],
		'brands' => [
			'title'   => 'Brands',
			'slug'    => 'brands',
			'content' => '',
		],
		'service-areas' => [
			'title'   => 'Service Areas',
			'slug'    => 'service-areas',
			'content' => '',
		],
		'privacy-policy' => [
			'title'   => 'Privacy Policy',
			'slug'    => 'privacy-policy',
			'content' => '',
		],
		'terms-of-service' => [
			'title'   => 'Terms of Service',
			'slug'    => 'terms-of-service',
			'content' => '',
		],
		'services' => [
			'title'   => 'Services',
			'slug'    => 'services',
			'content' => '',
		],
	];
}

function ca_admin_service_page_definitions() {
	return [
		'ac-repair'       => 'AC Repair',
		'ac-install'      => 'AC Installation',
		'ac-maintenance'  => 'AC Maintenance',
		'commercial'      => 'Commercial HVAC',
		'emergency'       => 'Emergency Service',
		'duct-cleaning'   => 'Duct Cleaning',
		'duct-repair'     => 'Duct Repair',
		'duct-install'    => 'Duct Installation',
		'uv-lights'       => 'UV Lights',
		'air-purifiers'   => 'Air Purifiers',
		'air-filters'     => 'Air Filters',
		'thermostats'     => 'Thermostats',
		'plumbing'        => 'Plumbing',
	];
}

function ca_sync_pages() {
	$page_ids = [];

	foreach ( ca_admin_page_definitions() as $key => $page ) {
		$page_ids[ $key ] = ca_ensure_page( $page['title'], $page['slug'], $page['content'] );
	}

	$services_parent_id = $page_ids['services'] ?? 0;
	foreach ( ca_admin_service_page_definitions() as $slug => $title ) {
		$page_ids[ $slug ] = ca_ensure_page( $title, $slug, '', $services_parent_id );
	}

	return $page_ids;
}

function ca_ensure_page( $title, $slug, $content = '', $parent_id = 0 ) {
	$existing_page = get_page_by_path( $parent_id ? 'services/' . $slug : $slug, OBJECT, 'page' );
	if ( ! $existing_page ) {
		$existing_page = get_page_by_path( $slug, OBJECT, 'page' );
	}

	if ( $existing_page ) {
		if ( (int) $existing_page->post_parent !== (int) $parent_id && $parent_id ) {
			wp_update_post( [
				'ID'          => $existing_page->ID,
				'post_parent' => $parent_id,
			] );
		}

		if ( $content && trim( $existing_page->post_content ) === '' ) {
			wp_update_post( [
				'ID'           => $existing_page->ID,
				'post_content' => $content,
			] );
		}

		return (int) $existing_page->ID;
	}

	return (int) wp_insert_post( [
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_content' => $content,
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_parent'  => $parent_id,
		'meta_input'   => [
			'_ca_theme_created' => 1,
		],
	] );
}

function ca_sync_front_page( $page_ids ) {
	if ( empty( $page_ids['home'] ) ) {
		return;
	}

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', (int) $page_ids['home'] );
}

function ca_sync_menus( $page_ids ) {
	$menu_ids = [
		'primary'        => ca_ensure_menu( 'Cool Air USA Primary Menu' ),
		'mobile'         => ca_ensure_menu( 'Cool Air USA Mobile Menu' ),
		'footer_hvac'    => ca_ensure_menu( 'Cool Air USA Footer HVAC' ),
		'footer_more'    => ca_ensure_menu( 'Cool Air USA Footer More Services' ),
		'footer_company' => ca_ensure_menu( 'Cool Air USA Footer Company' ),
		'footer_legal'   => ca_ensure_menu( 'Cool Air USA Footer Legal' ),
	];

	ca_populate_primary_menu( $menu_ids['primary'], $page_ids );
	ca_populate_mobile_menu( $menu_ids['mobile'], $page_ids );
	ca_populate_footer_menu( $menu_ids['footer_hvac'], $page_ids, [ 'ac-repair', 'ac-install', 'ac-maintenance', 'commercial', 'emergency' ] );
	ca_populate_footer_menu( $menu_ids['footer_more'], $page_ids, [ 'duct-cleaning', 'duct-repair', 'uv-lights', 'air-purifiers', 'thermostats', 'plumbing' ] );
	ca_populate_footer_menu( $menu_ids['footer_company'], $page_ids, [ 'about', 'membership', 'service-areas', 'financing', 'careers', 'specials', 'contact', 'brands' ] );
	ca_populate_footer_menu( $menu_ids['footer_legal'], $page_ids, [ 'privacy-policy', 'terms-of-service', 'contact' ] );

	$locations = get_theme_mod( 'nav_menu_locations', [] );
	foreach ( $menu_ids as $location => $menu_id ) {
		if ( $menu_id && empty( $locations[ $location ] ) ) {
			$locations[ $location ] = $menu_id;
		}
	}
	set_theme_mod( 'nav_menu_locations', $locations );
}

function ca_ensure_menu( $menu_name ) {
	$menu = wp_get_nav_menu_object( $menu_name );
	if ( $menu ) {
		return (int) $menu->term_id;
	}

	$menu_id = wp_create_nav_menu( $menu_name );
	return is_wp_error( $menu_id ) ? 0 : (int) $menu_id;
}

function ca_populate_primary_menu( $menu_id, $page_ids ) {
	if ( ! $menu_id ) {
		return;
	}

	if ( ca_menu_has_items( $menu_id ) ) {
		return;
	}

	$hvac = ca_add_custom_menu_item( $menu_id, 'HVAC', '#' );
	foreach ( [ 'ac-repair', 'ac-install', 'ac-maintenance', 'commercial', 'emergency' ] as $slug ) {
		ca_add_page_menu_item( $menu_id, $page_ids, $slug, $hvac );
	}

	$ducts = ca_add_custom_menu_item( $menu_id, 'Duct Services', '#' );
	foreach ( [ 'duct-cleaning', 'duct-repair', 'duct-install' ] as $slug ) {
		ca_add_page_menu_item( $menu_id, $page_ids, $slug, $ducts );
	}

	$air = ca_add_custom_menu_item( $menu_id, 'Air Quality', '#' );
	foreach ( [ 'uv-lights', 'air-purifiers', 'air-filters', 'thermostats' ] as $slug ) {
		ca_add_page_menu_item( $menu_id, $page_ids, $slug, $air );
	}

	foreach ( [ 'plumbing', 'membership' ] as $slug ) {
		ca_add_page_menu_item( $menu_id, $page_ids, $slug );
	}

	$areas = ca_add_page_menu_item( $menu_id, $page_ids, 'service-areas', 0, 'Service Areas' );
	foreach ( [ 'Miami-Dade County', 'Broward County', 'Palm Beach County', '→ All Service Areas' ] as $label ) {
		ca_add_custom_menu_item( $menu_id, $label, get_permalink( $page_ids['service-areas'] ), $areas );
	}

	$about = ca_add_page_menu_item( $menu_id, $page_ids, 'about', 0, 'About' );
	foreach ( [ 'about', 'financing', 'careers', 'specials', 'brands' ] as $slug ) {
		ca_add_page_menu_item( $menu_id, $page_ids, $slug, $about );
	}

	ca_add_page_menu_item( $menu_id, $page_ids, 'contact' );
}

function ca_populate_mobile_menu( $menu_id, $page_ids ) {
	if ( ! $menu_id ) {
		return;
	}

	if ( ca_menu_has_items( $menu_id ) ) {
		return;
	}

	foreach ( [ 'ac-repair', 'ac-install', 'ac-maintenance', 'commercial', 'emergency', 'duct-cleaning', 'duct-repair', 'duct-install', 'uv-lights', 'air-purifiers', 'air-filters', 'thermostats', 'plumbing', 'membership', 'service-areas', 'contact', 'about' ] as $slug ) {
		ca_add_page_menu_item( $menu_id, $page_ids, $slug );
	}
}

function ca_populate_footer_menu( $menu_id, $page_ids, $slugs ) {
	if ( ! $menu_id ) {
		return;
	}

	if ( ca_menu_has_items( $menu_id ) ) {
		return;
	}

	foreach ( $slugs as $slug ) {
		ca_add_page_menu_item( $menu_id, $page_ids, $slug );
	}
}

function ca_menu_has_items( $menu_id ) {
	$items = wp_get_nav_menu_items( $menu_id );
	return ! empty( $items ) && ! is_wp_error( $items );
}

function ca_add_page_menu_item( $menu_id, $page_ids, $slug, $parent_id = 0, $title = '' ) {
	if ( empty( $page_ids[ $slug ] ) ) {
		return 0;
	}

	$page_id = (int) $page_ids[ $slug ];
	$page    = get_post( $page_id );

	return (int) wp_update_nav_menu_item( $menu_id, 0, [
		'menu-item-title'     => $title ?: ( $page ? $page->post_title : $slug ),
		'menu-item-object-id' => $page_id,
		'menu-item-object'    => 'page',
		'menu-item-type'      => 'post_type',
		'menu-item-parent-id' => $parent_id,
		'menu-item-status'    => 'publish',
	] );
}

function ca_add_custom_menu_item( $menu_id, $title, $url, $parent_id = 0 ) {
	return (int) wp_update_nav_menu_item( $menu_id, 0, [
		'menu-item-title'     => $title,
		'menu-item-url'       => $url,
		'menu-item-type'      => 'custom',
		'menu-item-parent-id' => $parent_id,
		'menu-item-status'    => 'publish',
	] );
}
