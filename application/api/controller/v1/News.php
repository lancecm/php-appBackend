<?php
namespace app\api\controller\v1;
use app\api\controller\Common;
use app\common\lib\exception\ApiException;

class News extends Common {
    public $page = 1;
    public $size = 10;
    public $from = 0;

    // 获取新闻列表
    public function index() {
        $inputParam = input('get.');
        $param['status'] = config('code.status_normal');
        // 针对搜索
        if (!empty($inputParam['capid'])) {
            $param['capid'] = input('get.catid', 0, 'intval');
        }
        if (!empty($inputParam['title'])) {
            $param['title'] = ['like', "%".$inputParam['title']."%"];
        }
        $this->getPageAndSize($inputParam);
        $count = model('News')->getNewsCountByCondition($param);
        $data = model('News')->getNewsByCondition($param, $this->from, $this->size);
        $result = [
            'total' => $count,
            'page_num' => ceil($count / $this->size),
            'data' => $data
        ];
        return show(config('code.success'), 'OK', $result, 200);
    }

    // 获取详情页数据
    public function read() {
        // 另一种方法：html5 提供地址就行 x.om/3.html
        $id = input('param.id', 0, 'intval');
        if (empty($id)) {
            return show(config('code.fail'), 'id不存在', '', 404);
        }
        $news = model('News')->get($id);
        if (empty($news) || $news->status!=config('code.status_normal')) {
            return show(config('code.fail'), 'id不存在', '', 400);
        }
        try {
            model('News')->where(['id'=>$id])->setInc('read_count');
        } catch (\Exception $e) {
            return new ApiException('error', 400);
        }
        $cats = config('column.lists');
        $news->catname = $cats[$news->capid];
        return show(config('code.success'), 'OK', $news, 200);
    }




    /**
     * 获取分页page, sie
     */
    public function getPageAndSize($param) {
        $this->page = !empty($param['page']) ? $param['page'] : 1;
        $this->size = !empty($param['size']) ? $param['size'] :
            config('paginate.list_rows');
        $this->from = ($this->page - 1) * $this->size;
    }
}