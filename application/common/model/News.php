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
    public function getNewsByCondition($condition=[], $from=0, $size=5) {
        if (!isset($condition['status'])) {
            $condition['status'] = [
                'neq', config('code.status_delete')
            ];
        }
        $order = ['id' => 'desc'];
        $result = $this->where($condition)
            ->field($this->getListField())
            ->limit($from, $size)
            ->order($order)
            ->select();
//      echo $this->getLastSql();
        return $result;
    }

    /**
     * @param array $param
     * 根据条件获取列表总数
     */
    public function getNewsCountByCondition($condition=[]) {
        if (!isset($condition['status'])) {
            $condition['status'] = [
                'neq', config('code.status_delete')
            ];
        }
        return $this->where($condition)->count();
    }

    // 获取首页头图数据
    public function getHeadNews($num = 4) {
        $param = [
          'status' => 1,
          'is_head_figure' => 1,
        ];

        $order = [
            'id' => 'desc',
        ];

        return $this->where($param)
            ->field($this->getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }

    // 获取推荐数据
    public function getRecommendNews($num = 40) {
        $param = [
            'status' => 1,
            'is_position' => 1,
        ];

        $order = [
            'id' => 'desc',
        ];

        return $this->where($param)
            ->field($this->getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }

    // api获取排行榜上的数据
    public function getNewsByRank($num = 5) {
        $param = [
            'status' => 1,
        ];
        $order = [
            'read_count' => 'desc',
        ];

        return $this->where($param)
            ->field($this->getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }

    /**
     * 通用化参数
     */
    private function getListField() {
        return [
            'id',
            'capid',
            'image',
            'title',
            'read_count',
            'status',
            'is_position',
            'update_time'
        ];
    }
}