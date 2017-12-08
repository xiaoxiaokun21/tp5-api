<?php

namespace app\admin\controller;


use think\Controller;

class Base extends Controller {
    public $page = '';
    public $size = '';
    public $from = 0;

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

    /*获取分页page size 内容*/
    public function getPageAndSize($data) {
        $this->page = !empty($data['page']) ? $data['page'] : 1;
        $this->size = !empty($data['size']) ? $data['size'] : config('paginate.list_rows');
        $this->from = ($this->page - 1) * $this->size;

    }
}