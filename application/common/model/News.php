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
//        echo $this->getLastSql();
        return $result;
    }

    /**
     * @param array $param
     * 根据条件获取数据
     */
    public function getNewsByCondition($param=[]) {
        $condition['status'] = [
            'neq', config('code.status_delete')
        ];
        $order = ['id' => 'desc'];
        $from = ($param['page'] - 1) * $param['size'];
        $result = $this->where($condition)
            ->limit($from, $param['size'])
            ->order($order)
            ->select();
        return $result;
    }

    /**
     * @param array $param
     * 根据条件获取列表总数
     */
    public function getNewsCountByCondition($param=[]) {
        $condition['status'] = [
            'neq', config('code.status_delete')
        ];
        return $this->where($condition)->count();
//        echo $this->getLastSql();
    }
}