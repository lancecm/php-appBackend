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

    /**
     * @param array $data
     * 生成请求sign
     */
    public static function setSign($data=[]) {
        // 1. 按参数字母升序排序
        ksort($data);
        // 2. 参数拼接
        $string = http_build_query($data);
        // 3. aes加密
        $string = (new Aes())->encrypt($string);
        return $string;
    }

    /**
     * @param $data
     * 检查sign是否合法
     * @return boolean
     */
    public static function checkSignPass($data) {
        $str = (new Aes())->decrypt($data['sign']);
        if (empty($str)) { // or false??
            return false;
        }
        parse_str($str, $arr);
        if (!is_array($arr)
            || empty($arr['did']) || $data['did'] != $arr['did']
            || empty($arr['app_type']) || $data['app_type'] != $arr['app_type']) {
            return false;
        } else {
            return true;
        }
    }
}