<?php
namespace app\admin\controller;

use think\Controller;

class News extends Base
{
    public function index() {
        // 方法一： 使用ThinkPHP 内置分页机制
//        $news = model('News')->getNews();
//        注意，模板需要加上 {:pagination($news)}  展示样式

        // 方法二： 原生PHP + 插件
        // page, size, from -> limit from size

        $param = input('param.');
        $query = http_build_query($param);
        $where = [];
        // 转换查询条件
        if (!empty($param['start_time'])
            && !empty($param['end_time'])
            && $param['start_time'] <= $param['end_time']
        ) {
            $where['create_time'] = [
                ['gt', strtotime($param['start_time'])],
                ['lt', strtotime($param['end_time'])],
            ];
        }
        if (!empty($param['capid'])) {
            $where['capid'] = intval($param['capid']);
        }
        if (!empty($param['title'])) {
            $where['title'] = ['like', '%'.$param['title'].'%'];
        }

        $this->getPageAndSize($param);

        $news = model('News')->getNewsByCondition($where, $this->from, $this->size);
        // 获取满足条件的数据总数 =》计算总页数

        $total = model('News')->getNewsCountByCondition($where);
        $pageNum = ceil($total / $this->size);
        $result = $this->fetch('', [
            'column' => config('column.lists'),
            'news' => $news,
            'pageTotal' => $pageNum,
            'curr' => $this->page,
            'capid' => empty($param['capid']) ? '' : $param['capid'],
            'title' => empty($param['title']) ? '' : $param['title'],
            'start_time' => empty($param['start_time']) ? '' : $param['start_time'],
            'end_time' => empty($param['end_time']) ? '' : $param['end_time'],
            'query' => $query
        ]);
        return $result;
    }

    public function add() {
        if (request()->isPost()) {
            $data = input('post.');
            // 数据校验 略
            // 入库
            try {
               $id = model('News')->add($data);
            } catch (\Exception $e) {
                return $this->result('',0,$e->getMessage());
            }
            if ($id) {
                return $this->result(['jump_url' => url('news/index')],
                    1, '新增成功');
            } else {
                return $this->result('',0,'新增失败');
            }

        } else {
            return $this->fetch('', [
                'column' => config('column.lists')
            ]);
        }
    }
}
