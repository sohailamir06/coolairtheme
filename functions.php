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
require_once CA_THEME_DIR . '/inc/render-services.php';
require_once CA_THEME_DIR . '/inc/render-pages.php';
require_once CA_THEME_DIR . '/inc/render-home.php';

add_action( 'after_setup_theme', function () {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form','comment-form','comment-list','gallery','caption','script','style' ] );
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
	return '<a class="ca-tel" href="tel:' . CA_PHONE_RAW . '">' . ( $label ?: '📞 ' . CA_PHONE ) . '</a>';
}

/**
 * Helper for "current year".
 */
function ca_year() {
	return gmdate( 'Y' );
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
