<?php

/**
 * Custom route for wordpress API
 */
//add_action('rest_api_init', function () {
//    register_rest_route('gm', '/layers', [
//        'methods'  => 'GET',
//        'callback' => function ($data) {
//            $types  = get_post_types([
//                'public'   => true,
//                '_builtin' => false,
//            ], 'objects', 'and');
//            $result = [];
//            foreach ($types as $type) {
//                $result[] = [
//                    'name'  => $type->name,
//                    'label' => $type->label,
//                ];
//            }
//            return new WP_REST_Response($result, 200);
//        },
//    ]);
//});
