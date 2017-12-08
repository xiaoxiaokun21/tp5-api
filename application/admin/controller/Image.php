<?php

namespace app\admin\controller;


use think\Request;

class Image extends Base {
    public function upload() {
        $file = Request::instance()->file('file');
        // 把图片上传到指定文件夹
        $info = $file->move('upload');
        if ($info && $info->getPathname()) {
            $data = [
                'status'  => 1,
                'message' => 'ok',
                'data'    => '/' . $info->getPathname()
            ];
            return json_encode($data);
        }
        return json_encode(['status' => 0, 'message' => 'error']);
    }
}