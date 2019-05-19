<?php

namespace app\common\model;

use think\Model;

class Base extends Model
{
    protected $autoWriteTimestamp = true; // 自动插入创建时间

    /**
     * 新增
     * @param $data
     * @return mixed
     */
    public function add($data) {
        if(!is_array($data)) {
            exception('传递数据不合法');
        }
        $this->allowField(true)->save($data); // allowField过滤没有在表中的字段
        return $this->id;
    }
}