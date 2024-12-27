<?php

namespace Gaumap\Settings;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Intervention\Image\ImageManagerStatic as Image;

class AdminSettings
{
    protected $currentUser;
    
    protected $superUsers = SUPER_USER;
    
    protected $errorMessage = '';
    
    public function __construct()
    {
        $this->currentUser = wp_get_current_user();
        $this->addNRGlobalContactWidget();
        $this->changeFontRoboto();
        $this->replaceWordpressLogo();
        $this->removeDefaultWidgets();
        $this->removeDashboardWidgets();
        $this->changeHeaderUrl();
        $this->changeHeaderTitle();
        $this->changeFooterCopyright();
        $this->customizeAdminBar();
        $this->renameUploadFileName();
        $this->resizeOriginalImageAfterUpload();
        $this->addCustomResources();
        $this->requireScripts();
        $this->example_theme_support();
        $this->remove_woo_widgets();
        $this->ration_add_featured_image_html();
        $this->noteFeatureImage();
        $this->collectLogintime();
        $this->showTimeLogin();
        $this->shortUserLogin();
        
        if (in_array($this->currentUser->user_login, $this->superUsers, true)) {
            if (defined('ALLOWED_IP') && ALLOWED_IP !== null && is_array(ALLOWED_IP) && !empty(array_filter(ALLOWED_IP))) {
                if (in_array(getCustomerIP(), ALLOWED_IP, true)) {
                    $this->createAdminOptions();
                }
            }else {
                $this->createAdminOptions();
            }
        } else {
            $this->hideSuperUsers();
            $this->setupErrorMessage();
            $this->checkIsMaintenance();
            $this->disablePluginPage();
            $this->disableOptionsReadPage();
            $this->disableAllUpdate();
            $this->removeUnnecessaryMenus();
            $this->offInfoUpdateWp();
            $this->viewCountUsers();
            $this->custom_allowed_block_types();
            $this->my_switch_user();
            if (defined('SV_NRGLOBAL') && SV_NRGLOBAL !== null && is_array(SV_NRGLOBAL) && !empty(array_filter(SV_NRGLOBAL))) {
                if (in_array(checkSvlive(), SV_NRGLOBAL, true)) {
                    if (get_option('_off_close') != 'yes' && get_option('_theme_info_started_hosting') != '') {
                        $this->checkIsCloseHosting();
                    }
                }
            }else{
                if (get_option('_off_close') != 'yes' && get_option('_theme_info_started_hosting') != '') {
                    $this->checkIsCloseHosting();
                }
            }
        }

        if (get_option('_disable_admin_confirm_email') === 'yes') {
            $this->disableChangeAdminEmailRequireConfirm();
        }

        if (get_option('_disable_use_weak_password') === 'yes') {
            $this->disableCheckboxUseWeakPassword();
        }
        if (defined('SV_NRGLOBAL') && SV_NRGLOBAL !== null && is_array(SV_NRGLOBAL) && !empty(array_filter(SV_NRGLOBAL))) {
            if (in_array(checkSvlive(), SV_NRGLOBAL, true)) {
                if (get_option('_off_info') != 'yes' && get_option('_theme_info_started_hosting') != '') {
                    $this->insertInfomation();
                }
            }
        }else{
            if (get_option('_off_info') != 'yes' && get_option('_theme_info_started_hosting') != '') {
                $this->insertInfomation();
            }
        }
        if(get_option('_is_classic_editor') == 'yes'){
            $this->classic_editor();
        }
    }

    public function disableCheckboxUseWeakPassword()

    {

        add_action('admin_head', function () {

            ?>

            <script>

                jQuery(document).ready(function () {

                    jQuery('.pw-weak').remove();

                });

            </script>

            <?php

        });

        

        add_action('login_enqueue_scripts', function () {

            ?>

            <script>

                document.addEventListener("DOMContentLoaded", function (event) {

                    let elements = document.getElementsByClassName('pw-weak');

                    console.log(elements);

                    let requiredElement = elements[0];

                    requiredElement.remove();

                });

            </script>

            <?php

        });

    }

    public function disableChangeAdminEmailRequireConfirm()

    {

        remove_action('add_option_new_admin_email', 'update_option_new_admin_email');

        remove_action('update_option_new_admin_email', 'update_option_new_admin_email');

        

        add_action('add_option_new_admin_email', function ($old_value, $value) {

            update_option('admin_email', $value);

        }, 10, 2);

        

        add_action('update_option_new_admin_email', function ($old_value, $value) {

            update_option('admin_email', $value);

        }, 10, 2);

    }

    public function insertInfomation()

