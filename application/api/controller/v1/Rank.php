<?php
namespace app\api\controller\v1;
use app\api\controller\Common;

class Rank extends Common {

    /**
     * 后续排行数据
     * 1. 获取数据，按照read_count进行排序，获取5-10条
     * 2. 可以把数据放在redis中 todo
     */
    public function index() {
        $num = config('app.rank_num');
        $data = model('News')->getNewsByRank($num);
        return show(config('code.success'), 'OK', $data, 200);
    }
}