<?php
namespace app\admin\controller;

use think\Controller;
use app\common\lib\IAuth;

class Login extends Controller
{
    public function index() {
        return $this->fetch();
    }
    /**
     * logout admin system
     */
    public function logout() {
        // 1. clear session
        session(null, config('admin.session_user_scope'));
        // 2. redirect to login page
        $this->redirect('login/index');
    }

    /**
     * 登录业务
     */
    public function check() {
        // check request type
        if (request()->isPost()) {
            $data = input('post.');
            if(!captcha_check($data['code'])) {
                $this->error('验证码不正确');
            } else {
                // validate data type
                $validate = validate('AdminUser'); // initialize a validator
                if (!$validate->check($data)) {
                    $this->error($validate->getError());
                }
                try {
                    $user = model('AdminUser')->get(['username' => $data['username']]); // return a object
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }
                // check user
                if (!$user) {
                    $this->error("用户名或密码错误");
                }
                // check password
                if (IAuth::setPassword($data['password']) != $user->password) {
                    $this->error("用户名或密码错误");
                }
                // check status
                if ($user->status != config('code.status_normal')) {
                    $this->error("用户状态异常");
                }
                // 1. update database: login time, login ip, etc.
                $udata = [
                    'last_login_time' => time(),
                    'last_login_ip' => request()->ip()
                ];
                try {
                    model('AdminUser')->save($udata, ['id' => $user->id]);
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }
                // 2. put data into session
                session(config('admin.session_user'), $user, config('admin.session_user_scope'));
                $this->success('登录成功', 'admin\index');
            }
        }
        else {
            $this->error("请求不合法");
        }
    }
}
