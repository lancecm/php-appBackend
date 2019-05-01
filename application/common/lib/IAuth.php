<?php

namespace app\common\lib;

/**
 * Class IAuth
 * 权限验证
 */
class IAuth {
    public static function setPassword($password) {
        return md5($password.config('app.password_salt')); // hash the password with salt
    }
}