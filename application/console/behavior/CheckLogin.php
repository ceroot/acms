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
     * @Author   SpringYang <ceroot@163.com>
     * @DateTime 2017-10-26T11:03:54+0800
     * @return   [type]                   [description]
     */
    private function initialization()
    {

    }

    /**
     * [ check function_description ]
     * @Author   SpringYang <ceroot@163.com>
     * @DateTime 2017-10-26T11:04:10+0800
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

        Session::has('user_auth') || $this->redirect('Start/index'); // 用户判断 session

        Session::has('user_auth_sign') || $this->redirect('Start/index'); // 用户判断 session

        is_login() || $this->redirect('Start/index'); // 判断是否登录

        Session::has('manager_id') || $this->redirect('Start/index?backurl=' . getbackurl(false)); // 判断是否登录

        Log::record('[ 检查登录日志 ]：管理用户 id 为' . Session::get('manager_id') . '登录成功');
    }
}
