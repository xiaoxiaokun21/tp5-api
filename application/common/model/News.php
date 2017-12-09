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
    public function getNewsByCondition($condition = [], $from = 0, $size) {
        $condition['status'] = [
            'neq', config('code.status_delete')
        ];
        $order               = ['id' => 'desc'];
        $result              = $this->where($condition)
            ->limit($from, $size)
            ->order($order)
            ->select();
        return $result;
    }

    /* 获取列表数据的总数*/
    public function getNewsCountByCondition($condition = []) {
        $condition['status'] = [
            'neq', config('code.status_delete')
        ];
        return $this->where($condition)
            ->count();
    }

    /*获取头图*/
    public function getIndexHeadNormalNews($num = 4) {
        $data  = [
            'status'         => 1,
            'is_head_figure' => 1
        ];
        $order = [
            'id' => 'desc'
        ];
        return $this->where($data)
            ->field($this->_getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }

    /*获取推荐的数据*/
    public function getPositionNormalNews($num = 20) {
        $data  = [
            'status'      => 1,
            'is_position' => 1
        ];
        $order = [
            'id' => 'desc'
        ];
        return $this->where($data)
            ->field($this->_getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }

    /*通用获取参数的数据字段*/
    private function _getListField() {
        return [
            'id', 'catid', 'image', 'title', 'read_count'
        ];
    }
}