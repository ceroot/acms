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

use app\facade\Auth;
use think\facade\App;
use think\facade\Cache;
use think\facade\Config;
use think\facade\Request;
use think\facade\Session;
use traits\controller\Jump;

class CheckAuth
{
    use Jump;

    public function run($params)
    {
        // dump(DIRECTORY_SEPARATOR);die;
        $this->check();
    }

    private function check()
    {
        if (strtolower(Request::controller()) == 'start') {
            return true;
        }
        // 判断 not_auth 是否存在
        if (!Cache::has('not_auth')) {
            App::model('AuthRule', 'logic')->updateCache();
        }

        $not_auth = Cache::get('not_auth'); // 从缓存里取得不需要进行权限认证的方法

        $controller = Request::controller(); // 取得控制器
        $action     = strtolower($controller . '/' . Request::action()); // 取得控制器
        // dump(Config::get('auth_superadmin'));die;
        // 验证权限
        // 满足条件
        // 1 不是超级管理员
        // 2 是必须验证的
        if (!in_array(Session::get('manager_id'), Config::get('auth_superadmin')) && !in_array($action, $not_auth)) {
            // 处理会员和管理员规则
            if ($controller == 'user' && input('role') == 1) {
                $controller = 'manager';
            }

            // 权限验证
            // 执行验证
            // if (!$this->authCheck($action, Session::get('manager_id'))) {
            //     $url = url('index/index?time=' . time()) . '?backurl=' . getbackurl();
            //     return $this->error('您没有相关权限，请联系管理员', $url);
            // }

            if (!Auth::check($action, Session::get('manager_id'))) {
                $url = url('index/index?time=' . time()) . '?backurl=' . getbackurl();
                return $this->error('您没有相关权限，请联系管理员', $url);
            }

        }

    }

}
