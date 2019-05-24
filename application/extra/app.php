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
    'app_sign_time' => 10, // lifetime of sign
];