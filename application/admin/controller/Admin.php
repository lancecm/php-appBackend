<?php
namespace app\admin\controller;

use think\Controller;
use think\Exception;

class Admin extends Base
{
    public function add() {
        if (request() -> isPost()) {
//            dump(input('post.'));
//            halt(); // = dump + exit
            $data = input('post.');
            $validate = validate('AdminUser');
            if (!$validate->check($data)) {
                $this->error($validate -> getError());
            }

            // md5 with salt
            $data['password'] = md5($data['password'].'_#salt_!');
            $data['status'] = 1;
            try {
                $id = model('AdminUser')->add($data);
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
            if ($id) {
                $this->success("id=".$id."的用户新增成功");
            } else {
                $this->error("error");
            }
        }
        else {
            return $this->fetch();
        }
    }
}
