<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', static function () {
    $optionsPage = Container::make('theme_options', __('Cấu hình website', 'nrglobal'))
                            ->set_page_file(__('cau-hinh-website', 'nrglobal'))
                            ->set_page_menu_position(2)
                            ->set_icon('dashicons-admin-tools')
                            ->set_page_menu_title(__('Tùy chỉnh', 'nrglobal'))
                            ->add_tab(__('Cấu hình website', 'nrglobal'), [
                                Field::make('separator', 'info_separator_1', __('Ảnh thương hiệu', 'nrglobal')),
                                Field::make('image', 'hinh_anh_mac_dinh' . currentLanguage(), __('Ảnh bài viết mặc định', 'nrglobal'))->set_required( true )->set_width(25),
                                Field::make('image', 'desktop_logo' . currentLanguage(), __('Ảnh logo máy tính', 'nrglobal'))->set_width(25),
                                Field::make('image', 'mobile_logo' . currentLanguage(), __('Ảnh logo điện thoại', 'nrglobal'))->set_width(25),
                                Field::make('image', 'favicon' . currentLanguage(), __('Ảnh favicon', 'nrglobal'))->set_width(25),
                                Field::make('complex', 'main_slider' . currentLanguage(), __('Slider trang chủ', 'nrglobal'))
                                ->set_layout('tabbed-horizontal')// grid, tabbed-vertical
                                ->add_fields([
                                    Field::make('image', 'image', __('Hình ảnh (1920x1080px)', 'nrglobal')),
                                    Field::make('text', 'link', __('Đường dẫn (Link)', 'nrglobal')),
                                ]),
                                Field::make('complex', 'mobile_slider' . currentLanguage(), __('Slider trang chủ dạng mobile', 'nrglobal'))
                                ->set_layout('tabbed-horizontal')// grid, tabbed-vertical
                                ->add_fields([
                                    Field::make('image', 'image', __('Hình ảnh (1250x600px)', 'nrglobal')),
                                    Field::make('text', 'link', __('Đường dẫn (Link)', 'nrglobal')),
                                ]),
                            ])
                            ->add_tab(__('Liên hệ', 'nrglobal'), [
                                Field::make('text', 'ten_cong_ty' . currentLanguage(), __('Tên công ty', 'nrglobal'))->set_width(100),
                                Field::make('text', 'slogan' . currentLanguage(), __('Khẩu hiệu', 'nrglobal'))->set_width(50),
                                Field::make('text', 'dia_chi' . currentLanguage(), __('Đia chỉ', 'nrglobal'))->set_width(50),
                                Field::make('text', 'email' . currentLanguage(), __('Email', 'nrglobal'))->set_width(33.33),
                                Field::make('text', 'dien_thoai' . currentLanguage(), __('Điện thoại', 'nrglobal'))->set_width(33.33),
                                Field::make('text', 'zalo' . currentLanguage(), __('Zalo', 'nrglobal'))->set_width(33.33),
                                Field::make('text', 'fan_page' . currentLanguage(), __('Fanpage', 'nrglobal'))
                                     ->set_width(50),
                                Field::make('text', 'fan_page_id' . currentLanguage(), __('Messenger', 'nrglobal'))->help_text('<a href="https://findidfb.com/" target="_blank" >Nhấn vào đây để lấy ID </a>')
                                     ->set_width(50),
                                Field::make('text', 'youtube' . currentLanguage(), __('Youtube', 'nrglobal'))
                                     ->set_width(50),
                                Field::make('text', 'instagram' . currentLanguage(), __('Instagram', 'nrglobal'))
                                     ->set_width(50),
                                Field::make('text', 'copyright' . currentLanguage(), __('Thông tin mã số thuế', 'nrglobal')),
                                Field::make('rich_text', 'short_intro' . currentLanguage(), __('Giới thiệu ngắn', 'nrglobal')),
                                // Field::make('complex', 'factories' . currentLanguage(), __('Chi nhánh', 'nrglobal'))
                                //      ->add_fields([
                                //          Field::make('text', 'ten' . currentLanguage(), __('Tên chi nhánh', 'nrglobal')),
                                //          Field::make('text', 'dia_chi' . currentLanguage(), __('Địa chỉ', 'nrglobal')),
                                //          Field::make('text', 'dien_thoai' . currentLanguage(), __('Điện thoại', 'nrglobal')),
                                //      ]),
                                Field::make('rich_text', 'noi_dung_lien_he' . currentLanguage(), __('Nội dung trang liên hệ', 'nrglobal'))
                                     ->set_width(50),
                                Field::make('map', 'ban_do_cong_ty' . currentLanguage(), __('Vị trí công ty trên bản đồ', 'nrglobal'))->set_width(50),
                            ]);
});