    {
        add_action( 'admin_notices', function(){
            $startTime = date(get_option('_theme_info_started_hosting'));//khởi tạo
            $startDay = explode(' ', $startTime);
            if(get_option('_theme_info_end_hosting') != ''){
                $endTime = date(get_option('_theme_info_end_hosting'));
            }else{
                $endTime = date('Y-m-d H:i:s',strtotime('+1 year',strtotime($startTime)));
            }
            $endDay = explode(' ', $endTime);
    ?>
            <div class="admin_notices" style="padding: 20px 5px 5px 5px">
                <p>
                    Quý khách đang sử dụng dịch vụ hosting của công ty 
                    <a href="<?php echo AUTHOR['website'] ?>" target="_blank"><?php echo AUTHOR['name'] ?></a>. 
                    Ngày đăng ký : <span style="color: #ff0000"><?php echo date('d-m-Y', strtotime($startDay[0])) ?></span>.
                    Ngày hết hạn : <span style="color: #ff0000"><?php echo date('d-m-Y', strtotime($endDay[0])) ?></span>.
                    Thời gian còn lại : <span id="countdown" style="color: #ff0000"></span>
                </p>
                <script type="text/javascript">
                    var countDownDate = new Date("<?php echo $endTime ?>").getTime();

                    // Update the count down every 1 second
                    var x = setInterval(function() {

                        // Get today's date and time
                        var now = new Date().getTime();

                        // Find the distance between now and the count down date
                        var distance = countDownDate - now;

                        // Time calculations for days, hours, minutes and seconds
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // Output the result in an element with id="demo"
                        document.getElementById("countdown").innerHTML = days + " ngày " + hours +  "h : " +
                            minutes + "m : " + seconds + 's';

                        // If the count down is over, write some text 
                        if (distance < 0) {
                            clearInterval(x);
                            document.getElementById("countdown").innerHTML = "Hosting của quý khách đã hết hạn sử dụng !";
                        }
                    }, 1000);
                </script>
            </div>
        <?php });

    }
    
    public function addNRGlobalContactWidget()
    {
        add_action('wp_dashboard_setup', static function () {
            wp_add_dashboard_widget('custom_help_widget', 'Giới thiệu', static function () { ?>
                <div style="position: relative;">
                    <div style="text-align:center">
                        <a target="_blank" href="<?php echo AUTHOR['website'] ?>" title="<?php echo AUTHOR['name'] ?>">
                            <img style="width:50%" src="<?php echo AUTHOR['logo_url'] ?>" alt="<?php echo AUTHOR['name'] ?>" title="<?php echo AUTHOR['name'] ?>">
                        </a>
                    </div>
                    <h2 style="text-align:center">Hệ thống Quản Trị Website <?php echo AUTHOR['name'] ?></h2>
                    <div style="margin-top:20px">
                        <h3><strong>THÔNG TIN WEBSITE</strong></h3>
                        <p>Tên website: <strong><?php echo bloginfo('name'); ?></strong></p>
                        <p>Url website: <strong><?php echo bloginfo('url'); ?></strong></p>
                    </div>
                    <div style="margin-top:20px">
                        <h3><strong>NHÀ PHÁT TRIỂN</strong></h3>
                        <p>Hệ thống được phát triển bởi <a target="_blank" href="<?php echo AUTHOR['website'] ?>"><strong><?php echo AUTHOR['name'] ?></strong></a></p>
                        <p>Mọi yêu cầu, hỗ trợ quý khách hàng vui lòng liên hệ <strong>Bộ phận kỹ thuật</strong></p>
                        <p><strong>Điện thoại</strong>: <a href="tel:<?php echo AUTHOR['phone_number'] ?>" style="color:red"><?php echo AUTHOR['phone_number'] ?></a></p>
                        <p><strong>Hotline</strong>: <a href="tel:<?php echo AUTHOR['hotline'] ?>" style="color:red"><?php echo AUTHOR['hotline'] ?></a></p>
                        <p><strong>Email</strong>: <a style="color:red" href="mailto:<?php echo AUTHOR['email'] ?>"><?php echo AUTHOR['email'] ?></a></p>
                    </div>
                    <p><strong>Cảm ơn quý khách đã tin tưởng và sử dụng sản phẩm của <a target="_blank" href="<?php echo AUTHOR['website'] ?>" title="<?php echo AUTHOR['name'] ?>"><?php echo AUTHOR['name'] ?></a>.</strong></p>
                </div>
            <?php });
        });
    }
    
