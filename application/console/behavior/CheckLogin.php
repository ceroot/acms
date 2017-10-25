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
 * @filename  CheckLogin.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-23 09:59:13
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\console\behavior;

use think\facade\Request;
use think\facade\Session;
use traits\controller\Jump;

class CheckLogin
{
    use Jump;

    public function run($params)
    {
        $controller = strtolower(Request::controller());

        // 开始页面不验证登录
        if ($controller == 'start') {
            return false;
        }

        Session::has('user_auth') || $this->redirect('Start/index'); // 用户判断 session

        Session::has('user_auth_sign') || $this->redirect('Start/index'); // 用户判断 session

        is_login() || $this->redirect('Start/index'); // 判断是否登录

        Session::has('manager_id') || $this->redirect('Start/index?backurl=' . getbackurl(false)); // 判断是否登录

    }
}
