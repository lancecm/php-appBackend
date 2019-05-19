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
        $this->getPageAndSize($param);
        $where['page'] = $this->page;
        $where['size'] = $this->size;

        $news = model('News')->getNewsByCondition($where);
        // 获取满足条件的数据总数 =》计算总页数
        $total = model('News')->getNewsCountByCondition($where);
        $pageNum = ceil($total / $where['size']);
        return $this->fetch('', [
            'news' => $news,
            'pageTotal' => $pageNum,
            'curr' => $where['page']
        ]);
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
