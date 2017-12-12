<?php

namespace app\api\controller\v1;


use app\api\controller\Common;
use app\common\lib\Aes;
use app\common\lib\IAuth;
use app\common\model\User;

class Login extends Common {
    public function save() {
        if (!request()->isPost()) {
            return show(config('code.app_show_error'), '没权限', '', 403);
        }
        $param = input('param.');
        if (empty($param['phone'])) {
            return show(config('code.error'), '手机不合法', '', 404);
        }
        if (empty($param['code'])) {
            return show(config('code.error'), '手机短信验证码不合法', '', 404);
        }
        $code = Alidayu::checkSmsIdentify($param['phone']);
        if ($code != $param['code']) {
            return show(config('code.error'), '手机短信验证码不存在', '', 404);
        }
        $token = IAuth::setAppLoginToken($param['phone']);
        $data  = [
            'token'    => $token,
            'time_out' => strtotime("+" . config('app.login_time_out_day') . " days"),
            'username' => 'tp5-' . $param['phone'],
            'phone'    => $param['phone']
        ];
        $id    = model('User')->add($data);
        $obj   = new Aes();
        if ($id) {
            $result = [
                'token' => $obj->encrypt($token . "||" . $id . "||" . time())
            ];
            return show(config('code.app_show_success'), '登陆成功', $result);
        }
    }
}