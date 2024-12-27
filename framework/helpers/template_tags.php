<?php

/**
 * get resources uri
 *
 * @param string $path
 *
 * @return string
 */
function asset($path)
{
    return get_stylesheet_directory_uri() . '/resources/' . $path;
}

function template($name)
{
    get_template_part('templates/' . $name);
}

function getOption($name)
{
    return carbon_get_theme_option($name . currentLanguage());
}

/**
 * Get theme option dạng image
 *
 * @param string $name
 * @param int    $w
 * @param int    $h
 *
 * @return false|string
 */
function getOptionImageUrl($name, $w, $h)
{
    return getImageUrlById(getOption($name), $w, $h);
}

function getPostThumbnailUrl($postId, $width = null, $height = null)
{
    $defaultImage = getImageUrlById(getOption('hinh_anh_mac_dinh'), $width, $height);
    try {
        $imageId = get_post_thumbnail_id($postId);
        if (empty($imageId)) {
            return $defaultImage;
        }
        
        if ($width === null && $height === null) {
            return wp_get_attachment_image_url($imageId, 'full');
        }
        
        return getImageUrlById($imageId, $width, $height);
    } catch (\Exception $ex) {
        return $defaultImage;
    }
}

function getExcerpt($postId, $limit)
{
    return subString(get_the_excerpt($postId), $limit);
}

function updateViewCount($postId = null)
{
    $postId = empty($postId) ? get_the_ID() : $postId;
    
    $count_key = '_gm_view_count';
    $count     = (int)get_post_meta($postId, $count_key, true);
    if (empty($count)) {
        $count = 1;
        delete_post_meta($postId, $count_key);
        add_post_meta($postId, $count_key, $count);
    } else {
        $count++;
        update_post_meta($postId, $count_key, $count);
    }
    
    return $count;
}

function getViewCount($postId = null)
{
    $postId    = empty($postId) ? get_the_ID() : $postId;
    $count_key = '_gm_view_count';
    $count     = get_post_meta($postId, $count_key, true);
    if (empty($count)) {
        $count = 0;
        delete_post_meta($postId, $count_key);
        add_post_meta($postId, $count_key, $count);
    }
    
    return $count;
}

function getPostMeta($name, $id = null)
{
    $id = empty($id) ? get_the_ID() : $id;
    return carbon_get_post_meta($id, $name);
}

function getPostMetaImageUrl($name, $id = null, $w = null, $h = null)
{
    $id = empty($id) ? get_the_ID() : $id;
    return getImageUrlById(carbon_get_post_meta($id, $name), $w, $h);
}

function thePostMeta($name)
{
    echo getPostMeta($name, get_the_ID());
}

function thePostMetaImageUrl($name = '', $w = null, $h = null)
{
    echo getPostMetaImageUrl($name, get_the_ID(), $w, $h);
}

/**
 * Echo view count of post
 *
 * @param null $postId
 */
function theViewCount($postId = null)
{
    echo getViewCount($postId);
}

function thePostThumbnailUrl($width = null, $height = null)
{
    echo getPostThumbnailUrl(get_the_ID(), $width, $height);
}

function theTitle($limit = 999)
{
    echo subString(get_the_title(), $limit);
}

function theExcerpt($limit = 9999)
{
    echo '<p>' . getExcerpt(get_the_ID(), $limit) . '</p>';
}

function theContent()
{
    $content = get_the_content();
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    echo !empty($content) ? $content : '<p style="text-align: center; color: #ff0000">'.__('Dữ liệu đang được cập nhật !', 'nrglobal').'</p>';
}

function theTime()
{
    the_time(get_option('date_format') . ' ' . get_option('time_format'));
}

function theDate()
{
    the_time(get_option('date_format'));
}

function theOption($name)
{
    echo getOption($name);
}

function theOptionImage($name, $width = null, $height = null)
{
    echo getImageUrlById(getOption($name), $width, $height);
}

/**
 * Load resource
 *
 * @param string $path
 */
function theAsset($path)
{
    echo asset($path);
}

/**
 * Tạo phân trang sử dụnng boostrap 4
 *
 * @param mixed|\WP_Query $query
 */
