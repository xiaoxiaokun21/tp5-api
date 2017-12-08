<?php

namespace app\common\lib;

// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;

/*七牛图片上传基础类库*/

class Upload {
    public static function image() {
        if (empty($_FILES['file']['tmp_name'])) {
            exception('您提交的图片数据不合法', 404);
        }
        // 要上传的文件
        $file     = $_FILES['file']['tmp_name'];
        $pathinfo = pathinfo($_FILES['file']['name']);
        $ext      = $pathinfo['extension'];
        $config   = config('qiniu');
        //构建鉴权对象
        $auth = new Auth($config['ak'], $config['sk']);
        // 生成上传的token
        $token = $auth->uploadToken($config['bucket']);
        // 上传到七牛云后保存的文件名
        $key = date('Y') . '/' . date('m') . '/' . substr(md5($file), 0, 5) . date('YmdHis') . rand(0, 9999) . '.' . $ext;
        // 初始化UploadManager
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($token, $key, $file);
        if ($err !== null) {
            return null;
        } else {
            return $key;
        }
    }
}