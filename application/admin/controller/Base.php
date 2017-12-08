<?php

namespace app\admin\controller;


use think\Controller;

class Base extends Controller {
    public $page = '';
    public $size = '';
    public $from = 0;
    public $model = '';

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

    /*删除逻辑*/
    public function delete($id = 0) {
        if (!intval($id)) {
            $this->result('', 0, 'ID不合法');
        }
        $model = $this->model ? $this->model : request()->controller();
        try {
            $res = model($model)->save(['status' => -1], ['id' => $id]);
        } catch (\Exception $e) {
            $this->result('', 0, $e->getMessage());
        }
        if ($res) {
            $this->result(['jump_url' => $_SERVER['HTTP_REFERER']], 1, 'ok');
        }
        $this->result('', 1, '失败');
    }

    /*修改状态*/
    public function status() {
        $data = input('param.');
        $model = $this->model ? $this->model : request()->controller();
        try {
            $res = model($model)->save(['status' => $data['status']], ['id' => $data['id']]);
        } catch (\Exception $e) {
            $this->result('', 0, $e->getMessage());
        }
        if ($res) {
            $this->result(['jump_url' => $_SERVER['HTTP_REFERER']], 1, 'ok');
        }
        $this->result('', 1, '失败');
    }
}