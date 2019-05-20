<?php
namespace app\admin\controller;

use think\Controller;

/**
 * 后台基础类库
 * Class Base
 * @package app\admin\controller
 */
class Base extends Controller
{

    /**
     * @var string
     * 分页所需
     */
    public $page = '';
    public $size = '';
    public $from = '';

    /**
     * _initialize: if extend Base, must execute this function first
     */
    public function _initialize() {
        $isLogin = $this->isLogin();
        if (!$isLogin) {
            return $this->redirect('login/index');
        }
    }

    /**
     * check user login
     */
    public function isLogin() {
        // retrieve session
        $user = session(config('admin.session_user'), '',
            config('admin.session_user_scope'));
        if ($user && $user->id) {
            return true;
        }
        return false;
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

