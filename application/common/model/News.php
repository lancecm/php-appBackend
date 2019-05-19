<?php

namespace app\common\model;
use think\Model;

class News extends Base {
    /**
     * @param array $data
     * 自动化分页 TP5内置
     */
    public function getNews($data = []) {
        $data['status'] = [
            'neq', config('code.status_delete')
        ];
        $order = ['id' => 'desc'];
        $result = $this->where($data)->order($order)->paginate();
        return $result;
    }
}