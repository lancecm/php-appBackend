<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * @param $obj
 * @return string
 * 渲染分页样式
 */
function pagination($obj) {
    try {
        if (!$obj) {
            return '';
        }
        $params = request()->param();
        return '<div class="imooc-app">' . $obj->appends($params)->render() . '</div>';
    } catch (\Exception $e) {
        return $this->result('',0,$e->getMessage());
    }
}

/**
 * @param $catId
 * 获取栏目名称
 */
function getCapName($id) {
    if (!$id) return '';
    $columns = config('column.lists');
    return !empty($columns[$id]) ? $columns[$id] : '';
}

/**
 * @param $val
 * 转换'是''否'
 */
function isYes($val) {
    return $val ? '<span style="color: red">是</span>': '<span>否</span>';
}

/**
 * @param $id
 * @param $status
 * @return string
 * 状态转换
 */
function status($id, $status) {
    $controller = request()->controller();
    $sta = $status == 1 ? 0 : 1;
    // 新url
    $url = url($controller.'/status', ['status'=>$sta, 'id'=> $id]);
    if ($status == 1) {
        $str = "<a href = 'javascript:;' title='修改状态' onclick='change_status(this)'
         /status_url='".$url."'><span class='label label-success'>正常</span></a>";
    } elseif ($status == 0) {
        $str = "<a href = 'javascript:;' title='修改状态' onclick='change_status(this)'
         /status_url='".$url."'><span class='label label-danger'>待审</span></a>";
    }
    return $str;
}