<?php

namespace app\admin\controller;


class News extends Base {
    public function index() {
        $data      = input('param.');
        $query     = http_build_query($data);
        $whereData = [];
        if (!empty($data['start_time']) && !empty($data['end_time']) && $data['end_time'] > $data['start_time']) {
            $whereData['create_time'] = [
                ['gt', strtotime($data['start_time'])],
                ['lt', strtotime($data['end_time'])]
            ];
        }
        if (!empty($data['catid'])) {
            $whereData['catid'] = intval($data['catid']);
        }
        if (!empty($data['title'])) {
            $whereData['title'] = ['like', '%' . $data['title'] . '%'];
        }
        $this->getPageAndSize($data);
        $news      = model('News')->getNewsByCondition($whereData, $this->from, $this->size);
        $total     = model('News')->getNewsCountByCondition($whereData);
        $pageTotal = ceil($total / $this->size);
        return $this->fetch('', [
            'cats'       => config('cat.lists'),
            'news'       => $news,
            'pageTotal'  => $pageTotal,
            'curr'       => $this->page,
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time'   => empty($data['end_time']) ? '' : $data['end_time'],
            'catid'      => empty($data['catid']) ? '' : $data['catid'],
            'title'      => empty($data['title']) ? '' : $data['title'],
            'query'      => $query
        ]);
    }

    public function add() {
        if (request()->isPost()) {
            $data = input('post.');
            // 数据校验
            // 入库
            try {
                $id = model('News')->add($data);
            } catch (\Exception $e) {
                $this->result('', 0, '新增失败');
            }
            if ($id) {
                $this->result([
                    'jump_url' => url('news/index')
                ], 1, 'OK');
            } else {
                $this->result('', 0, '新增失败');
            }
        } else {
            return $this->fetch('', [
                'cats' => config('cat.lists')
            ]);
        }
    }
}