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
 * @filename  User.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-11-23 14:48:06
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\facade;

use think\Facade;

class Tools extends Facade
{

    protected static function getFacadeClass()
    {
        return 'app\common\structure\Tools';
    }
}
