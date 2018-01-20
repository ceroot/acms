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
 * @filename  CheckLogin.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-23 09:59:13
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\console\behavior;

use app\facade\User;
use think\facade\App;
use think\facade\Config;
use think\facade\Log;
use think\facade\Request;
use think\facade\Session;
use traits\controller\Jump;

class CheckLogin
{
    use Jump;

    public function run($params)
    {
        $this->initialization();
        $this->check();
    }

    /**
     * [ initialization 初始化 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-10-26T11:03:54+0800
     * @return   [type]                   [description]
     */
    private function initialization()
    {
        // User::isLogin();
    }

    /**
     * [ check 运行登录状态检查 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-10-26T11:04:10+0800
     * @return   [type]                   [description]
     */
    private function check()
    {
        $controller = strtolower(Request::controller()); // 取得控制器
        $action     = strtolower(Request::controller() . '/' . Request::action()); // 取得控制器

        // 不需要验证登录的控制器 'controller'
        $not_login_controller_default = [
            'start',
        ];

        $not_login_controller_config = Config::get('checklogin.not_login_controller') ?: []; // 读取配置
        $not_login_controller        = array_merge($not_login_controller_default, $not_login_controller_config);

        // 不需要验证登录的方法 'controller/action'
        $not_login_action_default = [

        ];

        $not_login_action_config = Config::get('checklogin.not_login_action') ?: []; // 读取配置
        $not_login_action        = array_merge($not_login_action_default, $not_login_action_config);

        if (
            in_array($controller, $not_login_controller) ||
            in_array($action, $not_login_action)
        ) {
            return true;
        }

        $loginurl = url('console/start/index?time=' . time()) . '?backurl=' . getbackurl();
        if (!User::isLogin()) {
            User::clearSession(); // 清除用户登录数据信息
            return $this->success('用户已经退出，请重新登录', $loginurl);
        }

        if (!$this->managerLogin()) {
            User::clearSession(); // 清除用户登录数据信息
            Session::pull('manager_id'); // 清除管理用户信息
            return $this->success('管理用户已经退出，请重新登录', $loginurl);
        }

        //Log::record('[ 检查登录日志 ]：管理用户 id 为' . Session::get('manager_id') . '登录成功');
    }

    /**
     * [ managerLogin 管理用户登录判断 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-11-06T13:33:38+0800
     * @return   [type]                   [0-没有登录，1-登录]
     */
    private function managerLogin()
    {
        if (!Session::has('manager_id')) {
            return 0;
        }
        if (Session::get('manager_id') == 1) {
            return 1;
        }
        return App::model('manager')->getFieldById(Session::get('manager_id'), 'status') ?: 0;
    }
}
