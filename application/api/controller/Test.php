<?php
namespace app\api\controller;
use think\Controller;
use app\common\lib\exception\ApiException;

class Test extends Controller {
    public function index() {
        return [
            'sdf',
            'sdfae'
        ];
    }

    public function update($id = 0) {echo $id; exit;
        $id = input('put.id');
        return $id;
    }

    public function save() {
//        return input('post.');
        // 获取提交数据插入库
        // 获取客户端APP =》 接口数据
        if ($data['ids']) {
            throw new ApiException('不合法',[], 400);
        }
        return show(1, 'OK', input('post.'), 201);
    }
}