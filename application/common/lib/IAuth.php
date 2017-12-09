<?php

namespace app\common\lib;


use think\Cache;

class IAuth {

    public static function setPassword($data) {
        return md5($data . config('app.password_pre_halt'));
    }

    public static function setSign($data = []) {
        // 1 按字段排序
        ksort($data);
        // 2 拼接数据
        $string = http_build_query($data);
        // 3 aes加密
        $string = (new Aes())->encrypt($string);
        return $string;
    }

    /*检查sign是否正常*/
    public static function checkSignPass($data) {
        $str = (new Aes())->decrypt($data['sign']);
        if (empty($str)) {
            return false;
        }
        parse_str($str, $arr);
        if (!is_array($arr) || empty($arr['did']) || $arr['did'] != $data['did']) {
            return false;
        }
        if ((time() - ceil($arr['time'] / 1000)) > config('app.app_sign_time')) {
            return false;
        }
        if (Cache::get($data['sign'])) {
            return false;
        }
        return true;
    }
}