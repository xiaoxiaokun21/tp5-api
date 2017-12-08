<?php

namespace app\admin\controller;


use app\common\lib\IAuth;
use think\Controller;

class Login extends Controller {
    public function index() {
        return $this->fetch();
    }

    // 登录相关业务
    public function check() {
        if (request()->isPost()) {
            $data = input('post.');
            if (!captcha_check($data['code'])) {
                $this->error('验证码不正确');
            }
            $validate = validate('AdminUser');
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            $user = model('AdminUser')->get(['username' => $data['username']]);
            if (!$user && $user->status === 1) {
                $this->error('该用户不存在');
            }
            // 对密码校验
            if (IAuth::setPassword($data['password']) != $user['password']) {
                $this->error('密码不正确');
            }
            halt($user);
        } else {
            $this->error('请求不合法');
        }
    }
}