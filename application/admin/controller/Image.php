<?php

namespace app\admin\controller;


class Image extends Base {
    public function upload() {
        $data = [
            'status' => 1,
            'message'=>'OK',
            'data'=>'http://pic4.nipic.com/20091217/3885730_124701000519_2.jpg'
        ];
        echo json_encode($data);
    }
}