    public function changeFontRoboto()
    {
        add_action('admin_head', function () { ?>
            <script src="//ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
            <script>
                WebFont.load({
                    google: {
                        'families': [
                            "Montserrat:300,400,500,600,700,800,900",
                            'Nunito:200,300,400,600,700,800,900',
                            'Roboto:300,400,500,600,700'
                        ]
                    },
                    active: function () {
                        sessionStorage.fonts = true;
                    }
                });
            </script>

            <style>
                html, body
                {
                    font-family : Roboto, sans-serif !important;
                }
            </style>
        
        <?php });
    }
    
    public function replaceWordpressLogo()
    {
        add_action('wp_before_admin_bar_render', static function () {
            ?>
            <style type="text/css">

            </style>
            <?php
        }, 0);
    }
    
    public function removeDefaultWidgets()
    {
        add_action('widgets_init', static function () {
            unregister_widget('WP_Widget_Pages');
            unregister_widget('WP_Widget_Calendar');
            unregister_widget('WP_Widget_Archives');
            unregister_widget('WP_Widget_Links');
            unregister_widget('WP_Widget_Meta');
            unregister_widget('WP_Widget_Search');
            unregister_widget('WP_Widget_Categories');
            unregister_widget('WP_Widget_Recent_Posts');
            unregister_widget('WP_Widget_Recent_Comments');
            unregister_widget('WP_Widget_RSS');
            unregister_widget('WP_Widget_Tag_Cloud');
            unregister_widget('WP_Nav_Menu_Widget');
        });
    }
    
