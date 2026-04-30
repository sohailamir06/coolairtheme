<?php
/**
 * Cool Air USA — Theme Functions
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'CA_THEME_VERSION', '1.0.0' );
define( 'CA_THEME_DIR', get_template_directory() );
define( 'CA_THEME_URI', get_template_directory_uri() );
define( 'CA_PHONE',     '(954) 915-1155' );
define( 'CA_PHONE_RAW', '9549151155' );
define( 'CA_EMAIL',     'support@coolairusa.com' );
define( 'CA_ADDRESS',   '3901 NW 16th St, Fort Lauderdale, FL 33311' );
define( 'CA_PORTAL',    'http://coolairusa.myservicetitan.com' );

require_once CA_THEME_DIR . '/inc/page-data.php';
require_once CA_THEME_DIR . '/inc/dynamic-content.php';
require_once CA_THEME_DIR . '/inc/render-services.php';
require_once CA_THEME_DIR . '/inc/render-pages.php';
require_once CA_THEME_DIR . '/inc/render-home.php';
require_once CA_THEME_DIR . '/inc/admin-sync.php';

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'cool-air-usa', CA_THEME_DIR . '/languages' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', [
		'height'      => 96,
		'width'       => 260,
		'flex-height' => true,
		'flex-width'  => true,
	] );
	add_theme_support( 'html5', [ 'search-form','comment-form','comment-list','gallery','caption','script','style' ] );

	register_nav_menus( [
		'primary'        => __( 'Primary Header Menu', 'cool-air-usa' ),
		'mobile'         => __( 'Mobile Menu', 'cool-air-usa' ),
		'footer_hvac'    => __( 'Footer HVAC Services', 'cool-air-usa' ),
		'footer_more'    => __( 'Footer More Services', 'cool-air-usa' ),
		'footer_company' => __( 'Footer Company', 'cool-air-usa' ),
		'footer_legal'   => __( 'Footer Legal Links', 'cool-air-usa' ),
	] );
} );

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_section( 'ca_company_details', [
		'title'       => __( 'Cool Air USA Company Details', 'cool-air-usa' ),
		'description' => __( 'These values feed the theme header, footer, calls to action, and contact page.', 'cool-air-usa' ),
		'priority'    => 35,
	] );

	$settings = [
		'phone'          => [ __( 'Phone Number', 'cool-air-usa' ), CA_PHONE, 'text' ],
		'email'          => [ __( 'Email Address', 'cool-air-usa' ), CA_EMAIL, 'email' ],
		'address'        => [ __( 'Office Address', 'cool-air-usa' ), CA_ADDRESS, 'textarea' ],
		'portal_url'     => [ __( 'Customer Portal URL', 'cool-air-usa' ), CA_PORTAL, 'url' ],
		'top_bar_status' => [ __( 'Top Bar Status', 'cool-air-usa' ), '24/7/365 · Real People in our Office', 'text' ],
		'top_bar_rating' => [ __( 'Top Bar Rating', 'cool-air-usa' ), "South Florida's Highest Rated ★★★★★ 4.9 · 4,600+ Reviews", 'text' ],
		'top_bar_trust'  => [ __( 'Top Bar Trust Text', 'cool-air-usa' ), 'A+ BBB · Licensed & Insured · Family Owned & Operated', 'text' ],
		'footer_tagline' => [ __( 'Footer Tagline', 'cool-air-usa' ), 'We Care About Your Air', 'text' ],
		'footer_about'   => [ __( 'Footer About Text', 'cool-air-usa' ), "Family-owned and operated since 2009. South Florida's most trusted HVAC contractor serving over 250,000 lifetime customers across Miami-Dade, Broward, and Palm Beach counties.", 'textarea' ],
		'license_number' => [ __( 'License Number', 'cool-air-usa' ), 'CAC1816920', 'text' ],
	];

	foreach ( $settings as $setting_key => $setting_data ) {
		$sanitize_callback = 'sanitize_text_field';
		if ( $setting_data[2] === 'email' ) {
			$sanitize_callback = 'sanitize_email';
		} elseif ( $setting_data[2] === 'url' ) {
			$sanitize_callback = 'esc_url_raw';
		} elseif ( $setting_data[2] === 'textarea' ) {
			$sanitize_callback = 'sanitize_textarea_field';
		}

		$wp_customize->add_setting( 'ca_' . $setting_key, [
			'default'           => $setting_data[1],
			'sanitize_callback' => $sanitize_callback,
			'transport'         => 'refresh',
		] );

		$wp_customize->add_control( 'ca_' . $setting_key, [
			'label'   => $setting_data[0],
			'section' => 'ca_company_details',
			'type'    => $setting_data[2],
		] );
	}
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'ca-fonts',
		'https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800;900&family=Barlow:wght@300;400;500;600;700&display=swap',
		[],
		null
	);
	wp_enqueue_style( 'ca-main', CA_THEME_URI . '/assets/css/main.css', [], CA_THEME_VERSION );
	wp_enqueue_script( 'ca-nav',  CA_THEME_URI . '/assets/js/nav.js',  [], CA_THEME_VERSION, true );
	wp_enqueue_script( 'ca-main', CA_THEME_URI . '/assets/js/main.js', [], CA_THEME_VERSION, true );
} );

add_action( 'enqueue_block_assets', function () {
	if ( ! is_admin() ) {
		return;
	}

	wp_enqueue_style(
		'ca-fonts',
		'https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800;900&family=Barlow:wght@300;400;500;600;700&display=swap',
		[],
		null
	);
	wp_enqueue_style( 'ca-main', CA_THEME_URI . '/assets/css/main.css', [], CA_THEME_VERSION );
} );

add_action( 'init', function () {
	wp_register_script(
		'ca-editor-blocks',
		CA_THEME_URI . '/assets/js/editor-blocks.js',
		[ 'wp-blocks', 'wp-element', 'wp-server-side-render', 'wp-i18n' ],
		CA_THEME_VERSION,
		true
	);
} );

add_action( 'init', function () {
	register_block_pattern_category( 'cool-air-usa', [ 'label' => 'Cool Air USA' ] );

	foreach ( ca_dynamic_block_definitions() as $block_name => $settings ) {
		register_block_type( $block_name, $settings );
	}

	register_block_pattern( 'cool-air-usa/homepage-layout', [
		'title'       => __( 'Cool Air USA Homepage Layout', 'cool-air-usa' ),
		'description' => __( 'The default synced homepage structure.', 'cool-air-usa' ),
		'categories'  => [ 'cool-air-usa' ],
		'content'     => '<!-- wp:cool-air-usa/homepage /-->',
	] );
} );

/**
 * Shared metadata for server-rendered theme blocks.
 */
