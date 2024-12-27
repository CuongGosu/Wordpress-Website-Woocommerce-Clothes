- Hướng dẫn cài đặt:

Tại thư mục /wp-content/themes/ mở new terminal chạy các lệnh sau

```text
git clone https://gaumapdev@bitbucket.org/gaumapdev/wordpress-theme-theme-mau-v.8-cho-wordpress.git nrglobal
cd nrglobal
composer update
```

- Cấu trúc thư mục theme:
```text
+ -- framework/                     // Core framework mặc định của theme
    + -- api/
    + -- app/
    + -- assets/
    + -- databases/
    + -- helpers/
    + -- templates/
+ -- resources/                     // Nơi chứa các thư viện css, js sử dụng ở client
    + -- css/                       // Chứa các file custom css sử dụng ở client
        + -- theme.css              // File css mặc định được include và wp_header
    + -- images/                    // Chứa các hình ảnh sử dụng ở client
        + -- avatar-gau-map.jpg     // Hình ảnh mẫu
    + -- js/                        // Chứa các file custom javascript sử dụng ở client
        + -- theme.js               // File js mặc định được include vào wp_footer
    + -- plugins/                   // Chứa các javascript plugins như bootstrap, jquery,...
+ -- templates/                     // Nơi lưu trữ các file template sử dụng ở client
    + -- loop/                      // Lưu trữ các template sử dụng trong vòng lặp
    + -- parts/                     // Lưu trữ các phần của template
    + -- page-contact-us.php        // Trang mẫu liên hệ
+ -- theme/                         // Cấu hình theme sử dụng ở client
    + -- app/                       // Lưu trữ các custom post_types, custom taxonomies
        + -- PostTypes/             // Lưu trữ các custom post_types
            + -- Post.php           // Sử dụng để ghi đè post mặc định thêm các tính năng của theme
        + -- Taxonomies/            // Lưu trữ các custom taxonomies
            + -- Category.php       // Sử dụng để ghi đè category mặc định thêm các tính năng của theme
    + -- ajax.php                   // Lưu trữ các hàm ajax
    + -- gutenberg_blocks.php       // Lưu trữ custom gutenberg blocks
    + -- theme_options.php          // Lưu trữ code tạo theme options
    + -- woocommerce.php            // Lưu trữ các custom về woocommerce
+ -- vendor/
...
...
...
```