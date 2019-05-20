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
     * @var string
     * 对应model层
     */
    public $model = '';

    /**
     * _initialize: if extend Base, must execute this function first
     */
    public function _initialize() {
        $isLogin = $this->isLogin();
        if (!$isLogin) {
            $this->redirect('login/index');
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

    /**
     * 删除逻辑
     */
    public function delete($id) {
        if (!intval($id)) {
            $this->result('',0, 'ID 不合法');
        } else {
            // 通过id去数据库中查询记录是否存在 略

            // 获取当前控制器名字
            // 对于model层和控制器名称不一样的情况，用成员变量保存对应的model层
            $model = $this->model ? $this->model : request() -> controller();
            // php7的写法  $model = $this->model ?? request() -> controller();
            try {
                $res = model($model) -> save(['status'=>-1], ['id' => $id]);
            } catch (\Exception $e) {
                $this->result('', 0, $e->getMessage());
            }
            if ($res) {
                $this->result(['jump_url' => $_SERVER['HTTP_REFERER']], 1, '删除成功');
            }
            else {
                $this->result('', 0, '删除失败');
            }
        }
    }

    /**
     * 状态转换
     */
    public function status() {
        $param = input('param.');
        // 数据校验 略
        $model = $this->model ? $this->model : request() -> controller();
        // 通过id去数据库中查询记录是否存在
        if (!model($model)->get($param['id'])) {
            $this->result('', 0, '记录不存在');
        }
        try {
            $res = model($model) -> save(['status'=>$param['status']], ['id' => $param['id']]);
        } catch (\Exception $e) {
            $this->result('', 0, $e->getMessage());
        }
        if ($res) {
            $this->result(['jump_url' => $_SERVER['HTTP_REFERER']], 1, '修改成功');
        }
        else {
            $this->result('', 0, '修改失败');
        }
    }

}

