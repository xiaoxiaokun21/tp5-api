<?php

namespace app\api\controller\v1;


use app\api\controller\Common;

class News extends Common {
    public function index() {
        $data                = input('get.');
        $whereData['status'] = config('code.status_normal');
        if (!empty($data['catid'])) {
            $whereData['catid'] = input('get.catid', 0, 'intval');
        }
        if (!empty($data['title'])) {
            $whereData['title'] = ['like', '%' . $data['title'] . '%'];
        }
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