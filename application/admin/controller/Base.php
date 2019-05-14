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
}

