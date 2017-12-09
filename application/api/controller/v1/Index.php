<?php

namespace app\api\controller\v1;


use app\api\controller\Common;

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
}