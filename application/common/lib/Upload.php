<?php
namespace app\common\lib;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

/**
 * Class upload
 * @package app\common\lib
 * 七牛云图片上传
 */
class upload {
    public static function image() {
        if (empty($_FILES['file']['tmp_name'])) {
            exception('您提交到图片数据不合法。', 404);
        }
        else {
            // 本地文件名
            $file = $_FILES['file']['tmp_name'];
            // 后缀
            $ext = explode('.', $_FILES['file']['name'])[1];
            $config = config('qiniu');
//            另一种方式
//            $ext = pathinfo($_FILES['file']['name'])['extension'];

            // 用于签名的公钥和私钥
            $accessKey = $config['ak'];
            $secretKey = $config['sk'];
            // 初始化签权对象
            $auth = new Auth($accessKey, $secretKey);
            // 生成上传token
            $token = $auth->uploadToken($config['bucket']);
            // 文件名
            $key = date('Y')
                ."/".date('m')
                ."/".substr(md5($file), 0, 5)
                .date('YmdHis')
                .rand(0,9999)
                .'.'.$ext;

            $uploadMgr = new UploadManager();
            list($res, $err) = $uploadMgr->putFile($token, $key, $file);
            if ($err !== null) {
                return null;
            } else {
                return $key;
            }
        }
    }
}