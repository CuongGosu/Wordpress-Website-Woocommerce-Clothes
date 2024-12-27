<?php

use Overtrue\Socialite\SocialiteManager;

define('SOCIAL_DRIVER', [
    'facebook' => [
        'client_id'     => '868416699997009',
        'client_secret' => '2e15f1facbf997cfefd3c8257e85fb47',
        'redirect'      => 'https://gaumapdev.com/wp-admin/admin-ajax.php?action=social_login_callback&driver=facebook',
    ],
    'google'   => [
        'client_id'     => '956704827995-vpaq38pj35t1e2ueol5o5cevb679egnc.apps.googleusercontent.com',
        'client_secret' => 'd8END8FBqcF4-NVOyqEdvfx9',
        'redirect'      => 'https://gaumapdev.com/wp-admin/admin-ajax.php?action=social_login_callback&driver=google',
    ],
]);

add_action('wp_ajax_nopriv_google_login', 'googleLogin');
add_action('wp_ajax_google_login', 'googleLogin');
function googleLogin()
{
    if (is_user_logged_in()) {
        socialCallbackRedirectUrl();
        die();
    }
    
    $socialite = new SocialiteManager(SOCIAL_DRIVER);
    $response  = $socialite->driver('google')->redirect();
    echo $response;
}

add_action('wp_ajax_nopriv_facebook_login', 'facebookLogin');
add_action('wp_ajax_facebook_login', 'facebookLogin');
function facebookLogin()
{
    if (is_user_logged_in()) {
        socialCallbackRedirectUrl();
        die();
    }
    
    $socialite = new SocialiteManager(SOCIAL_DRIVER);
    $response  = $socialite->driver('facebook')->redirect();
    echo $response;
}

add_action('wp_ajax_nopriv_social_login_callback', 'facebookLoginCallback');
add_action('wp_ajax_social_login_callback', 'facebookLoginCallback');
function facebookLoginCallback()
{
    if (is_user_logged_in()) {
        socialCallbackRedirectUrl();
        die();
    }
    
    try {
        $socialite = new SocialiteManager(SOCIAL_DRIVER);
    
        $fbUser = $socialite->driver($_GET['driver'])->user();
    
        $args = [
            'id'       => $fbUser->getId(),        // 1472352
            'nickname' => $fbUser->getNickname(),  // "overtrue"
            'username' => $fbUser->getUsername(),  // "overtrue"
            'name'     => $fbUser->getName(),      // "安正超"
            'email'    => $fbUser->getEmail(),     // "anzhengchao@gmail.com"
            'provider' => $fbUser->getProviderName(), // GitHub
        ];
    
        $user = get_user_by_email($args['email']);
        if (!$user) {
            $userId = wp_insert_user([
                'user_login'   => $args['id'],
                'user_email'   => $args['email'],
                'display_name' => $args['email'],
            ]);
        
            if (!is_wp_error($userId)) {
                updateUserMeta($userId, 'billing_first_name', $args['name']);
                updateUserMeta($userId, 'billing_email', $args['email']);
            
                $user = get_user_by_email($args['email']);
            }
        }
    
        wp_set_current_user($user->ID, $user->user_login);
        wp_set_auth_cookie($user->ID);
        do_action('wp_login', $user->user_login, $user);
        socialCallbackRedirectUrl();
    } catch (\Exception $ex) {
        dump($ex);
    }
}

function socialCallbackRedirectUrl()
{
    echo '<script>opener.gaumap.socialLoginReturn({
                success: true,
                redirect: "/tai-khoan"
            });window.close();</script>';
}