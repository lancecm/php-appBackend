<?php
namespace app\api\controller;
use think\Controller;
use app\common\lib\exception\ApiException;

class Time extends Controller {
    public function index() {
//        return [time()];
        return show(1, 'OK', time(), 201);
    }
}