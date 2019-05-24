<?php
namespace app\api\controller;
use think\Controller;
use app\common\lib\exception\ApiException;

class Cat extends Common {
    public function read() {
        $cats = config('column.lists');

        $result[0] = [
            'catid' => 0,
            'catname' => '首页'
        ];

        // 注意这里用foreach生成新数组的方法
        foreach ($cats as $id => $name) {
            $result[] = [
                'catid' => $id,
                'catname' => $name
            ];
        }

        return show(config('code.success'), 'OK', $result, 201);
    }
}