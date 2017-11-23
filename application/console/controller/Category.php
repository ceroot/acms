<?php
// +----------------------------------------------------------------------+
// | CYCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2017 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  Action.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-27 16:44:07
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\controller;

use app\console\controller\Base;
use data\Data;

class Category extends Base
{
    public function initialize()
    {
        parent::initialize();
        $category = $this->model->all();
        $category = $category->toArray();

        $newcategory = [];
        foreach ($category as $value) {
            $value['editid'] = authcode($value['id']);
            $newcategory[]   = $value;
        }
        $category = Data::tree($newcategory, 'title', 'id', 'pid');
        $this->assign('category', $category);

    }
}
