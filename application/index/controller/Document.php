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

use app\facade\Tools;
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
        // dump($getthemonth);
        $where = [
            ['create_time', 'between time', [$getthemonth[0], $getthemonth[1]]],
        ];
        $data = Db::name('Document')->where($where)->select();
        // dump($data);die;
        $count = Db::name('Document')->where('status', 1)->whereBetweenTime('create_time', $getthemonth[0], $getthemonth[1])->count();

        $gl = [
            ['month' => date('Ym', strtotime($startDate)), 'count' => $count],
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
            $whereTemp = [
                ['cid', '=', $cid],
            ];

            array_push($where, $whereTemp);

            $title = Db::name('Category')->getFieldById($cid, 'title');
        }

        $month     = Request::param('month');
        $whereTime = null;
        if ($month) {
            $monthArr = $this->getthemonth($month);
            // $whereBetweenTime = ['create_time', [$monthArr[0], $monthArr[1]]];
            $title = date('Y年m月', strtotime($month));

            $whereTemp = [
                ['create_time', 'between time', [$monthArr[0], $monthArr[1]]],
            ];
            array_push($where, $whereTemp);
        }
        // dump($whereBetweenTime);die;
        $data = Db::name('Document')->where($where)->order('id', 'desc')->select();

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
        Db::name('Document')->where('id', $id)->where('status', 1)->setInc('view'); // 记录访问次数
        $data = App::model('Document', 'logic')->getReader($id);
        // dump($data);
        $data || $this->error('没有数据');

        $prevId         = Tools::getPrevNextId('Document', $id);
        $nextId         = Tools::getPrevNextId('Document', $id, 1);
        $data['previd'] = $prevId;
        $data['nextid'] = $nextId;

        $this->assign('data', $data);
        // dump($data);die;

        return $this->fetch();

    }

    public function te($id)
    {
        $prevId = $this->getPrevNextId('Document', $id);
        // $nextId         = $this->getPrevNextId('Document', $id, 1);
        // $data['previd'] = $prevId;
        // $data['nextid'] = $nextId;

        dump($prevId);
    }

    public function getPrevNextId($table, $id, $type = 0)
    {
        $tempId = $id;
        if ($type) {
            $id     = $id + 1;
            $tipsId = Db::name($table)->max('id');
            $tips   = '未来在路上，请稍等……';
        } else {
            $id     = $id - 1;
            $tipsId = Db::name($table)->min('id');
            $tips   = '已经是第一个了';
        }

        if ($tempId == $tipsId) {
            return $tips;
        }

        $data = Db::name($table)->where('status', 1)->find($id);
        // dump($data);

        if (!$data) {
            $this->getPrevNextId($table, $id, $type);
            // return false;
        } else {
            $dataq = Db::name($table)->where('status', 1)->find($id);
            return $dataq['id'];
        }

    }

}
