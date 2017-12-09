<?php

namespace app\api\controller\v1;


use app\api\controller\Common;
use app\common\lib\exception\ApiException;

class Rank extends Common {
    public function index() {
        try {
            $ranks = model('News')->getRankNormalNews();
            $ranks = $this->getDealNews($ranks);
        } catch (\Exception $e) {
            throw new ApiException('error', 400);
        }
        return show(config('code.success'), 'OK', $ranks);
    }
}