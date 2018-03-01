<?php
// +----------------------------------------------------------------------+
// | BWCMS                                                                |
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

    }

    public function index()
    {
        $data = Db::name('Document')->where('status', 1)->limit(2)->select();
        dump($data);
    }

    public function lists()
    {
        $title = '文档列表';

        $where = [
            ['status', '=', 1],
        ];

        if (Request::has('id') && !empty(Request::param('id'))) {
            $cid = Request::param('id');
            // dump($cid);
            $whereTemp = [
                ['cid', '=', $cid],
            ];

            array_push($where, $whereTemp);

            $title = Db::name('Category')->getFieldById($cid, 'title');
        }
        dump($where);
        die;
        if (Request::has('month')) {
            $month    = Request::param('month');
            $month    = $month . '01';
            $monthArr = Tools::getFirstLastDayMonth($month);
            $title    = date('Y年m月', strtotime($month));

            $whereTemp = [
                ['create_time', 'between time', [$monthArr[0], $monthArr[1]]],
            ];
            array_push($where, $whereTemp);
        }
        dump($where);
        die;
        $data = Db::name('Document')->where($where)->order('id', 'desc')->select();
        // dump($data);die;
        $list = [];
        foreach ($data as $value) {
            $coverId        = $value['cover_id'];
            $coverData      = Db::name('picture')->find($coverId);
            $value['cover'] = $coverData['path'];
            $list[]         = $value;
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

        $prevData         = Tools::getPrevNextId('Document', $id);
        $nextData         = Tools::getPrevNextId('Document', $id, 1);
        $data['prevData'] = $prevData;
        $data['nextData'] = $nextData;

        $this->assign('data', $data);
        // dump($data);die;

        return $this->fetch();

    }

}
