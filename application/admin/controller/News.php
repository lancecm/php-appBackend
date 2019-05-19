<?php
namespace app\admin\controller;

use think\Controller;

class News extends Base
{
    public function index() {
        $news = model('News')->getNews();
        return $this->fetch('', [
            'news' => $news,
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
