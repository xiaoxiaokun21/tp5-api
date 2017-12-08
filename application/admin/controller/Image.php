<?php

namespace app\admin\controller;


use app\common\lib\Upload;
use think\Request;

class Image extends Base {
    public function upload0() {
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

    /*七牛图片上传*/
    public function upload() {
        try {
            $image = Upload::image();
        } catch (\Exception $e) {
            return json_encode(['status' => 0, 'message' => $e->getMessage()]);
        }
        if ($image) {
            $data = [
                'status'  => 1,
                'message' => 'ok',
                'data'    => config('qiniu.image_url') . '/' . $image
            ];
            return json_encode($data);
        } else {
            return json_encode(['status' => 0, 'message' => 'error']);
        }
    }
}