function thePagination($query = null)
{
    if (empty($query)) {
        global $wp_query;
        $query = $wp_query;
    }
    
    $paged = (get_query_var('paged') === 0) ? 1 : get_query_var('paged');
    $pages = paginate_links([
            'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format'    => '?paged=%#%',
            'current'   => $paged,
            'total'     => $query->max_num_pages,
            'type'      => 'array',
            'prev_text'    => __('<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 31 10" style="enable-background:new 0 0 31 10; width: 31px; height: 10px;" xml:space="preserve"><polygon points="31,5 25,0 25,4 0,4 0,6 25,6 25,10 "></polygon></svg>'),
            'next_text'    => __('<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 31 10" style="enable-background:new 0 0 31 10; width: 31px; height: 10px;" xml:space="preserve">
                                            <polygon points="31,5 25,0 25,4 0,4 0,6 25,6 25,10 "></polygon>
                                        </svg>'),
        ]
    );
    if (is_array($pages)) {
        $pagination = '<div id="pagination" class="clearfix"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
        foreach ($pages as $page) {
            $pagination .= str_replace('page-numbers', 'page-node', $page);
        }
        $pagination .= '</div></div>';
        echo $pagination;
    }
}

/**
 * Tạo hộp chia sẻ
 */
function theShareBox()
{
    get_template_part('templates/parts/share-box');
}

/**
 * Load bản đồ Google
 *
 * @param $name
 * @param $height
 */
function theGoogleMap($idElement, $name, $height = 350)
{
    $location = getOption($name); ?>

	<div id="<?php echo $idElement ?>" style="width:100%;height:<?php echo $height ?>px" data-lat="<?php echo $location['lat'] ?>" data-lng="<?php echo $location['lng'] ?>" data-zoom="<?php echo $location['zoom'] ?>"></div>
	<script>
        setTimeout(() => {
            let mapElement = document.getElementById('<?php echo $idElement ?>');
            if (mapElement) {
                let myLatLng = {
                    lat: parseFloat(mapElement.getAttribute("data-lat")),
                    lng: parseFloat(mapElement.getAttribute("data-lng"))
                };
                let map = new google.maps.Map(mapElement, {
                    center: myLatLng,
                    zoom  : parseInt(mapElement.getAttribute("data-zoom"))
                });
                let marker = new google.maps.Marker({
                    position: myLatLng,
                    map     : map,
                });
            }
        }, 200);
	</script>
<?php }

/**
 * Tạo breadcrumb
 */
function theBreadcrumb()
{
    get_template_part('templates/parts/breadcrumb');
}

function thePhoneNumberFixedButton()
{
    get_template_part('templates/part-hotline-button');
}

function theFanPageFixedButton()
{
    if(getOption('fan_page_id') != ''){
    ?>
    <script type="text/javascript">

        (function () {
            var options = {
                facebook: "<?php theOption('fan_page_id') ?>", // Facebook page ID
               company_logo_url: "<?php theOption('desktop_logo') ?>", // URL of company logo (png, jpg, gif)
                greeting_message: "<?php _e('Chào bạn, Chúng tôi có thể giúp được gì cho bạn ?', 'nrglobal') ?>", // Text of greeting message
                call_to_action: "<?php _e('Hỗ trợ trực tuyến','nrglobal') ?>", // Call to action
                button_color: "#FF6550", // Color of button
                position: "right", // Position may be 'right' or 'left'
            };
            var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
            var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
            s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
            var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
        })();
    </script>
    <style type="text/css" media="screen">
        .dmopMx{
            display: none !important;
        }
    </style>
    <?php
    }
}

function theCopyright()
{
    $date = date('Y');
    $name = get_bloginfo('name');
    echo "Thiết kế và vận hành Website: <a href='https://nrglobal.vn' target='_blank' rel='nofollow'>NR Global</a>";
}

function thePageTitle()
{
    echo getPageTitle();
}

function getPageTitle()
{
    $obj   = get_queried_object();
    $title = get_bloginfo('name');
    if (is_single() || is_page()) {
        $title = get_the_title();
    } elseif (is_search()) {
        /* translators: search results page title */
        $title = sprintf(__('Kết quả tìm kiếm cho từ khóa: %s', 'nrglobal'), get_search_query());
    } elseif (is_category()) {
        /* translators: category post listing page title */
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        /* translators: tag post listing page title */
        $title = sprintf(__('Tag: %s', 'nrglobal'), single_tag_title('', false));
    } elseif (is_day()) {
        /* translators: day archive post listing page title */
        $title = sprintf(__('Daily Archives: %s', 'nrglobal'), get_the_time('F jS, Y'));
    } elseif (is_month()) {
        /* translators: month archive post listing page title */
        $title = sprintf(__('Monthly Archives: %s', 'nrglobal'), get_the_time('F, Y'));
    } elseif (is_year()) {
        /* translators: year archive post listing page title */
        $title = sprintf(__('Yearly Archives: %s', 'nrglobal'), get_the_time('Y'));
    } elseif (is_author()) {
        /* translators: author archive post listing page title */
        $title = sprintf(__('Posts by %s', 'nrglobal'), get_the_author());
    } elseif (is_archive()) {
        if ($obj instanceof WP_Term) {
            $title = $obj->name;
        } elseif ($obj instanceof WP_Post_Type) {
            $title = $obj->label;
        }
    } elseif (is_404()) {
        $title = __('Lỗi 404 - Không tìm thấy trang bạn yêu cầu', 'nrglobal');
    }
    return $title;
}

function theLanguageSwitcher($showName = false, $showFlag = true)
{
    if (function_exists('pll_the_languages')) {
        echo '<ul class="language-switcher">';
        pll_the_languages([
            'show_names'    => $showName,
            'show_flags'    => $showFlag,
            'hide_if_empty' => false,
        ]);
        echo '</ul>';
    }
}

function getVideoId($url) {
    // Kiểm tra nếu URL chứa "/shorts/"
    if (strpos($url, "/shorts/") !== false) {
        $parsedUrl = parse_url($url);
        parse_str($parsedUrl['query'], $query);
        if (isset($query['v'])) {
            return $query['v'];
        } elseif (isset($query['shorts'])) {
            return $query['shorts'];
        } else {
            $pathSegments = explode('/', trim($parsedUrl['path'], '/'));
            return end($pathSegments);
        }
    } else {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $matches);
        if (!empty($matches)){
            return $matches[1];
        }
    }
    
    return false; // Trả về false nếu không tìm thấy ID video
}

function get_nav_name($location) {
    if(empty($location)) return false;

    $locations = get_nav_menu_locations();
    if(!isset($locations[$location])) return false;

    $menu_obj  = get_term( $locations[$location], 'nav_menu' );
    $menu_name = esc_html($menu_obj->name);

    return $menu_name;
}

function custom_price_html($price_html, $product) {
 
    $sale_price = $product->get_sale_price();
    $regular_price = $product->get_regular_price();

    // Kiểm tra nếu có giá khuyến mãi
    if ($sale_price && $regular_price > $sale_price) {
        $price_html = '<span class="sale-price">' . wc_price($sale_price) . '</span';
        $price_html .= ' <del>' . wc_price($regular_price) . '</del>';
    }

    return $price_html;
}

add_filter('woocommerce_get_price_html', 'custom_price_html', 10, 2);
