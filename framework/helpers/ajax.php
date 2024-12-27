<?php

/**
 * Hàm ajax để bật / tắt bài viết nổi bật
 */
add_action('wp_ajax_toggle_is_feature', 'toggleIsFeature');
function toggleIsFeature()
{
    if (empty($_POST['post_id'])) {
        wp_send_json_error('Post id mismatch');
    }
    $postId    = $_POST['post_id'];
    $isFeature = carbon_get_post_meta($postId, 'is_feature');
    carbon_set_post_meta($postId, 'is_feature', !$isFeature);
    wp_send_json_success(true);
}

/**
 * Ham ajax xu ly custom sort order
 */
add_action('wp_ajax_update_custom_sort_order', 'updateCustomSortOrder');
function updateCustomSortOrder()
{
    if (empty($_POST['post_ids']) || empty($_POST['current_page'])) {
        wp_send_json_error();
    }
    
    $postIds     = $_POST['post_ids'];
    $currentPage = (int)$_POST['current_page'];
    $order       = (($currentPage - 1) * count($postIds)) + 1;
    foreach ($postIds as $postId) {
        wp_update_post([
            'ID'         => $postId,
            'menu_order' => $order,
        ]);
        $order++;
    }
    
    wp_send_json_success();
}

/**
 * Ham ajax update post thumbnail id
 */
add_action('wp_ajax_nopriv_update_post_thumbnail_id', 'updatePostThumbnailId');
add_action('wp_ajax_update_post_thumbnail_id', 'updatePostThumbnailId');
function updatePostThumbnailId()
{
    if (empty($_POST['post_id']) || empty($_POST['attachment_id'])) {
        wp_send_json_error();
    }
    
    $postId       = $_POST['post_id'];
    $attachmentId = $_POST['attachment_id'];
    
    updatePostMeta($postId, '_thumbnail_id', $attachmentId);
    
    wp_send_json_success(true);
}

/**
 * Hàm ajax send form liên hệ.
 * Các thông số truyền lên bao gồm: action, _token, name, email, phone_number, subject, message
 */
add_action('wp_ajax_nopriv_send_contact_form', 'sendContactForm');
add_action('wp_ajax_send_contact_form', 'sendContactForm');
function sendContactForm()
{
    if (empty($_POST['_token']) || !wp_verify_nonce($_POST['_token'], 'send_contact_form')) {
        wp_send_json_error(__('Token mistake.'));
    }
    
    $blogName = get_bloginfo('name');
    $blogUrl  = get_bloginfo('url');
    
    $html = "<p>Gửi từ: {$_POST['name']} {$_POST['email']}</p>
             <p>Số điện thoại: {$_POST['phone_number']}</p>
             <p>Chủ đề: {$_POST['subject']}</p>
             <p>Nội dung:</p>
             <p>{$_POST['message']}</p>
             <p>This email is sent from the contact form of the {$blogName} ({$blogUrl})</p>";
    
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        "Reply-To: {$_POST['name']} <{$_POST['email']}>",
    ];

    $html_reply = "<p>Chúng tôi đã nhận được yêu cầu liên hệ. Dưới đây là thông tin liên hệ của bạn: </p>
             <p>Người gửi: {$_POST['name']} {$_POST['email']}</p>
             <p>Số điện thoại: {$_POST['phone_number']}</p>
             <p>Chủ đề: {$_POST['subject']}</p>
             <p>Nội dung:</p>
             <p>{$_POST['message']}</p>
             <p>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất. Xin cám ơn !</p>
             <p>This email is sent from the contact form of the {$blogName} ({$blogUrl})</p>";
    
    $headers_reply = [
        'Content-Type: text/html; charset=UTF-8',
        "Reply-To: {$blogName} <".get_option('admin_email').">",
    ];
    
    $success = wp_mail(get_option('admin_email'), $blogName . ': ' . $_POST['subject'], $html, $headers);
    $success_reply = wp_mail($_POST['email'], $blogName . ': ' . $_POST['subject'], $html_reply, $headers_reply);
    
    if ($success) {
        wp_send_json_success([
            'message' => __('Yêu cầu của bạn đã được hệ thống ghi nhận.', 'gaumap'),
        ]);
    }
    if ($success_reply) {
        wp_send_json_success([
            'message' => __('Yêu cầu của bạn đã được hệ thống ghi nhận.', 'gaumap'),
        ]);
    }
    
    wp_send_json_error([
        'message' => __('Đã có lỗi xảy ra, xin vui lòng thử lại.', 'gaumap'),
    ]);
}

add_action('wp_ajax_nopriv_faker_posts', 'fakerPosts');
add_action('wp_ajax_faker_posts', 'fakerPosts');
function fakerPosts()
{
    $faker = new \Gaumap\Settings\FakerData();
    $faker->createSamplePosts('post', 2);
    wp_send_json_success(true);
}


add_action('wp_ajax_nopriv_send_register_form', 'sendRegisteForm');
add_action('wp_ajax_send_register_form', 'sendRegisteForm');
function sendRegisteForm()
{
    check_ajax_referer('send_register_form', '_token', true);
    
    $blogName = get_bloginfo('name');
    $blogUrl  = get_bloginfo('url');

    $_POST['subject'] = __('Đăng ký nhận tin', 'nrglobal');
    
    $html = "<p>Email đăng ký nhận tin: {$_POST['register_email']}</p>
             <p>This email is sent from the register form of the {$blogName} ({$blogUrl})</p>";
    
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        "Reply-To: <{$_POST['register_email']}>",
    ];

    
    $success = wp_mail(get_option('admin_email'), $blogName . ': ' . $_POST['subject'], $html, $headers);
    
    if ($success) {
        wp_send_json_success([
            'message' => __('Yêu cầu của bạn đã được hệ thống ghi nhận.', 'gaumap'),
        ]);
    }
    
    wp_send_json_error([
        'message' => __('Đã có lỗi xảy ra, xin vui lòng thử lại.', 'gaumap'),
    ]);
}