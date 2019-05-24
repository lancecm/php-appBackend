<?php

namespace app\common\lib;

/**
 * Class Time
 * @package app\common\lib
 * 时间相关
 */
class Time {

    /**
     * 13位时间戳
     */
    public static function get13TimeStamp() {
        list($t1, $t2) = explode(' ', microtime());
        return $t2.ceil($t1 * 1000);
    }

}