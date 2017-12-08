<?php

namespace app\admin\controller;


class News extends Base {
    public function index() {
        return $this->fetch();
    }

    public function add() {
        if (request()->isPost()) {
            $data = input('post.');
            // 数据校验
            // 入库
            try {
                $id = model('News')->add($data);
            } catch (\Exception $e) {
                return $this->result('', 0, '新增失败');
            }
            if ($id) {
                return $this->result([
                    'jump_url' => url('news/index')
                ], 1, 'OK');
            } else {
                return $this->result('', 0, '新增失败');
            }
        } else {
            return $this->fetch('', [
                'cats' => config('cat.lists')
            ]);
        }
    }
}