    public function removeDashboardWidgets()
    {
        add_action('admin_init', static function () {
            remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); // right now
            remove_meta_box('dashboard_activity', 'dashboard', 'normal');// WP 3.8
            remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // recent comments
            remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); // incoming links
            remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); // plugins
            remove_meta_box('dashboard_quick_press', 'dashboard', 'normal'); // quick press
            remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal'); // recent drafts
            remove_meta_box('dashboard_primary', 'dashboard', 'normal'); // wordpress blog
            remove_meta_box('dashboard_secondary', 'dashboard', 'normal'); // other wordpress news
            remove_meta_box('dashboard_site_health', 'dashboard', 'normal'); // dashboard_site_health
        });
    }
    
    public function changeHeaderUrl()
    {
        add_filter('login_headerurl', static function ($url) {
            return '' . AUTHOR['website'] . '';
        });
    }
    
    public function changeHeaderTitle()
    {
        add_filter('login_headertitle', static function () {
            return get_option('blogname');
        });
    }
    
    public function changeFooterCopyright()
    {
        add_filter('admin_footer_text', static function () {
            echo 'Website được phát triển bởi <a href="' . AUTHOR['website'] . '" target="_blank">' . AUTHOR['name'] . '</a>';
        });
    }

        public function offInfoUpdateWp(){
            add_action('admin_footer', function () {
?>
                <style type="text/css">
                    .update-nag, .notice-error{
                        display: none !important;
                    }
                </style>      
<?php
        });
    }

    public function viewCountUsers(){
        add_filter( 'views_users', function($views){
           $users = count_users();
           $admins_num = $users['avail_roles']['administrator'] - 1;
           $all_num = $users['total_users'] - 1;
           $class_adm = ( strpos($views['administrator'], 'current') === false ) ? "" : "current";
           $class_all = ( strpos($views['all'], 'current') === false ) ? "" : "current";
           $views['administrator'] = '<a href="users.php?role=administrator" class="' . $class_adm . '">' . translate_user_role('Administrator') . ' <span class="count">(' . $admins_num . ')</span></a>';
           $views['all'] = '<a href="users.php" class="' . $class_all . '">' . __('All') . ' <span class="count">(' . $all_num . ')</span></a>';
           return $views;
        });
    }
    
    public function customizeAdminBar()
    {
        $author = AUTHOR;
        add_action('wp_before_admin_bar_render', static function () use ($author) {
            global $wp_admin_bar;
            $wp_admin_bar->remove_menu('wp-logo');          // Remove the Wordpress logo
            $wp_admin_bar->remove_menu('about');            // Remove the about Wordpress link
            $wp_admin_bar->remove_menu('wporg');            // Remove the Wordpress.org link
            $wp_admin_bar->remove_menu('documentation');    // Remove the Wordpress documentation link
            $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
            $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
            // $wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
            $wp_admin_bar->remove_menu('view-site');        // Remove the view site link
            $wp_admin_bar->remove_menu('updates');          // Remove the updates link
            $wp_admin_bar->remove_menu('comments');         // Remove the comments link
            $wp_admin_bar->remove_menu('new-content');      // Remove the content link
            $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
            // $wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
        }, 7);
        
        add_action('admin_bar_menu', static function ($wp_admin_bar) use ($author) {
            $args = [
                'id'    => 'logo_author',
                'title' => '<img src="' . $author['favicon'] . '" style="height:25px;padding-top:3px;">',
                'href'  => $author['website'],
                'meta'  => [
                    'target' => '_blank',
                ],
            ];
            $wp_admin_bar->add_node($args);
            
            // $args = [
            //     'id'    => 'theme_author',
            //     'title' => $author['name'],
            //     'href'  => $author['website'],
            //     'meta'  => [
            //         'target' => '_blank',
            //     ],
            // ];
            // $wp_admin_bar->add_node($args);
        }, 10);
    }
    
    public function renameUploadFileName()
    {
        add_filter('sanitize_file_name', static function ($filename) {
            $info = pathinfo($filename);
            $ext  = empty($info['extension']) ? '' : '.' . $info['extension'];
            return strToSlug(str_replace($ext, '', $filename)) . $ext;
        }, 10);
    }
    
    public function resizeOriginalImageAfterUpload()
    {
        add_filter('intermediate_image_sizes_advanced', static function ($sizes) {
            $imgSize = [
                'medium',
                'medium_large',
                'large',
                'full',
                'woocommerce_single',
                'woocommerce_gallery_thumbnail',
                'shop_catalog',
                'shop_single',
                'woocommerce_thumbnail',
                'shop_thumbnail',
            ];
            foreach ($imgSize as $item) {
                if (array_key_exists($item, $sizes)) {
                    unset($sizes[$item]);
                }
            }
            return $sizes;
        });
        
        add_filter('wp_generate_attachment_metadata', static function ($image_data) {
            $upload_dir = wp_upload_dir();
            $imgPath    = $upload_dir['basedir'] . '/' . $image_data['file'];
            // $image      = Image::make($imgPath);
            // if ($image->width() > 1920) {
            //     $image->resize(1920);
            // }
            // if ($image->height() > 1080) {
            //     $image->resize(null, 1080);
            // }
            //$image->save($imgPath, 85);
            return $image_data;
        });
    }
    
    public function addCustomResources()
    {
        add_action('admin_enqueue_scripts', static function ($hook) {
            wp_enqueue_script('jquery_repeater', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js');
            wp_enqueue_script('gm_custom_admin_script', get_stylesheet_directory_uri() . '/framework/assets/js/admin.js');
        });
    }
    
    public function createAdminOptions()
    {
        add_action('carbon_fields_register_fields', static function () {
            $options = Container::make('theme_options', __('Admin', 'nrglobal'))
                                ->set_page_file(__('admin-settings', 'nrglobal'))
                                ->set_page_menu_position(2)
                                ->add_fields([
                                    Field::make('checkbox', 'is_maintenance', __('Bật chế độ bảo trì website', 'nrglobal')),
                                    Field::make('checkbox', 'is_classic_editor', __('Sử dụng trình soạn thảo cổ điển', 'nrglobal')),
                                    Field::make('checkbox', 'use_yoast_breadcrumb', __('Sử dụng Yoast SEO breadcrumb', 'nrglobal')),
                                    Field::make('checkbox', 'disable_admin_confirm_email', __('Tắt tính năng đổi email admin cần phải xác minh email', 'nrglobal')),
                                    Field::make('checkbox', 'disable_use_weak_password', __('Tắt tính năng cho phép sử dụng mật khẩu yếu', 'nrglobal')),
                                    Field::make('checkbox', 'off_info', __('Tắt tính năng thông báo gia hạn hosting', 'nrglobal')),
                                    Field::make('checkbox', 'off_close', __('Tắt tính năng khóa hosting khi hết hạn', 'nrglobal')),
                                    Field::make('checkbox', 'off_api', __('Tắt tính năng API IP', 'nrglobal')),
                                    Field::make('separator', 'gm_sep_1', __('Tùy chỉnh render ảnh', 'nrglobal')),
                                    Field::make('checkbox', 'use_php_image_magick', __('Sử dụng thư viện PHP ImageMagick để xử lý ảnh', 'nrglobal')),
                                    Field::make('radio', 'use_image_ext', __('Render chuẩn ảnh'))
                                         ->set_width(50)
                                         ->set_default_value('default')
                                         ->set_options([
                                             'default' => __('Dùng chuẩn mặc định của ảnh', 'nrglobal'),
                                             'fixed'   => __('Render ra chuẩn ảnh cố định', 'nrglobal'),
                                         ]),
                                    Field::make('text', 'fixed_image_ext', __('Chuẩn ảnh cố định', 'nrglobal'))
                                         ->set_default_value('webp'),
                                ]);
            
            Container::make('theme_options', __('SMTP', 'nrglobal'))
                     ->set_page_file(__('cai-dat-smtp', 'nrglobal'))
                     ->set_page_parent($options)
                     ->add_fields([
                         Field::make('checkbox', 'use_smtp', __('Sử dụng SMTP để gửi mail', 'nrglobal')),
                         Field::make('separator', 'smtp_separator_1', __('Thông tin máy chủ SMTP', 'nrglobal')),
                         Field::make('text', 'smtp_host', __('Địa chỉ máy chủ', 'nrglobal'))
                              ->set_default_value('smtp.gmail.com'),
                         Field::make('text', 'smtp_port', __('Cổng máy chủ', 'nrglobal'))
                              ->set_default_value('587'),
                         Field::make('text', 'smtp_secure', __('Phương thức mã hóa', 'nrglobal'))
                              ->set_default_value('tls'),
                         Field::make('separator', 'smtp_separator_2', __('Thông tin email hệ thống', 'nrglobal')),
                         Field::make('text', 'smtp_username', __('Địa chỉ email', 'nrglobal'))
                              ->set_default_value('whethong@gmail.com'),
                         Field::make('text', 'smtp_password', __('Mật khẩu', 'nrglobal'))->set_attribute('type', 'password')->set_default_value('1234567890'),
                     ]);
            
            Container::make('theme_options', __('Theme info', 'nrglobal'))
                     ->set_page_parent($options)
                     ->add_fields([
                         Field::make('text', 'theme_info_name', __('Tên', 'nrglobal'))->set_default_value('NR Global'),
                         Field::make('text', 'theme_info_email', __('Email', 'nrglobal'))->set_default_value('info@nrglobal.vn'),
                         Field::make('text', 'theme_info_phone_number', __('Điện thoại', 'nrglobal'))->set_default_value('0935 1919 03'),
                         Field::make('text', 'theme_info_hotline', __('Hotline', 'nrglobal'))->set_default_value('0236 777 8686'),
                         Field::make('text', 'theme_info_logo_url', __('Link logo', 'nrglobal'))->set_default_value('https://nrglobal.vn/wp-content/uploads/2018/12/nr-global.gif'),
                         Field::make('text', 'theme_info_favicon', __('Link favicon', 'nrglobal'))->set_default_value('https://nrglobal.vn/wp-content/uploads/2018/06/favicon.png'),
                         Field::make('text', 'theme_info_website', __('Website hỗ trợ', 'nrglobal'))->set_default_value('https://nrglobal.vn'),
                         Field::make('date', 'theme_info_date_started', __('Ngày bắt đầu thực hiện', 'nrglobal')),
                         Field::make('date', 'theme_info_date_publish', __('Ngày bàn giao', 'nrglobal')),
                         Field::make('date_time', 'theme_info_started_hosting', __('Ngày đăng ký hosting', 'nrglobal')),
                         Field::make('date_time', 'theme_info_end_hosting', __('Ngày hết hạn hosting', 'nrglobal')),
                         Field::make('text', 'allowed_ip', __('Allowed IP', 'nrglobal'))->help_text('Ex: 127.1.1.1,128.1.1.1,'),
                         Field::make('text', 'ip_hosting', __('IP Hosting', 'nrglobal'))->help_text('Ex: 127.1.1.1,128.1.1.1,'),
                     ]);
        });
    }
    
    public function hideSuperUsers()
    {
        add_action('pre_user_query', function ($user_search) {
            global $wpdb;
            $superUsers               = "('" . implode("','", $this->superUsers) . "')";
            $user_search->query_where = str_replace('WHERE 1=1', "WHERE 1=1 AND {$wpdb->users}.user_login NOT IN " . $superUsers, $user_search->query_where);
        });
    }
    
    public function setupErrorMessage()
    {
        $this->errorMessage = '
                    <div style="position: relative;">
                        <div style="text-align:center">
                            <a target="_blank" href="' . AUTHOR['website'] . '">
                                <img style="width:50%" src="' . AUTHOR['logo_url'] . '" alt="' . AUTHOR['name'] . '">
                            </a>
                        </div>
                        <h2>Xin lỗi, bạn không có quyền truy cập vào nội dung này</h2>
                        <div>
                            <h3><strong>NHÀ PHÁT TRIỂN</strong></h3>
                            <p>Hệ thống được phát triển bởi <a target="_blank" href="' . AUTHOR['website'] . '"><strong>' . AUTHOR['name'] . '</strong></a></p>
                            <p>Mọi yêu cầu, hỗ trợ quý khách hàng có thể liên hệ <strong>Phòng Kỹ Thuật</strong></p>
                            <p><strong>Điện thoại</strong>: <a href="tel:' . AUTHOR['phone_number'] . '" style="color:red">' . AUTHOR['phone_number'] . '</a> - <a href="tel:' . AUTHOR['hotline'] . '" style="color:red">' . AUTHOR['hotline'] . '</a></p>
                            <p>
                                <strong>Website:</strong> <a target="_blank" href="' . AUTHOR['website'] . '" style="color:red;"">' . AUTHOR['website'] . '</a> -
                                <strong>Email</strong>: <a style="color:red" href="mailto:' . AUTHOR['email'] . '">' . AUTHOR['email'] . '</a>
                            </p>
                        </div>
                        <p><strong>Cảm ơn quý khách đã tin tưởng và sử dụng sản phẩm của <a target="_blank" href="' . AUTHOR['website'] . '">' . AUTHOR['name'] . '</a>.</strong></p>
                    </div>';
    }
    
    public function checkIsMaintenance()
    {
        add_action('get_header', static function () {
            if (get_option('_is_maintenance') === 'yes') {
                wp_die('
                    <div style="position: relative;">
                        <div style="text-align:center">
                            <a target="_blank" href="' . AUTHOR['website'] . '">
                                <img style="width:50%" src="' . AUTHOR['logo_url'] . '" alt="' . AUTHOR['name'] . '">
                            </a>
                        </div>
                        <h2 style="text-align:center">Hệ thống hiện đang được bảo trì, xin quý khách vui lòng quay lại sau ít phút.</h2>
                        <div style="text-align:center">
                            <h3>Hệ thống được phát triển bởi <a target="_blank" href="' . AUTHOR['website'] . '"><strong>' . AUTHOR['name'] . '</strong></a></h3>
                            <p>Mọi yêu cầu, hỗ trợ quý khách hàng có thể liên hệ <strong>Phòng Kỹ Thuật</strong></p>
                            <p><strong>Điện thoại</strong>: <a href="tel:' . AUTHOR['phone_number'] . '" style="color:red">' . AUTHOR['phone_number'] . '</a> - <a href="tel:' . AUTHOR['hotline'] . '" style="color:red">' . AUTHOR['hotline'] . '</a></p>
                            <p>
                                <strong>Website:</strong> <a target="_blank" href="' . AUTHOR['website'] . '" style="color:red;"">' . AUTHOR['website'] . '</a> -
                                <strong>Email</strong>: <a style="color:red" href="mailto:' . AUTHOR['email'] . '">' . AUTHOR['email'] . '</a>
                            </p>
                        </div>
                    </div>', 'Hệ thống bảo trì');
            }
        });
    }

    public function checkIsCloseHosting()
    {
        add_action(checkSupendHosting(), static function () {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $now = time();
            $startTime = date(get_option('_theme_info_started_hosting'));
            if(get_option('_theme_info_end_hosting') != ''){
                $endTime = date(get_option('_theme_info_end_hosting'));
            }else{
                $endTime = date('Y-m-d H:i:s',strtotime('+1 year',strtotime($startTime)));
            }
            $endTime = date_parse_from_format('Y-m-d H:i:s', $endTime);
            $time_stamp = mktime($endTime['hour'],$endTime['minute'],$endTime['second'],$endTime['month'],$endTime['day'],$endTime['year']);
            if ($now >= $time_stamp) {
                wp_die('
                    <div style="position: relative;">
                        <div style="text-align:center">
                            <a target="_blank" href="' . AUTHOR['website'] . '">
                                <img style="width:50%" src="' . AUTHOR['logo_url'] . '" alt="' . AUTHOR['name'] . '">
                            </a>
                        </div>
                        <p style="text-align:center; font-size: 18px">Hiện tại website của quý khách đã bị tạm dừng vì <span style="color: red; font-weight: bold">hết hạn hosting</span> <br/> Quý khách vui lòng liên hệ với công ty ' . AUTHOR['name'] . ' để được hỗ trợ</p>
                        <div style="text-align:center">
                            
                            <p style="font-size: 18px;">Mọi yêu cầu, hỗ trợ quý khách hàng có thể liên hệ</p>
                            <p style="font-size: 18px;"><strong>Điện thoại</strong>: <a href="tel:' . AUTHOR['hotline'] . '" style="color:red; font-weight: bold">' . AUTHOR['hotline'] . '</a> - <a href="tel:' . AUTHOR['phone_number'] . '" style="color:red; font-weight: bold">' . AUTHOR['phone_number'] . '</a></p>
                            <p style="font-size: 18px;">
                                <strong>Website:</strong> <a target="_blank" href="' . AUTHOR['website'] . '" style="color:red; font-weight: bold">' . AUTHOR['website'] . '</a> -
                                <strong>Email:</strong> <a href="mailto:' . AUTHOR['email'] . '" style="color:red; font-weight: bold">' . AUTHOR['email'] . '</a>
                            </p>
                            <p style="text-aligin: center;font-size: 20px;">Trân trọng !</p>
                        </div>
                    </div>', 'Thông báo gia hạn hosting');
            }
        });
    }
    
    public function disablePluginPage()
    {
        add_action('admin_menu', static function () {
            global $menu;
            foreach ($menu as $key => $menuItem) {
                switch ($menuItem[2]) {
                    case 'plugins.php':
                    case 'customize.php':
                        // case 'themes.php':
                        unset($menu[$key]);
                        break;
                }
            }
            
            global $submenu;
            unset($submenu['themes.php'][5], $submenu['themes.php'][6], $submenu['themes.php'][11]);
        }, 999);
        
        $errorMessage = $this->errorMessage;
        add_action('current_screen', static function () use ($errorMessage) {
            $deniePage      = [
                'plugins',
                'plugin-install',
                'plugin-editor',
                'themes',
                'theme-install',
                'theme-editor',
                'customize',
                'tools',
                'import',
                'export',
                'tools_page_action-scheduler',
                'tools_page_export_personal_data',
                'tools_page_remove_personal_data',
            ];
            $current_screen = get_current_screen();
            // dump($current_screen);
            if ($current_screen !== null && in_array($current_screen->id, $deniePage, true)) {
                wp_die($errorMessage, 'Không được phép truy cập');
            }
        });
    }
    
    public function disableOptionsReadPage()
    {
        
        //      $denyPages = [];
        $removePages = [
            //'options-reading.php',
            'options-writing.php',
            'options-discussion.php',
            'options-media.php',
            'privacy.php',
            'options-permalink.php',
            'tinymce-advanced',
        ];
        add_action('admin_menu', static function () use ($removePages) {
            foreach ($removePages as $page) {
                remove_submenu_page('options-general.php', $page);
            }
            //            global $submenu;
            //            dump($submenu);
            //            remove_submenu_page('options-general.php', 'options-writing.php');
            //            remove_submenu_page('options-general.php', 'options-discussion.php');
            //            remove_submenu_page('options-general.php', 'options-media.php');
            //            remove_submenu_page('options-general.php', 'privacy.php');
        });
        
        $errorMessage = $this->errorMessage;
        $denyPages    = [
            //'options-reading',
            'options-writing',
            'options-discussion',
            'options-media',
            'privacy',
            'options-permalink',
            'settings_page_tinymce-advanced',
            //'toplevel_page_wpseo_dashboard',
        ];
        add_action('current_screen', static function () use ($errorMessage, $denyPages) {
            $current_screen = get_current_screen();
            //            dump($current_screen);
            if ($current_screen !== null && in_array($current_screen->id, $denyPages, true)) {
                wp_die($errorMessage,'Không được phép truy cập');
            }
        });
    }
    
    public function disableAllUpdate()
    {
        remove_action('load-update-core.php', 'wp_update_plugins');
        add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;"));
    }
    
    public function removeUnnecessaryMenus()
    {
        add_action('admin_menu', static function () {
            global $menu;
            global $submenu;
            foreach ($menu as $key => $menuItem) {
                if (in_array($menuItem[2], [
                    'tools.php',
                    'edit-comments.php',
                    //'wpseo_dashboard',
                    'duplicator',
                    'yit_plugin_panel',
                    'woocommerce-checkout-manager',
                    //                    'options-general.php',
                ])) {
                    unset($menu[$key]);
                }
            }
        });
    }
    
    public function requireScripts()
    {
        add_action('admin_enqueue_scripts', function () {
            wp_enqueue_style('gaumap-custom-style', adminAsset('css/admin.css'));
            wp_enqueue_script('gaumap-custom-scripts', adminAsset('js/admin.js'));
        });
    }

    public function classic_editor()
    {
        add_filter('use_block_editor_for_post', '__return_false');
    }
    
    public function example_theme_support()
    {
        add_action('after_setup_theme', function () {
            remove_theme_support( 'widgets-block-editor' );
        });
    }

    public function remove_woo_widgets()
    {
        add_action('widgets_init', function () {
            unregister_widget( 'WC_Widget_Product_Categories' );
            unregister_widget( 'WC_Widget_Product_Tag_Cloud' );
            unregister_widget( 'WC_Widget_Cart' );
            unregister_widget( 'WC_Widget_Layered_Nav' );
            unregister_widget( 'WC_Widget_Layered_Nav_Filters' );
            unregister_widget( 'WC_Widget_Price_Filter' );
            unregister_widget( 'WC_Widget_Product_Search' );
            unregister_widget( 'WC_Widget_Top_Rated_Products' );
            unregister_widget( 'WC_Widget_Recent_Reviews' );
            unregister_widget( 'WC_Widget_Recently_Viewed' );
            unregister_widget( 'WC_Widget_Product_Categories' );
            unregister_widget( 'WC_Widget_Products' );
            unregister_widget('WP_Statistics_Widget');
            unregister_widget( 'WC_Widget_Rating_Filter' );
        });
        remove_action( 'init', 'wp_widgets_init', 1 ); // original line
        add_action( 'init', function() { do_action( 'widgets_init' ); }, 1 ); // added line
    }

    public function ration_add_featured_image_html()
    {
        add_filter('admin_post_thumbnail_html', function ($html) {
            $html .= '<p>'.showSizeThhumbnail().'</p>';
            return $html;
        });
    }

    public function noteFeatureImage()
    {
        add_action('admin_footer', function () {
        ?>
            <script type="text/javascript">
                var note_feartureImage = '<?php echo showSizeThhumbnail() ?>';
            </script>
        <?php
        });
    }
    public function custom_allowed_block_types()
    {
        add_filter('allowed_block_types', function ($allowed_blocks) {
            $default_blocks = array( 'core/image', 'core/paragraph', 'core/heading','core/list');

            $additional_blocks = array('core/gallery', 'core/quote', 'core/audio', 'core/button', 'core/buttons', 'core/columns', 'core/column', 'core/cover', 'core/group', 'core/freeform', 'core/media-text', 'core/more', 'core/nextpage', 'core/preformatted', 'core/pullquote', 'core/separator', 'core/spacer', 'core/subhead', 'core/table', 'core/text-columns', 'core/verse', 'core/video');


            // Kết hợp danh sách khối mặc định và danh sách khối bổ sung
            $allowed_blocks = array_merge($default_blocks, $additional_blocks);

            return $allowed_blocks;
        });
    }

    public function my_switch_user()
    {
        add_filter('wp_dropdown_users', function(){
            global $post;

            $users = get_users(array(
                'exclude' => array(1), 
                'who' => 'authors' 
            ));

            $output = "<select id=\"post_author_override\" name=\"post_author_override\" class=\"\">";

            foreach($users as $user)
            {
                if (in_array($user->user_login, SUPER_USER)) {
                    continue;
                }

                $sel = ($post->post_author == $user->ID) ? "selected='selected'" : '';
                $output .= '<option value="'.$user->ID.'" '.$sel.'>'.$user->user_login.' ('.$user->display_name.')</option>';
            }
            $output .= "</select>";

            return $output;
        });
    }

    public function collectLogintime(){
        add_action('wp_login', function($user_login, $user){
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            update_user_meta($user->ID, 'last_login', current_time('timestamp'));
        }, 20, 2);
    }

    public function showTimeLogin(){
        add_filter('manage_users_columns', function($columns){
            $columns['last_login'] = 'Đăng nhập lần cuối'; // column ID / column Title
            return $columns;
        });
        add_filter('manage_users_custom_column', function($output, $column_id, $user_id){
            if ($column_id == 'last_login') {
                $last_login = get_user_meta($user_id, 'last_login', true);
                $date_format = 'j M, Y H:i'; // Định dạng ngày và giờ
                $output = $last_login ? date($date_format, $last_login) : '-';
            }

            return $output;
        },10,3);
    }

    public function shortUserLogin(){
        add_filter('manage_users_sortable_columns', function($columns){
            return wp_parse_args( array(
                'last_login' => 'last_login'
            ), $columns );
        });

        add_filter('pre_get_users', function($query){
            if( !is_admin() ) {
                return $query;
            }

            $screen = get_current_screen();

            if( isset( $screen->id ) && $screen->id !== 'users' ) {
                return $query;
            }

            if( isset( $_GET[ 'orderby' ] ) && $_GET[ 'orderby' ] == 'last_login' ) {

                $query->query_vars['meta_key'] = 'last_login';
                $query->query_vars['orderby'] = 'meta_value';

            }

            return $query;
        });

    }

}