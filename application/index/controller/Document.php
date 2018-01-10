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

use app\common\controller\Extend;
use think\Db;
use think\facade\App;

class Document extends Extend
{
    public function initialize()
    {
        parent::initialize();

        $category = Db::name('Document')->where('status', 1)->select();

    }

    public function index()
    {
        $data = Db::name('Document')->where('status', 1)->limit(2)->select();
        dump($data);
    }

    public function lists()
    {
        $list = Db::name('Document')->select();
        $this->assign('list', $list);

        return $this->fetch();
    }

    public function reader($id)
    {
        $id || $this->error('参数错误');
        // $id                = deauthor($id);
        $data = App::model('Document', 'logic')->getReader($id);

        // dump($data);

        $this->assign('data', $data);

        return $this->fetch();

    }

}
