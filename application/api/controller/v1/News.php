<?php

namespace app\api\controller\v1;


use app\api\controller\Common;
use app\common\lib\exception\ApiException;

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

    public function read() {
        $id = input('param.id', 0, 'intval');
        if (empty($id)) {
            throw new ApiException('id error', 400);
        }
        $news = model('News')->get($id);
        if (empty($news) | $news->status != config('code.status_normal')) {
            throw new ApiException('新闻不存在', 400);
        }
        try {
            model('News')->where(['id' => $id])->setInc('read_count');
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 400);
        }
        $cats          = config('cat.lists');
        $news->catname = $cats[$news->catid];
        return show(1, 'OK', $news);
    }
}