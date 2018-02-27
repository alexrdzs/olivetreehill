<?php

function thim_child_enqueue_styles()
	{

	// Enqueue parent style

	wp_enqueue_style('thim-parent-style', get_template_directory_uri() . '/style.css');
	}

add_action('wp_enqueue_scripts', 'thim_child_enqueue_styles', 100);

// Hide the "Please update now" notification
function hide_update_notice() {
    get_currentuserinfo();
    if (!current_user_can('manage_options')) {
        remove_action( 'admin_notices', 'update_nag', 3 );
    }
}
add_action( 'admin_notices', 'hide_update_notice', 1 );
remove_filter( 'map_meta_cap', 'flamingo_map_meta_cap' );
add_filter( 'map_meta_cap', 'mycustom_flamingo_map_meta_cap', 9, 4 );

function mycustom_flamingo_map_meta_cap( $caps, $cap, $user_id, $args ) {
    $meta_caps = array(
        'flamingo_edit_contacts' => 'publish_posts',
        'flamingo_edit_contact' => 'publish_posts',
        'flamingo_delete_contact' => 'publish_posts',
        'flamingo_edit_inbound_messages' => 'publish_posts',
        'flamingo_delete_inbound_message' => 'publish_posts',
        'flamingo_delete_inbound_messages' => 'publish_posts',
        'flamingo_spam_inbound_message' => 'publish_posts',
        'flamingo_unspam_inbound_message' => 'publish_posts' );

    $caps = array_diff( $caps, array_keys( $meta_caps ) );

    if ( isset( $meta_caps[$cap] ) )
        $caps[] = $meta_caps[$cap];

    return $caps;
}