<?php
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'CA_DYNAMIC_CONTENT_META_KEY', '_ca_dynamic_content' );

function ca_dynamic_content( $content_key, $defaults = [], $post_id = 0 ) {
	$post_id = $post_id ?: ca_dynamic_current_post_id();
	$saved   = $post_id ? get_post_meta( $post_id, CA_DYNAMIC_CONTENT_META_KEY, true ) : [];

	if ( ! is_array( $saved ) ) {
		$saved = [];
	}

	return ca_dynamic_merge_defaults( $defaults, $saved );
}

function ca_dynamic_current_post_id() {
	$post_id = get_queried_object_id();

	if ( ! $post_id && is_admin() && isset( $_GET['post'] ) ) {
		$post_id = absint( $_GET['post'] );
	}

	if ( ! $post_id && is_admin() && isset( $_POST['post_ID'] ) ) {
		$post_id = absint( $_POST['post_ID'] );
	}

	return $post_id;
}

function ca_dynamic_page_key( $post_id = 0 ) {
	$post_id = $post_id ?: ca_dynamic_current_post_id();
	if ( ! $post_id ) {
		return '';
	}

	$slug = get_post_field( 'post_name', $post_id );
	if ( ! $slug ) {
		return '';
	}

	return sanitize_title( $slug );
}

function ca_dynamic_merge_defaults( $defaults, $saved ) {
	if ( ! is_array( $defaults ) || ! is_array( $saved ) ) {
		return $saved !== '' && $saved !== null ? $saved : $defaults;
	}

	foreach ( $saved as $key => $value ) {
		if ( array_key_exists( $key, $defaults ) && is_array( $defaults[ $key ] ) && is_array( $value ) ) {
			$defaults[ $key ] = ca_dynamic_merge_defaults( $defaults[ $key ], $value );
			continue;
		}

		$defaults[ $key ] = $value;
	}

	return $defaults;
}

function ca_dynamic_defaults_for_post( $post_id ) {
	$key = ca_dynamic_page_key( $post_id );
	if ( ! $key ) {
		return [];
	}

	$service_data = ca_service_data();
	if ( isset( $service_data[ $key ] ) && function_exists( 'ca_service_content_defaults' ) ) {
		return ca_service_content_defaults( $key );
	}

	$function_name = 'ca_' . str_replace( '-', '_', $key ) . '_page_content_defaults';
	if ( function_exists( $function_name ) ) {
		return $function_name();
	}

	if ( $key === 'home' && function_exists( 'ca_home_content_defaults' ) ) {
		return ca_home_content_defaults();
	}

	if ( in_array( $key, [ 'privacy-policy', 'terms-of-service' ], true ) && function_exists( 'ca_legal_page_content_defaults' ) ) {
		return ca_legal_page_content_defaults( $key );
	}

	return [];
}

function ca_dynamic_sanitize( $value ) {
	if ( is_array( $value ) ) {
		$clean = [];
		foreach ( $value as $key => $child_value ) {
			$clean_key           = is_numeric( $key ) ? (int) $key : sanitize_key( $key );
			$clean[ $clean_key ] = ca_dynamic_sanitize( $child_value );
		}
		return $clean;
	}

	return wp_kses_post( wp_unslash( (string) $value ) );
}

add_action( 'add_meta_boxes_page', function ( $post ) {
	if ( ! ca_dynamic_defaults_for_post( $post->ID ) ) {
		return;
	}

	add_meta_box(
		'ca_dynamic_content',
		__( 'Cool Air USA Dynamic Content', 'cool-air-usa' ),
		'ca_dynamic_content_meta_box',
		'page',
		'normal',
		'high'
	);
} );

function ca_dynamic_content_meta_box( $post ) {
	$defaults = ca_dynamic_defaults_for_post( $post->ID );
	$content  = ca_dynamic_content( ca_dynamic_page_key( $post->ID ), $defaults, $post->ID );

	wp_nonce_field( 'ca_dynamic_content_save', 'ca_dynamic_content_nonce' );
	echo '<p class="description">' . esc_html__( 'Edit the content below to update the rendered page without changing theme code. Empty fields fall back to the existing design defaults.', 'cool-air-usa' ) . '</p>';
	echo '<div class="ca-dynamic-fields">';
	ca_dynamic_render_fields( $content, 'ca_dynamic_content' );
	echo '</div>';
}

