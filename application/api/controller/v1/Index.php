<?php

namespace app\api\controller\v1;


use app\api\controller\Common;
use app\common\lib\exception\ApiException;
use think\Log;

class Index extends Common {
    public function index() {
        $heads     = model('News')->getIndexHeadNormalNews();
        $positions = model('News')->getPositionNormalNews();
        $result    = [
            'heads'     => $this->getDealNews($heads),
            'positions' => $this->getDealNews($positions)
        ];
        return show(config('code.app_show_success'), 'OK', $result);
    }

    /*客户端初始化接口
    1 检测是否升级
    */
    public function init() {
        $version = model('Version')->getLastVersionByAppType($this->header['apptype']);
        if (empty($version)) {
            throw new ApiException('error', 404);
        }
        if ($version->version > $this->header['version']) {
            $version->is_update = $version->is_force == 1 ? 2 : 1;
        } else {
            $version->is_update = 0;
        }
        $actives = [
            'version'  => $this->header['version'],
            'app_type' => $this->header['apptype'],
            'did'      => $this->header['did']
        ];
        try {
            model('AppActive')->add($actives);
        } catch (\Exception $e) {
            Log::write($e->getMessage());
        }
        return show(config('code.success'), 'ok', $version);
    }
}