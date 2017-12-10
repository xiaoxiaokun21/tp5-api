<?php

namespace app\common\model;


class Version extends Base {
    public function getLastVersionByAppType($appType = '') {
        $data  = [
            'status'   => 1,
            'app_type' => $appType
        ];
        $order = [
            'id' => 'desc'
        ];
        return $this->where($data)
            ->order($order)
            ->limit(1)
            ->find();
    }
}