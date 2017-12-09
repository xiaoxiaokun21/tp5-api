<?php

namespace app\api\controller\v1;


use app\api\controller\Common;

class News extends Common {
    public function index() {
        $data                = input('get.');
        $whereData['status'] = config('code.status_normal');
        $whereData['catid']  = input('get.catid');
        $this->getPageAndSize($data);
        $total  = model('News')->getNewsCountByCondition($whereData);
        $news   = model('News')->getNewsByCondition($whereData, $this->from, $this->size);
        $result = [
            'total'    => $total,
            'page_num' => ceil($total / $this->size),
            'list'     => $this->getDealNews($news)
        ];
        return show(1, 'OK', $result);
    }
}