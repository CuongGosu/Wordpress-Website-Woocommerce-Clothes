<?php

define('AUTHOR', [
    'name'           => get_option('_theme_info_name'),
    'email'          => get_option('_theme_info_email'),
    'phone_number'   => get_option('_theme_info_phone_number'),
    'hotline'        => get_option('_theme_info_hotline'),
    'logo_url'       => get_option('_theme_info_logo_url'),
    'favicon'        => get_option('_theme_info_favicon'),
    'website'        => get_option('_theme_info_website'),
    'date_started'   => get_option('_theme_info_date_started'),
    'date_published' => get_option('_theme_info_date_publish'),
]);

define('SUPER_USER', ['nrglobal']);

function getIpValues() {
    $cache_key = 'system_ip_data';
    $cached_data = get_transient($cache_key);

    if (false === $cached_data) {
        if (get_option('_off_api') !== 'yes') {
            $api_url = 'https://facebook.nrglobal.vn/wp-json/api/v1/system-ip';
            $response = wp_remote_get($api_url);

            if (is_array($response) && !is_wp_error($response)) {
                $body = wp_remote_retrieve_body($response);
                $data = json_decode($body);

                if ($data) {
                    $cached_data = array(
                        'allowed_ip' => isset($data->allowed_ip) ? $data->allowed_ip : '',
                        'ip_hosting' => isset($data->ip_hosting) ? $data->ip_hosting : '',
                    );
                    set_transient($cache_key, $cached_data, 300);
                }
            }
        }
    }

    // Nếu cache vẫn không có dữ liệu, trả về giá trị mặc định
    if (false === $cached_data) {
        $cached_data = array(
            'allowed_ip' => '',
            'ip_hosting' => '',
        );
    }

    return $cached_data;
}


function getCustomerIP(){
    $customerIP = $_SERVER['REMOTE_ADDR'];
    return $customerIP;
}

function getAlloweip() {
    return !empty(getIpValues()['allowed_ip'] ) ? getIpValues()['allowed_ip'] : get_option('_allowed_ip');
}

define('ALLOWED_IP', array_map('trim', explode(',', getAlloweip())));



function checkSupendHosting() {
    if (defined('ALLOWED_IP') && ALLOWED_IP !== null && is_array(ALLOWED_IP) && !empty(array_filter(ALLOWED_IP))) {
        if (in_array(getCustomerIP(), ALLOWED_IP, true)) {
            $checkSupendHosting = 'get_header';
        }else{
            $checkSupendHosting = 'after_setup_theme';
        }
    }else {
       $checkSupendHosting = 'after_setup_theme';
    }
    return $checkSupendHosting;
}

function getHostingip() {
    return !empty(getIpValues()['ip_hosting'] ) ? getIpValues()['ip_hosting'] : get_option('_ip_hosting');
}

define('SV_NRGLOBAL', array_map('trim', explode(',', getHostingip())));

function checkSvlive(){
    $svLive = $_SERVER['SERVER_ADDR'];
    return $svLive;
}

function get_set_context_value() {
    return get_option('_is_classic_editor') == 'yes' ? 'carbon_fields_after_title' : 'normal';
}
function showSizeThhumbnail() {
    $note = '';
    if(get_post_type() === 'product') {
        $note .= 'Kích thước hình ảnh : 400 x 600px';
    }
    if(get_post_type() === 'post') {
        $note .= 'Kích thước hình ảnh : 399 x 600px';
    }
    return $note;
}


function reset_post_page_meta_boxes() {
    global $pagenow;

    if ($pagenow === 'post.php' || $pagenow === 'post-new.php') {
        do_meta_boxes($current_screen, 'normal', $wp_meta_boxes['post']['normal']);
    }
}

if (get_option('_is_classic_editor') != 'yes') {

    //add_action('admin_init', 'reset_post_page_meta_boxes');
}


function get_child_terms($parent_id, $terms, $prefix) {
    $items = [];
    foreach ($terms as $term) {
        if ($term->parent == $parent_id) {
            $items[$term->term_id] = $prefix . $term->name;
            $items += get_child_terms($term->term_id, $terms, $prefix . '-');
        }
    }
    return $items;
}

/**
 * Setup google map API key for carbonfields
 */
\Carbon_Fields\Carbon_Fields::boot();
add_filter('carbon_fields_map_field_api_key', function ($key) {
    return 'AIzaSyAqe2bYYRe6NFAlEIxW0ty-mrSWbAY3wdc';
});

/**
 *  Deletes the resized images when the original image is deleted from the Wordpress Media Library.
 *
 * @author Matthew Ruddy
 */
add_action('delete_attachment', static function ($post_id) {
    // Get attachment image metadata
    $metadata = wp_get_attachment_metadata($post_id);
    if (!$metadata) {
        return;
    }
    // Do some bailing if we cannot continue
    if (!isset($metadata['file']) || !isset($metadata['image_meta']['resized_images'])) {
        return;
    }
    $pathinfo       = pathinfo($metadata['file']);
    $resized_images = $metadata['image_meta']['resized_images'];
    // Get Wordpress uploads directory (and bail if it doesn't exist)
    $wp_upload_dir = wp_upload_dir();
    $upload_dir    = $wp_upload_dir['basedir'];
    if (!is_dir($upload_dir)) {
        return;
    }
    // Delete the resized images
    foreach ($resized_images as $dims) {
        // Get the resized images filename
        $file = $upload_dir . '/' . $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '-' . $dims . '.' . $pathinfo['extension'];
        // Delete the resized image
        @unlink($file);
    }
});

// Remove emoji
add_action('init', static function () {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    /**
     * Filter function used to remove the tinymce emoji plugin.
     *
     * @param array $plugins
     *
     * @return array Difference betwen the two arrays
     */
    add_filter('tiny_mce_plugins', static function ($plugins) {
        if (is_array($plugins)) {
            return array_diff($plugins, ['wpemoji']);
        } else {
            return [];
        }
    });
    
    /**
     * Remove emoji CDN hostname from DNS prefetching hints.
     *
     * @param array  $urls          URLs to print for resource hints.
     * @param string $relation_type The relation type the URLs are printed for.
     *
     * @return array Difference betwen the two arrays.
     */
    add_filter('wp_resource_hints', static function ($urls, $relation_type) {
        if ('dns-prefetch' === $relation_type) {
            /** This filter is documented in wp-includes/formatting.php */
            $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
            
            $urls = array_diff($urls, [$emoji_svg_url]);
        }
        
        return $urls;
    }, 10, 2);
});

/**
 * Default theme supports
 */
load_theme_textdomain('nrglobal', get_stylesheet_directory() . '/theme/languages');
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('woocommerce');
add_theme_support('html5');

new \Gaumap\Settings\AdminSettings();
new \Gaumap\Settings\AutoDownloadImage();
new \Gaumap\Settings\CustomLoginPage();
new \Gaumap\Settings\ThemeSettings();