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

    /*根据条件获取列表数据*/
    public function getNewsByCondition($param = []) {
        $condition['status'] = [
            'neq', config('code.status_delete')
        ];
        $order               = ['id' => 'desc'];
        $from                = ($param['page'] - 1) * $param['size'];
        $result              = $this->where($condition)
            ->limit($from, $param['size'])
            ->order($order)
            ->select();
        return $result;
    }

    /* 获取列表数据的总数*/
    public function getNewsCountByCondition($param = []) {
        $condition['status'] = [
            'neq', config('code.status_delete')
        ];
        return $this->where($condition)
            ->count();
    }
}