<?php
namespace app\api\controller\v1;
use app\api\controller\Common;

class Index extends Common {

    /**
     * 获取首页接口
     * 1. 头图 4-6
     * 2. 推荐位列表 40条
     */
    public function index() {
        // 头图
        $head_data = model('News')->getHeadNews();
        // 推荐位
        $recommend_data = model('News')->getRecommendNews();
        // 封装数据
        // 1. 客户端转换 （代码=>文字）
        // 2. 服务端转换
        $head_data = $this->dealNews($head_data);
        $recommend_data = $this->dealNews($recommend_data);
        $result = [
            'heads' => $head_data,
            'positions' => $recommend_data
        ];
        return show(config('code.success'), 'OK', $result, 201);
    }
}