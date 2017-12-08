<?php

namespace app\admin\controller;


use think\Controller;

class Base extends Controller {
    public function _initialize() {
        if (!$this->isLogin()) {
            $this->redirect('login/index');
        }
    }

    public function isLogin() {
        $user = session(config('admin.session_user'), '', config('admin.session_user_scope'));
        if ($user && $user->id) {
            return true;
        }
        return false;
    }
}