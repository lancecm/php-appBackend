<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

/**
 * Class Image
 * @package app\admin\controller
 * 后台图片上传
 */
class Image extends Base
{
    public function upload() {
        $file = request()->file('file');
        $info = $file->move('uploads');
        if ($info && $info->getPathname()) {
            $data = [
                'status' => 1,
                'message' => 'Upload Success',
                'url' => '/'.$info->getPathname(),
            ];
            echo json_encode($data);
            exit;
        }
        else {
            $data = ['status' => 0,
                'message'=> 'Upload Failed'];
            echo json_encode($data);
        }


//        $file = request()->file();
//        // 移动到框架应用根目录/public/uploads/ 目录下
//        if($file){
//            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
//            if($info){
//
//            }else{
//                // 上传失败获取错误信息
//                $this->error($file->getError());
//            }
//        }
    }
}
