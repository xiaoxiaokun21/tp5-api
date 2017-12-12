<?php

namespace app\api\controller;


use app\common\lib\IAuth;
use think\Controller;

class Test extends Controller {
    public function index() {
        \SmsDemo::sendSms();
        return show(1, '成功', [1, 2, 3]);
    }

    public function token() {
        echo IAuth::setAppLoginToken();
    }
}