<?php
namespace app\api\controller;
use app\common\lib\exception\ApiException;
use app\common\lib\IAuth;
use think\controller;
use app\common\lib\Aes;
use app\common\lib\Auth;
/**
 * Class Common
 * @package app\api\controller
 * api模块公共控制器
 */
class Common extends Controller {

    // header信息
    public $headers = '';

    public function _initialize()
    {
        $this->checkRequestAuth();
    }

    /**
     * 检查每次APP请求数据是否合法
     */
    public function checkRequestAuth() {
        // 获取headers
        $headers = request()->header();
        // 基础参数校验
        if (empty($headers['sign'])) {
            throw new ApiException('sign不存在', 400);
        }
        if (!in_array($headers['app_type'], config('app.apptypes'))) {
            throw new ApiException('app_type不合法', 400);
        }
        // 校验sign
        if (!IAuth::checkSignPass($headers)) {
            throw new ApiException('sign不合法', 401);
        }
        // 存header信息
        $this->headers = $headers;
    }

    /**
     * 测试Aes
     */
    public function testAes() {
        // 一般而言，加密步骤由客户端完成，将sign附带到Header中，加密模式需要一致

        // 测试加密
//        $str = "did=23123145&app_type=android";
//        echo (new Aes())->encrypt($str); exit;

        // 测试解密
//        $str = "34d3225a182db2a1ec989783bda312165be30c400d22809728564fe852405933";
//        echo (new Aes())->decrypt($str, config('app.aeskey')); exit;

        // 测试应用场景
        $data = [
            'id' => 1243,
            'm' => 5672312
        ];
        $str = IAuth::setSign($data);
        echo (new Aes())->decrypt($str); exit;
    }

}