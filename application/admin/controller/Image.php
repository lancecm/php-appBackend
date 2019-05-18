<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\lib\upload;
/**
 * Class Image
 * @package app\admin\controller
 * 后台图片上传
 */

class Image extends Base
{
    /**
     * 本地上传
     */
    public function upload0() {
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
    }

    /**
     * 七牛云上传
     */
    public function upload() {
        try {
            $image = Upload::image();
        }
        catch (\Exception $e) {
            echo json_encode(['status' => 0,
                'message'=> $e->getMessage()]);
        }
        if ($image) {
            $data = [
                'status' => 1,
                'message' => 'Upload Success',
                'url' => config('qiniu.url').'/'.$image
            ];
            echo json_encode($data);
        } else {
            echo json_encode(['status' => 0,
                'message'=> 'Upload failed.']);
        };
    }
}
