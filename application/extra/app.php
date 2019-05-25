<?php
/**
 * application configuration
 */
return [
    'password_salt' => '_#salt_!',
    'aeskey' => 'sgg45747ss223455', // length must be 16
    'apptypes' => [
        'ios',
        'android'
    ],
    'app_sign_time' => 1000000000, // lifetime of sign
    'app_sign_cache_time' => 2000000000, // sign 缓存失效时间
    'rank_num' => 5
];