function ca_dynamic_render_fields( $value, $name, $label = '' ) {
	if ( is_array( $value ) ) {
		$is_list = array_keys( $value ) === range( 0, count( $value ) - 1 );
		if ( $label ) {
			echo '<details class="ca-dynamic-group" open><summary>' . esc_html( ca_dynamic_label( $label ) ) . '</summary>';
		} else {
			echo '<div class="ca-dynamic-group">';
		}

		foreach ( $value as $key => $child_value ) {
			$child_name  = $name . '[' . esc_attr( $key ) . ']';
			$child_label = $is_list ? sprintf( __( 'Item %d', 'cool-air-usa' ), (int) $key + 1 ) : (string) $key;
			ca_dynamic_render_fields( $child_value, $child_name, $child_label );
		}

		echo $label ? '</details>' : '</div>';
		return;
	}

	$field_id = 'ca_dynamic_' . md5( $name );
	echo '<p class="ca-dynamic-field">';
	echo '<label for="' . esc_attr( $field_id ) . '"><strong>' . esc_html( ca_dynamic_label( $label ) ) . '</strong></label>';

	$type = ca_dynamic_input_type( $label, $value );
	if ( $type === 'textarea' ) {
		echo '<textarea id="' . esc_attr( $field_id ) . '" name="' . esc_attr( $name ) . '" rows="3" class="large-text">' . esc_textarea( $value ) . '</textarea>';
	} else {
		echo '<input id="' . esc_attr( $field_id ) . '" name="' . esc_attr( $name ) . '" type="' . esc_attr( $type ) . '" value="' . esc_attr( $value ) . '" class="widefat">';
	}

	echo '</p>';
}

function ca_dynamic_input_type( $label, $value ) {
	$label = strtolower( (string) $label );
	if ( strpos( $label, 'url' ) !== false || strpos( $label, 'href' ) !== false || strpos( $label, 'link' ) !== false || strpos( $label, 'image' ) !== false ) {
		return 'url';
	}

	if ( strlen( (string) $value ) > 90 || strpos( (string) $value, "\n" ) !== false || strpos( (string) $value, '<' ) !== false ) {
		return 'textarea';
	}

	return 'text';
}

function ca_dynamic_label( $key ) {
	$key = preg_replace( '/[_-]+/', ' ', (string) $key );
	return ucwords( $key );
}

add_action( 'save_post_page', function ( $post_id ) {
	if ( ! isset( $_POST['ca_dynamic_content_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ca_dynamic_content_nonce'] ) ), 'ca_dynamic_content_save' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	if ( ! isset( $_POST['ca_dynamic_content'] ) || ! is_array( $_POST['ca_dynamic_content'] ) ) {
		delete_post_meta( $post_id, CA_DYNAMIC_CONTENT_META_KEY );
		return;
	}

	update_post_meta( $post_id, CA_DYNAMIC_CONTENT_META_KEY, ca_dynamic_sanitize( $_POST['ca_dynamic_content'] ) );
} );

add_action( 'admin_head-post.php', 'ca_dynamic_content_admin_styles' );
add_action( 'admin_head-post-new.php', 'ca_dynamic_content_admin_styles' );

function ca_dynamic_content_admin_styles() {
	$screen = get_current_screen();
	if ( ! $screen || $screen->post_type !== 'page' ) {
		return;
	}
	?>
	<style>
		.ca-dynamic-fields { display: grid; gap: 12px; }
		.ca-dynamic-group { border: 1px solid #dcdcde; border-radius: 6px; padding: 12px; background: #fff; }
		.ca-dynamic-group .ca-dynamic-group { margin-top: 10px; background: #f8f9fa; }
		.ca-dynamic-group summary { cursor: pointer; font-weight: 700; font-size: 14px; }
		.ca-dynamic-field { margin: 10px 0 0; }
		.ca-dynamic-field label { display: block; margin-bottom: 4px; }
		.ca-dynamic-field textarea { min-height: 72px; }
	</style>
	<?php
}
