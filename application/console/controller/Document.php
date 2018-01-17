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

namespace app\console\controller;

use app\console\controller\Base;
use think\Db;

class Document extends Base
{
    public function initialize()
    {
        parent::initialize();

        $category = Db::name('category')->where('status', 1)->field('id,pid,title')->select();
        $this->assign('category', $category);

        $model_id   = Db::name('model')->getFieldByName('document', 'id');
        $model_list = Db::name('model')->where('extend', $model_id)->field('id,title')->select();
        $this->assign('model_list', $model_list);
    }

}
