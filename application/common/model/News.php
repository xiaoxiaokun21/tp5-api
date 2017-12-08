<?php

namespace app\common\model;


class News extends Base {
    /*后台自动化分页*/
    public function getNews($data = []) {
        $data['status'] = [
            'neq', config('code.status_delete')
        ];
        $order          = ['id' => 'desc'];
        // 查询
        $result = $this->where($data)
            ->order($order)
            ->paginate();
        return $result;
    }
}