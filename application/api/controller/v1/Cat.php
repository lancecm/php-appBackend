<?php
namespace app\api\controller\v1;
use app\api\controller\Common;

class Cat extends Common {
    /**
     * @return array
     * 返回栏目信息
     */
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
        };

        return show(config('code.success'), 'OK', $result, 201);
    }
}