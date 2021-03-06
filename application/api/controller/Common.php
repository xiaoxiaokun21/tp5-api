<?php

namespace app\api\controller;


use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use app\common\lib\IAuth;
use app\common\lib\Time;
use think\Cache;
use think\Controller;

class Common extends Controller {
    public $header = [];
    public $page = 1;
    public $size = 10;
    public $from = 0;

    public function _initialize() {
        $this->checkRequestAuth();
    }

    /*检查每次app请求是否合法*/
    public function checkRequestAuth() {
        $header = request()->header();
        if (empty($header['sign'])) {
            throw new ApiException('sign不存在', 400);
        }
        if (!in_array($header['apptype'], config('app.apptypes'))) {
            throw new ApiException('app_type类型不合法', 400);
        }
        if (!IAuth::checkSignPass($header)) {
            throw new ApiException('授权码sign失败', 401);
        }
        Cache::set($header['sign'], 1, config('app.app_sign_cache_time'));
        $this->header = $header;
    }

    public function testss() {
        $data = [
            'did'  => 213,
            'name' => 'yangze',
            'time' => Time::get13TimeStamp()
        ];
        echo IAuth::setSign($data);


        echo((new Aes())->decrypt(IAuth::setSign($data)));
    }

    protected function getDealNews($news = []) {
        if (empty($news)) {
            return [];
        }
        $cats = config('cat.lists');
        foreach ($news as $k => $new) {
            $news[$k]['catname'] = $cats[$new['catid']] ? $cats[$new['catid']] : '-';
        }
        return $news;
    }

    /*获取分页page size 内容*/
    public function getPageAndSize($data) {
        $this->page = !empty($data['page']) ? $data['page'] : 1;
        $this->size = !empty($data['size']) ? $data['size'] : config('paginate.list_rows');
        $this->from = ($this->page - 1) * $this->size;

    }
}