<?php
// +----------------------------------------------------------------------+
// | CYCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2018 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  Document.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-11-29 10:33:12
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\index\controller;

use app\index\controller\Base;
use think\Db;
use think\facade\App;
use think\facade\Request;

class Document extends Base
{
    public function initialize()
    {
        parent::initialize();
        $startDate = Db::name('Document')->find();
        $startDate = date('Ymd', $startDate['create_time']);

        $getthemonth = $this->getthemonth($startDate);
        $count       = Db::name('Document')->whereBetweenTime('create_time', $getthemonth[0], $getthemonth[1])->count();

        $gl = [
            ['title' => date('Y年m月', strtotime($startDate)), 'month' => date('Ym', strtotime($startDate)), 'count' => $count],
        ];
        $this->assign('gl', $gl);

    }

    public function getthemonth($date)
    {
        $firstday = date('Y-m-01', strtotime($date));
        $lastday  = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
        return array($firstday, $lastday);
    }

    public function index()
    {
        $data = Db::name('Document')->where('status', 1)->limit(2)->select();
        dump($data);
    }

    public function lists()
    {
        $cid   = Request::param('id');
        $where = [
            ['status', '=', 1],
        ];

        $title = '文档列表';
        if ($cid) {
            $where = [
                ['cid', '=', $cid],
            ];

            $title = Db::name('Category')->getFieldById($cid, 'title');
        }

        $month     = Request::param('month');
        $whereTime = null;
        if ($month) {
            $monthArr         = $this->getthemonth($month);
            $whereBetweenTime = ['create_time', [$monthArr[0], $monthArr[1]]];
            $title            = date('Y年m月', strtotime($month));

            $whereTime = [
                'create_time', 'between', [$monthArr[0], $monthArr[1]],
            ];
        }
        // dump($whereBetweenTime);die;
        $data = Db::name('Document')->where($where)->whereTime($whereTime)->order('id', 'desc')->select();

        $list = [];
        foreach ($data as $value) {
            $coverId        = $value['cover_id'];
            $coverData      = Db::name('picture')->find($coverId);
            $value['cover'] = $coverData['path'];
            $list[]         = $value;
            # code...
        }
        $this->assign('list', $list);
        $this->assign('title', $title);

        return $this->fetch();
    }

    public function reader($id)
    {
        $id || $this->error('参数错误');
        // $id                = deauthor($id);
        Db::name('Document')->where('id', $id)->setInc('view'); // 记录访问次数
        $data = App::model('Document', 'logic')->getReader($id);

        $this->assign('data', $data);

        return $this->fetch();

    }

}
