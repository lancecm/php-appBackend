<?php
namespace app\api\controller;
use think\Controller;

class Test extends Controller {
    public function index() {
        return [
            'sdf',
            'sdfae'
        ];
    }

    public function update($id = 0) {echo $id; exit;
        $id = input('put.id');
        return $id;
    }

    public function save() {
        return input('post.');
    }
}