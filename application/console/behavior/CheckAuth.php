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
 * @filename  CheckAuth.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-23 09:52:55
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\console\behavior;

use think\facade\Request;
use traits\controller\Jump;

class CheckAuth
{
    use Jump;

    public function run($params)
    {
        $controller = Request::controller();
        dump('CheckAuth');
    }
}