function ca_dynamic_block_definitions() {
	$common = [
		'api_version'   => 3,
		'editor_script' => 'ca-editor-blocks',
		'category'      => 'theme',
		'supports'      => [ 'html' => false ],
	];

	return [
		'cool-air-usa/site-header' => $common + [
			'title'           => 'Site Header',
			'description'     => 'Primary header and navigation.',
			'icon'            => 'editor-kitchensink',
			'render_callback' => 'ca_render_site_header',
		],
		'cool-air-usa/site-footer' => $common + [
			'title'           => 'Site Footer',
			'description'     => 'Global footer and legal links.',
			'icon'            => 'editor-kitchensink',
			'render_callback' => 'ca_render_site_footer',
		],
		'cool-air-usa/homepage' => $common + [
			'title'           => 'Homepage',
			'description'     => 'Homepage sections rendered in theme order.',
			'icon'            => 'layout',
			'render_callback' => 'ca_render_homepage',
		],
		'cool-air-usa/service-page' => $common + [
			'title'           => 'Service Page',
			'description'     => 'Dynamic service page content based on the current page slug.',
			'icon'            => 'admin-tools',
			'render_callback' => 'ca_render_service_page_block',
		],
		'cool-air-usa/services-page' => $common + [
			'title'           => 'Services Page',
			'description'     => 'Services landing page layout.',
			'icon'            => 'screenoptions',
			'render_callback' => 'ca_render_services_page',
		],
		'cool-air-usa/about-page' => $common + [
			'title'           => 'About Page',
			'description'     => 'About page layout.',
			'icon'            => 'id',
			'render_callback' => 'ca_render_about_page',
		],
		'cool-air-usa/contact-page' => $common + [
			'title'           => 'Contact Page',
			'description'     => 'Contact page layout.',
			'icon'            => 'email',
			'render_callback' => 'ca_render_contact_page',
		],
		'cool-air-usa/membership-page' => $common + [
			'title'           => 'Membership Page',
			'description'     => 'Membership plans page layout.',
			'icon'            => 'groups',
			'render_callback' => 'ca_render_membership_page',
		],
		'cool-air-usa/financing-page' => $common + [
			'title'           => 'Financing Page',
			'description'     => 'Financing page layout.',
			'icon'            => 'money-alt',
			'render_callback' => 'ca_render_financing_page',
		],
		'cool-air-usa/careers-page' => $common + [
			'title'           => 'Careers Page',
			'description'     => 'Careers page layout.',
			'icon'            => 'businessperson',
			'render_callback' => 'ca_render_careers_page',
		],
		'cool-air-usa/specials-page' => $common + [
			'title'           => 'Specials Page',
			'description'     => 'Special offers page layout.',
			'icon'            => 'tickets-alt',
			'render_callback' => 'ca_render_specials_page',
		],
		'cool-air-usa/brands-page' => $common + [
			'title'           => 'Brands Page',
			'description'     => 'Brands page layout.',
			'icon'            => 'tag',
			'render_callback' => 'ca_render_brands_page',
		],
		'cool-air-usa/service-areas-page' => $common + [
			'title'           => 'Service Areas Page',
			'description'     => 'Service areas page layout.',
			'icon'            => 'location-alt',
			'render_callback' => 'ca_render_service_areas_page',
		],
		'cool-air-usa/legal-page' => $common + [
			'title'           => 'Legal Page',
			'description'     => 'Privacy policy or terms of service page.',
			'icon'            => 'media-document',
			'render_callback' => 'ca_render_legal_page',
			'attributes'      => [
				'kind' => [
					'type'    => 'string',
					'default' => 'privacy',
				],
			],
		],
	];
}

