<?php

namespace app\admin\controller;


use app\common\lib\IAuth;

class Admin extends Base {
    public function add() {
        $this->model = 'AdminUser';
        if (request()->isPost()) {
            $data     = input('post.');
            $validate = validate('AdminUser');
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            $data['password'] = IAuth::setPassword($data['password']);
            $data['status']   = 1;
            try {
                $id = model('AdminUser')->add($data);
            } catch (\Exception $e) {
                $this->error($e->getMessage(), null, '', 20);
            }
            if ($id) {
                $this->success('id=' . $id . '的用户新增成功');
            } else {
                $this->error('error');
            }
        } else {
            return $this->fetch();
        }
    }
}