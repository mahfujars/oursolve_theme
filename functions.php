<?php
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption']);

function oursolve_assets() {
    wp_enqueue_style('oursolve-style', get_stylesheet_uri(), [], '1.0');
    wp_enqueue_style('oursolve-main', get_template_directory_uri() . '/assets/main.css', [], '1.0');
}
add_action('wp_enqueue_scripts', 'oursolve_assets');

// Clean up WP head bloat
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head');

// Allow CORS for REST API (for external fetch calls)
add_action('rest_api_init', function() {
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
    add_filter('rest_pre_serve_request', function($value) {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET');
        return $value;
    });
}, 15);

// Excerpt length
add_filter('excerpt_length', fn() => 25);
add_filter('excerpt_more', fn() => '…');

// Custom title tag
add_filter('document_title_parts', function($parts) {
    if (is_front_page()) {
        $parts['title'] = 'Oursolve — Free Online Tools';
        unset($parts['tagline'], $parts['site']);
    } elseif (is_home()) {
        $parts['title'] = 'Blog';
        $parts['site']  = 'Oursolve';
    } elseif (isset($parts['title'])) {
        $parts['site'] = 'Oursolve';
    }
    return $parts;
});
add_filter('document_title_separator', fn() => '—');

// Remove emoji scripts (saves ~5kb)
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
