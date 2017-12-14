<?php

namespace app\api\controller\v1;


use app\api\controller\Common;
use app\common\lib\Aes;
use app\common\lib\exception\ApiException;

class AutoBase extends Common {
    public $user = [];

    public function _initialize() {
        parent::_initialize();
        if (empty($this->isLogin())) {
            throw new ApiException('您没有登录', 401);
        }
    }

    /* 判断是否登录*/
    public function isLogin() {
        if (empty($this->header['access_user_token'])) {
            return false;
        }
        $obj             = new Aes();
        $accessUserToken = $obj->decrypt($this->header['access_user_token']);
        if (empty($accessUserToken)) {
            return false;
        }
        if (!preg_match('/||/', $accessUserToken)) {
            return false;
        }
        list($token, $id) = explode('||', $accessUserToken);
        $user = User::get(['token' => $token]);
        if (!$user || $user->status != 1) {
            return false;
        }
        if (time() > $user->time_out) {
            return false;
        }
        $this->user = $user;

    }
}