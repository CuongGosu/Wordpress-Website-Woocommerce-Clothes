<?php

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Định nghĩa class DB đê sử dụng query builder
 *
 * Class DB
 */
class DB extends Capsule
{
}

/* Tạo mới 1 instant để sử dụng */
$capsule = new Capsule;

if (!is_admin()) {
    require_once 'wp-config.php';
}

/* Thiết lập sử dụng kết nối đến mysql, các hệ CSDL khác cấu hình tương tự như bên laravel */
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => DB_NAME,
    'username'  => DB_USER,
    'password'  => DB_PASSWORD,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => 'gaumap_',
]);

/* Cấu hình cho biến capsule có thể sử dụng mọi nơi trong project */
$capsule->setAsGlobal();

/* Bật hỗ trợ Eloquent */
$capsule->bootEloquent();

return $capsule;