<?php

namespace app\api\controller;


use app\common\lib\exception\ApiException;
use think\Controller;

class Test extends Controller {
    public function index() {
        throw new ApiException('asdf', 403);
        return [
            123 => $dsa
        ];
    }
}