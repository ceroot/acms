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
 * @filename  Base.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-01-12 14:35:48
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\index\controller;

use app\common\controller\Extend;

class Base extends Extend
{

    public function initialize()
    {
        parent::initialize();

        $menuData = model('Category')->getMenu();
        $this->assign('menuData', $menuData);

    }
}