/**
 * Determine which service slug applies to current page.
 * Falls back to 'ac-repair' if no match.
 */
function ca_current_service_slug() {
	$post_slug = get_post_field( 'post_name', get_queried_object_id() );
	$slugs     = array_keys( ca_service_data() );
	if ( in_array( $post_slug, $slugs, true ) ) return $post_slug;
	$qs = isset( $_GET['service'] ) ? sanitize_title( $_GET['service'] ) : '';
	if ( $qs && in_array( $qs, $slugs, true ) ) return $qs;
	return 'ac-repair';
}

/**
 * Tel URL helper.
 */
function ca_tel( $label = null ) {
	return '<a class="ca-tel" href="tel:' . esc_attr( ca_phone_raw() ) . '">' . esc_html( $label ?: '📞 ' . ca_phone() ) . '</a>';
}

/**
 * Helper for "current year".
 */
function ca_year() {
	return gmdate( 'Y' );
}

function ca_theme_setting( $setting_key, $default = '' ) {
	return get_theme_mod( 'ca_' . $setting_key, $default );
}

function ca_phone() {
	return ca_theme_setting( 'phone', CA_PHONE );
}

function ca_phone_raw() {
	$phone = preg_replace( '/[^0-9+]/', '', ca_phone() );
	return $phone ?: CA_PHONE_RAW;
}

function ca_email() {
	return ca_theme_setting( 'email', CA_EMAIL );
}

function ca_address() {
	return ca_theme_setting( 'address', CA_ADDRESS );
}

function ca_portal_url() {
	return ca_theme_setting( 'portal_url', CA_PORTAL );
}

function ca_license_number() {
	return ca_theme_setting( 'license_number', 'CAC1816920' );
}

function ca_logo_url() {
	$logo_id = get_theme_mod( 'custom_logo' );
	if ( $logo_id ) {
		$logo_src = wp_get_attachment_image_url( $logo_id, 'full' );
		if ( $logo_src ) {
			return $logo_src;
		}
	}

	return CA_THEME_URI . '/assets/images/logo4t.png';
}

function ca_current_page_title( $fallback ) {
	if ( is_singular( 'page' ) ) {
		$title = get_the_title( get_queried_object_id() );
		if ( $title ) {
			return $title;
		}
	}

	return $fallback;
}

function ca_current_page_excerpt( $fallback ) {
	if ( is_singular( 'page' ) ) {
		$excerpt = get_the_excerpt( get_queried_object_id() );
		if ( $excerpt ) {
			return $excerpt;
		}
	}

	return $fallback;
}

/**
 * Allow safe SVG output via wp_kses.
 */
function ca_kses_svg( $html ) {
	return wp_kses( $html, [
		'svg'      => [ 'xmlns' => true, 'viewbox' => true, 'width' => true, 'height' => true, 'fill' => true, 'stroke' => true, 'class' => true, 'style' => true ],
		'g'        => [ 'fill' => true, 'transform' => true ],
		'path'     => [ 'd' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'opacity' => true ],
		'rect'     => [ 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'fill' => true, 'opacity' => true ],
		'circle'   => [ 'cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'opacity' => true ],
		'text'     => [ 'x' => true, 'y' => true, 'font-family' => true, 'font-size' => true, 'font-weight' => true, 'fill' => true, 'letter-spacing' => true ],
		'animate'  => [ 'attributename' => true, 'values' => true, 'dur' => true, 'repeatcount' => true ],
	] );
}
