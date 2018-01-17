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
 * @filename  User.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-25 14:16:14
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\facade;

use think\Facade;

class User extends Facade
{

    protected static function getFacadeClass()
    {
        return 'app\common\structure\User';
    }
}
