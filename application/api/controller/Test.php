<?php

namespace app\api\controller;


use app\common\lib\exception\ApiException;
use think\Controller;

class Test extends Common {
    public function index() {
        return show(1, '成功', [1, 2, 3]);
    }
}