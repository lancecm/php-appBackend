<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

class News extends Base
{
    public function __construct(Request $request = null)
    {
        $this->model = ("News");
        parent::__construct($request);
    }

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

    /**
     * @return mixed|void
     * 新增内容管理
     */
    public function add() {
        if (request()->isPost()) {
            $data = input('post.');
            // 数据校验 略
            // 入库
            try {
               $id = model('News')->add($data);
            } catch (\Exception $e) {
                $this->result('',0,$e->getMessage());
            }
            if ($id) {
                $this->result(['jump_url' => url('news/index')],
                    1, '新增成功');
            } else {
                $this->result('',0,'新增失败');
            }
        } else {
            return $this->fetch('', [
                'column' => config('column.lists'),
                'title' => '',
                'title_short' => '',
                'capid' => '1',
                'description' => '',
                'is_position' => '0',
                'is_allowcomments' => '0',
                'is_head_figure' => '0',
                'image' => '',
                'content' => ''
            ]);
        }
    }

    /**
     * 编辑内容
     */
    public function edit() {
        $param = input('param.');
        $model = $this->model ? $this->model : request()->controller();
        try {
            $res = model($model)->get(['id' => $param['id']]);
        } catch (\Exception $e) {
            $this->result('', 0, $e->getMessage());
        }
        if ($res) {
            return $this->fetch('add', [
                'column' => config('column.lists'),
                'title' => $res['title'],
                'title_short' => $res['title_short'],
                'capid' => $res['capid'],
                'description' => $res['description'],
                'is_position' => $res['is_position'],
                'is_allowcomments' => $res['is_allowcomments'],
                'is_head_figure' => $res['is_head_figure'],
                'image' => $res['image'],
                'content' => $res['content']
            ]);
        } else {
            $this->result('', 0, '编辑失败');
        }
    }
}
