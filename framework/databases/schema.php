<?php
    /* Gọi đến file config để khởi tạo biến capsule */
    $table = include 'database.php';

    /* Tạo mới 1 bảng nếu như bảng đó chưa tồn tại */
    // if (!$table->schema()->hasTable('tinh_thanh')) {
    //     $table->schema()->create('tinh_thanh', function ($table) {
    //         $table->increments('id');
    //         $table->string('ten');
    //         $table->string('loai');
    //         $table->string('toa_do');
    //     });
    // }