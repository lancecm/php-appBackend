<?php
namespace app\common\lib\exception;
use think\exception\Handle;
use think\exception\HttpException;

class ApiHandleException extends Handle {

    public $httpcode = 500;

    public function render(\Exception $e) {
        if (config('app_debug')==true) {
            return parent::render($e);
        }
        if ($e instanceof ApiException) {
            $this->httpcode = $e->httpCode;
        }
        return show(0, $e->getMessage(),[], $this->httpcode);
    }
}
