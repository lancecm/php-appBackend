<?php
namespace app\api\controller;
use app\common\lib\exception\ApiException;
use app\common\lib\IAuth;
use think\controller;
use app\common\lib\Aes;
use app\common\lib\Auth;
use app\common\lib\Time;
use think\Cache;

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
//        $this->testAes();
        $this->checkRequestAuth();
    }

    /**
     * 检查每次APP请求数据是否合法
     */
    public function checkRequestAuth() {
        // 获取headers
        $headers = request()->header();
        // 基础参数校验

        // 注意：
        // 1. 除了Headers，body中传递过来的数据也可以拿来校验
        // 2. 可以把数据打包后发给服务端验证
        // 3. 需要加入时间戳

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
        // 1. 静态缓存    仅适合单台服务器
        // 2. 写入mysql
        // 3. 写入redis
        Cache::set($headers['sign'], 1, config('app.app_sign_cache_time'));

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
//        $str = "aa2f9793e982f1a9bfaca66b7f187dd73d7d4af2eb8a7540cb2f310588b2d2ebcbdcce60b0f91ac0616884697148ff90";
//        echo (new Aes())->decrypt($str, config('app.aeskey')); exit;

        // 测试应用场景
        $data = [
            'did' => 1243,
            'version' => 1,
            'time' => Time::get13TimeStamp(),
        ];
        $str = IAuth::setSign($data);
        echo $str.'<br/>';
        echo (new Aes())->decrypt($str); exit;
    }

    /**
     * @param array $news
     * @return array
     * 处理新闻数据 (capid 从id转换成对应的文字)
     */
    protected function dealNews($news = []) {
        if (empty($news)) return [];
        $cats = config('column.lists');
        foreach ($news as $key => $new) {
            // 注意PHP数组的用法非常灵活！
            $news[$key]['catname'] = $cats[$new['capid']] ? $cats[$new['capid']] : '-';
        }
        return $news;
    }

}